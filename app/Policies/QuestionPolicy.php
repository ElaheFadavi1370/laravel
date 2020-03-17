<?php

namespace App\Policies;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Question $question)

    {

        return $user->id === $question->user_id;

    }
    public function delete(User $user, Question $question)

    {
        return $user->id === $question->user_id && $question->answers_count() < 1;

    }
}
