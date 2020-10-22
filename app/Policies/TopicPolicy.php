<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

/**
 * Class TopicPolicy
 * @package App\Policies 策略
 */
class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
         return $user->isAuthorOf($topic);
//        return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
//        return true;
    }
}
