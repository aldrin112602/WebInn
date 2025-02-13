<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountsTableSeeder::class,
            // TeacherGradeHandle::class,
            // SubjectListTableSeeder::class,
            // AdminNotificationSeeder::class,
            // TeacherNotificationSeeder::class,
            // GuidanceNotificationSeeder::class,
            // StudentNotificationSeeder::class
            // AttendanceHistorySeeder::class
        ]);
    }
}
