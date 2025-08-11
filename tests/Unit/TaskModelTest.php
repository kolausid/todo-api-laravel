<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Task;
class TaskModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_can_create_task()
    {
        $task = new Task(['title' => 'Test', 'description' => 'Desc', 'status' => 'pending']);
        $this->assertEquals('Test', $task->title);
    }
}
