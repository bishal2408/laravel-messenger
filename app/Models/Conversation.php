<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id1',
        'user_id2',
        'last_message_id',
    ];

    /**
     * lastMessage
     *
     * @return BelongsTo<, $this>
     */
    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    /**
     * user1
     *
     * @return BelongsTo<, $this>
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id1');
    }

    /**
     * user2
     *
     * @return BelongsTo<, $this>
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id2');
    }

    /**
     * getConversationsForSidebar
     *
     * @param User $user
     * @return mixed
     */
    public static function getConversationsForSidebar(User $user)
    {
        $users = User::getUsersExceptuser($user);
        $groups = Group::getGroupsForUser($user);

        return $users->map(function (User $user) {
            return $user->toConversationArray();
        })->concat($groups->map(function (Group $group) {
            return $group->toConversationArray();
        }));
    }
}
