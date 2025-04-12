<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // randomly select 0 or 1
        $senderId = $this->faker->randomElement([0, 1]);

        if ($senderId == 0) {
            // make sure sender_id is not 1
            // because receiver is set to 1
            $senderId = $this->faker->randomElement(
                \App\Models\User::where('id', '!=', 1)->pluck('id')->toArray()
            );

            $receiverId = 1;
        } else {
            // if sender is one
            $receiverId = $this->faker->randomElement(
                \App\Models\User::where('id', '!=', 1)->pluck('id')->toArray()
            );
        }

        // set group id
        $groupId = null;

        if ($this->faker->boolean(50)) {
            $groupId = $this->faker->randomElement(
                \App\Models\Group::pluck('id')->toArray()
            );

            // makeing sure sender is present in the group
            $group = \App\Models\Group::find($groupId);
            $senderId = $this->faker->randomElement(
                $group->users->pluck('id')->toArray()
            );

            // set receiver to null; messsage is either sent to receiver or the group
            $receiverId = null;
        }

        return [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'group_id' => $groupId,
            'message' => $this->faker->realText(200),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
