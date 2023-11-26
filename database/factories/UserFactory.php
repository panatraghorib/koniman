<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'organization_id' => 1,
            'mobile' => fake()->phoneNumber(),
            'gender' => $this->faker->randomElement(['LK', 'PR']),
            'created_at' => now(),
            'date_of_birth' => $this->faker->date(),
            'avatar' => 'img/default-avatar.jpg'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // /**
    //  * @param array|\Spatie\Permission\Contracts\Role|string  ...$roles
    //  * @return UserFactory
    //  */

    // private function assignRole(...$roles): UserFactory
    // {
    //     return $this->afterCreating(fn (User $user) => $user->syncRoles($roles));
    // }
    // /**
    //  * Configure the model factory.
    //  *
    //  * @return $this
    //  */
    // public function configure()
    // {
    //     return $this->afterMaking(function (User $user) {
    //         return $user->assignRole('Organisasi/Cabor');
    //     });
    // }
}
