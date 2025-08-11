<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

     use RefreshDatabase; // очищает БД перед каждым тестом

    /** @test */
    public function it_creates_a_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => 'pending'
        ];
        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test Task']);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function it_lists_all_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_shows_a_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => $task->title]);
    }

    /** @test */
    public function it_updates_a_task()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => 'done'
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Task']);

        $this->assertDatabaseHas('tasks', ['title' => 'Updated Task']);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

}
