<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users to avoid duplicates
        User::query()->delete();
        
        // Create 2 random users using the factory
        $randomUsers = User::factory()->count(2)->create();
        
        // Create the specific user (or find if exists)
        $specificUser = User::firstOrCreate(
            ['email' => 'carolina.semeao@outlook.com'],
            [
                'name' => 'Carolina Semeao',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        $this->command->info('Created 3 users:');
        foreach ($randomUsers as $user) {
            $this->command->info('- ' . $user->name . ' (' . $user->email . ')');
        }
        $this->command->info('- ' . $specificUser->name . ' (' . $specificUser->email . ')');
    }
}