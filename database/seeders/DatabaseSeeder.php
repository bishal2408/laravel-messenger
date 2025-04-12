<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();

        // make 5 different group chats
        for ($i = 0; $i < 5; $i++) {
            $group = Group::factory()->create([
                'owner_id' => 1,
            ]);

            $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');

            // make sure user_id is unique in group chat
            $group->users()->attach(array_unique([1, ...$users]));
        }

        // make 1000 messages
        Message::factory(1000)->create();

        // get messages for one to one conversation (not group chat)
        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

        // grouping by; here [user1, user2], [user2, user1] is considered same
        $conversations = $messages->groupBy(function ($message) {
            // returning key like [user1_user2]
            return collect(
                [$message->sender_id, $message->receiver_id]
            )->sort()->implode('_');
        
            // mapping with result set of each keys and returing array
        })->map(function ($groupedMessages) {
            return [
                'user_id1' => $groupedMessages->first()->sender_id,
                'user_id2' => $groupedMessages->first()->receiver_id,
                'last_message_id' => $groupedMessages->last()->id,
                'created_at' => new Carbon(),
                'updated_at' => new Carbon(),
            ];
        })->values();

        // inserting array id data to conversations
        Conversation::insertOrIgnore($conversations->toArray());
    }
}
