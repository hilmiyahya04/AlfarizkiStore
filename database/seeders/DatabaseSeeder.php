<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use function Symfony\Component\String\s;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call((ShieldSeeder::class));

        Role::firstOrCreate(['name' => 'panel_user', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('super_admin');
        $this->call([
        ]);


        }


    }
