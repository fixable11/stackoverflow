<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    use VotesTrait;

    /**
     * List of elements for mass assignment
     *
     * @var array
     */
    protected $fillable = ['body', 'user_id'];

    /**
     * Realizes eager loading
     *
     * @var array
     */
    protected $with = ['question'];

    /**
     * The accessor to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_date', 'body_html', 'is_best'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
            $answer->question->save();
        });

        static::deleted(function($answer){
            $question = $answer->question;
            $question->decrement('answers_count');

            if($question->best_answer_id === $answer->id){
                $question->best_answer_id = NULL;
                $question->save();
            }
        });
    }

    /**
     * Gets answer of the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Gets creator of the answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets body_html accessor.
     * Returns cleaned text 
     *
     * @return string
     */
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    /**
     * Gets created_date accessor
     *
     * @return void
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Gets status accessor
     *
     * @return void
     */
    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    /**
     * Gets is_best accessor
     *
     * @return void
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
    
    /**
     * Checks whether the answer marked as best
     *
     * @return void
     */
    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

}
