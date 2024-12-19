<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
         ->assertJsonStructure([
             'id', 'title', 'description', 'status', 'created_at', 'updated_at',
         ])
         ->assertJson([
             'title' => 'Test Task',
             'status' => 'pending',
         ]);

    }

    public function test_can_get_tasks()
    {
        Task::factory()->create(['title' => 'Test Task 1']);
        Task::factory()->create(['title' => 'Test Task 2']);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at'],
                     ],
                     'links', 'meta',
                 ]);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson('/api/tasks/' . $task->id, [
            'title' => 'Updated Task',
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'id', 'title', 'description', 'status', 'created_at', 'updated_at',
        ])
        ->assertJson([
            'title' => 'Updated Task',
            'status' => 'completed',
        ]);

    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(204);
    }
}
