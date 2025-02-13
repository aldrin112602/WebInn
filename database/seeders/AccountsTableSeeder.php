<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Student\StudentAccount as Student;
use App\Models\Admin\AdminAccount as Admin;
use App\Models\Teacher\TeacherAccount as Teacher;
use App\Models\Guidance\GuidanceAccount as Guidance;


class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $defaultPassword = 'password';

        foreach (range(1, 20) as $index) {
            
            Admin::create([
                'id_number' => $faker->unique()->numerify('##########'),
                'name' => $faker->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'username' => $faker->userName,
                'password' => $defaultPassword,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => '09' . $faker->unique()->numerify('#########'),
                'address' => $faker->address,
            ]);

            Guidance::create([
                'id_number' => $faker->unique()->numerify('##########'),
                'name' => $faker->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'username' => $faker->userName,
                'password' => $defaultPassword,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => '09' . $faker->unique()->numerify('#########'),
                'address' => $faker->address,
            ]);


            Teacher::create([
                'id_number' => $faker->unique()->numerify('##########'),
                'name' => $faker->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'position' => $faker->randomElement(['Teacher 1', 'Teacher 2', 'Teacher 3']),
                'username' => $faker->userName,
                'password' => $defaultPassword,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => '09' . $faker->unique()->numerify('#########'),
                'address' => $faker->address,
            ]);
        }
    }
}
