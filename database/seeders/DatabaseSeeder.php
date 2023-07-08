<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::firstOrCreate(
            ['email' => 'petermacharia26@gmail.com'], // columns to check existence
            [ // values to insert if the record does not exist
                'first_name' => 'Peter',
                'last_name' => 'Nyagah',
                'phone_number' => '0702309150',
                'address' => 'P.O Box 1234',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'password' => 'Qwerty9090?',
            ]
        );

        $this->call([
            PermissionTableSeeder::class,
            StatusSeeder::class,
            SupperUserSeeder::class,
        ]);

    }

}
