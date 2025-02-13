<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Admin\SubjectModel as Subject;
use App\Models\Teacher\TeacherAccount as Teacher;
use App\Models\TeacherGradeHandle as ModelsTeacherGradeHandle;


class SubjectListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $subjects = [
            'Math', 'Science', 'English', 'History', 'Geography', 
            'Art', 'Music', 'Physical Education', 'Computer Science', 
            'Biology', 'Chemistry', 'Physics', 'Economics', 'Literature', 
            'Philosophy', 'Psychology', 'Sociology', 'Political Science', 
            'Foreign Languages', 'Environmental Science'
        ];

        foreach (range(1, 20) as $index) {
            $teacher = Teacher::inRandomOrder()->first();
            $gradeHandle = ModelsTeacherGradeHandle::inRandomOrder()->first();
            $startHour = $faker->numberBetween(7, 15); 
            $startMinutes = $faker->randomElement(['00', '30']);
            $endHour = $startHour + $faker->numberBetween(1, 3);
            $endMinutes = $startMinutes;

            $startTime = "$startHour:$startMinutes AM";
            $endTime = "$endHour:$endMinutes AM";

            if ($endHour > 12) {
                $endHour -= 12;
                $endTime = "$endHour:$endMinutes PM";
            } else {
                $endTime = "$endHour:$endMinutes AM";
            }

            Subject::create([
                'subject' => $faker->randomElement($subjects),
                'day' => $faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
                'teacher_id' => $teacher->id,
                'grade_handle_id' => $gradeHandle->id,
                'time' => "$startTime - $endTime"
            ]);
        }
    }
}
