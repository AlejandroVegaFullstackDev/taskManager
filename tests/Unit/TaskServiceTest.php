<?php

namespace Tests\Unit;

use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_throws_when_task_does_not_exist(): void
    {
        $repo = Mockery::mock(TaskRepositoryInterface::class);
        $repo->shouldReceive('find')->once()->with(99)->andReturn(null);

        $this->expectException(TaskNotFoundException::class);

        (new TaskService($repo))->find(99);
    }

    public function test_create_delegates_to_the_repository(): void
    {
        $task = Mockery::mock(Task::class);
        $repo = Mockery::mock(TaskRepositoryInterface::class);
        $repo->shouldReceive('create')->once()->with(['title' => 't'])->andReturn($task);

        $result = (new TaskService($repo))->create(['title' => 't']);

        $this->assertSame($task, $result);
    }

    public function test_delete_removes_existing_task(): void
    {
        $task = Mockery::mock(Task::class);
        $repo = Mockery::mock(TaskRepositoryInterface::class);
        $repo->shouldReceive('find')->once()->with(1)->andReturn($task);
        $repo->shouldReceive('delete')->once()->with($task)->andReturnTrue();

        (new TaskService($repo))->delete(1);

        // Si no se lanzó excepción y se cumplieron las expectativas, pasa.
        $this->assertTrue(true);
    }
}
