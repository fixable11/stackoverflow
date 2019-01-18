<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Providing eager loading
     *
     * @var array
     */
    protected $with = ['meta'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token', 
        'created_at', 
        'updated_at',
        'email_verified_at',
    ];

    /**
     * Questions relationship 
     *
     * @return App\Question
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * User's personal page link
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return '#';
    }

    /**
     * Favorites many-to-many relation through favorites table.
     * Returns question instance
     *
     * @return App\Question;
     */
    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id')->withTimestamps();
    }

    /**
     * Meta one-to-one relation.
     * Returns UserMeta instance
     *
     * @return App\UserMeta;
     */
    public function meta()
    {
        return $this->hasOne(UserMeta::class);
    }

    /**
     * Polymorph questions' relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    /**
     * Polymorph answers' relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    /**
     * Increases or decreases question's rating
     *
     * @param Question $question
     * @param integer $vote (1 or -1)
     * @return void
     */
    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        
        $this->voteModel($voteQuestions, $question, $vote);
    }

    /**
     * Increases or decreases answer's rating
     *
     * @param Answer $answer
     * @param integer $vote (1 or -1)
     * @return void
     */
    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();

        $this->voteModel($voteAnswers, $answer, $vote);
    }

    /**
     * Increases or decreases votes of specific model
     *
     * @param \Illuminate\Database\Eloquent\Relations\MorphToMany $relationship
     * @param Illuminate\Database\Eloquent\Model $model
     * @param integer $vote (1 or -1)
     * @return void
     */
    private function voteModel($relationship, $model, $vote)
    {
        if($relationship->where('votable_id', $model->id)->exists()){
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model, ['vote' => $vote]);
        }

        $this->recountModelVotes($model);
        
    }

    /**
     * Recount votes_count column for specific model
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    private function recountModelVotes($model){
        $model->load('votes');

        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();
    }
}
