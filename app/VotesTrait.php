<?php 

namespace App;

/**
 *  Trait for entities that are votable
 */
trait VotesTrait
{   
    /**
     * Polymorph relation. 
     * Returns relation of specific entity that are votable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    /**
     * Returns votes relation filtered by positive votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    /**
     * Returns votes relation filtered by negative votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
