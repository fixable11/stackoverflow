<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\DuplicateTitleException;

class Question extends Model
{

    use VotesTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if($this->slug != str_slug($value) && static::where('slug', str_slug($value))->exists()){
            throw new DuplicateTitleException;
        }

        $this->attributes['slug'] = str_slug($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = clean($value);
    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if($this->answers_count > 0){
            return $this->best_answer_id ? 'answered-accepted' : 'answered';
        }
        return 'unanswered';
    }

    public function getBodyHtmlAttribute()
    {
        return $this->bodyHtml();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function acceptBestAnswer(Answer $answer)
    {   
        $this->best_answer_id = $answer->id;
        return $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'question_id', 'user_id')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    public static function getPopular()
    {
        return self::with('user')->orderBy('views', 'DESC');
    }
    
}
