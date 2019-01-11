<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\DuplicateTitleException;

class Question extends Model
{

    const DEFAULT_EXCERPT_SIZE = 250;

    use VotesTrait;

    /**
     * List of elements for mass assignment
     *
     * @var array
     */
    protected $fillable = ['title', 'body'];

    /**
     * Realizes eager loading
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Gets user relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Title attribute mutator
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if($this->slug != str_slug($value) && static::where('slug', str_slug($value))->exists()){
            throw new DuplicateTitleException;
        }

        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * Body attribute mutator.
     * Once body is assigned to the model it will be cleaned by purifier
     *
     * @param string $value
     * @return void
     */
    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = clean($value);
    }

    /**
     * Gets created_date accessor
     *
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * status attribute accessor
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if($this->answers_count > 0){
            return $this->best_answer_id ? 'answered-accepted' : 'answered';
        }
        return 'unanswered';
    }

    /**
     * is_favorited attribute accessor
     *
     * @return boolean
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * favorites_count attribute accessor
     *
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * excerpt attribute accessor
     *
     * @return string
     */
    public function getExcerptAttribute()
    {
        return $this->excerpt(self::DEFAULT_EXCERPT_SIZE);
    }

    /**
     * body_html attribute accessor
     *
     * @return Parsedown|string
     */
    public function getBodyHtmlAttribute()
    {
        return $this->bodyHtml();
    }

    /**
     * Answers relationship
     *
     * @return App\Answer
     */
    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    /**
     * Sets the best answer of the question
     *
     * @param Answer $answer
     * @return bool
     */
    public function acceptBestAnswer(Answer $answer)
    {   
        $this->best_answer_id = $answer->id;
        return $this->save();
    }

    /**
     * Favorites many-to-many relation through favorites table.
     * Returns user instance
     *
     * @return App\User;
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'question_id', 'user_id')->withTimestamps();
    }

    /**
     * Checks whether the current user favorited the question or not
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    /**
     * Returns question's excerpt
     *
     * @param int $length
     * @return string
     */
    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    /**
     * Returns cleaned question's body attribute
     *
     * @return Parsedown|string
     */
    private function bodyHtml()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    /**
     * Returns set of popular questions
     *
     * @return void
     */
    public static function getPopular()
    {
        return self::with('user')
            ->orderBy('votes_count', 'DESC')
            ->orderBy('created_at', 'DESC');
    }
    
}
