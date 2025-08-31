<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleTasks = [
            [
                'title' => 'Set up development environment',
                'description' => 'Install Docker, configure Laravel project with PostgreSQL database.',
                'priority' => 'high',
                'completed' => true,
            ],
            [
                'title' => 'Create task management system',
                'description' => 'Build a simple CRUD application for managing tasks with priorities.',
                'priority' => 'high',
                'completed' => false,
            ],
            [
                'title' => 'Write documentation',
                'description' => 'Document the API endpoints and usage instructions.',
                'priority' => 'medium',
                'completed' => false,
            ],
            [
                'title' => 'Add user authentication',
                'description' => 'Implement user registration and login functionality.',
                'priority' => 'medium',
                'completed' => false,
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Set up CI/CD pipeline and deploy the application.',
                'priority' => 'low',
                'completed' => false,
            ],
            [
                'title' => 'Code review',
                'description' => 'Review the codebase for best practices and optimizations.',
                'priority' => 'medium',
                'completed' => true,
            ],
        ];

        foreach ($sampleTasks as $taskData) {
            Task::create($taskData);
        }
    }
}
