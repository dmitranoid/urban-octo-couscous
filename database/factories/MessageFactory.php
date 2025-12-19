<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $types = [
           Message::MSG_QUESTION,
           Message::MSG_PRICE,
           Message::MSG_CONTACT,
        ];

        $statuses = [
            Message::STATUS_NEW,
            Message::STATUS_READ,
        ];

        $type = $this->faker->randomElement($types);
        return [
            'created_at' => $this->faker->dateTimeBetween('-1 month'),
            'code' => strtoupper(Str::substr($type, 0, 1)) . '-' . Str::padLeft(random_int(50, 1000), 5, '0') ,
            'author' => $this->faker->name,
            'type' => $type,
            'status' => $this->faker->randomElement($statuses),
            'message' => $this->faker->paragraph(2),
        ];
    }
}
