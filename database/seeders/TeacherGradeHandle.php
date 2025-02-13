<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Teacher\TeacherAccount as Teacher;
use App\Models\TeacherGradeHandle as ModelsTeacherGradeHandle;

class TeacherGradeHandle extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            $teacher = Teacher::inRandomOrder()->first();
            ModelsTeacherGradeHandle::create([
                'grade' => $faker->randomElement(['11', '12']),
                'strand' => $faker->randomElement(['ABM', 'ICT', 'HUMSS', 'HE']),
                'teacher_id' => $teacher->id,
                'section' => $faker->randomElement(['A', 'B', 'C', 'D', 'E'])
            ]);
        }
    }
}
