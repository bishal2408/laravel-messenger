<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// Chennel to get online user and its resources
Broadcast::channel('online', function (User $user) {
    return $user ? new UserResource($user) : null;
});

// Channel for one-to-one communication
// The closure ensures that one channel is not duplicated twice
Broadcast::channel(
    'message.user.{userId1}-{userId2}',
    function (User $user, int $userId1, int $userId2) {
        // validating if current user has access to the channel
        return $user->id === $userId1 || $user->id === $userId2 ? $user : null;
    }
);

// Channel for group messages
Broadcast::channel(
    'message.group.{groupId}',
    function (User $user, int $groupId) {
        // validating if current user has access to the group
        return $user->groups->contains('id', $groupId) ? $user : null;
    }
);
