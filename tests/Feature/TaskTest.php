<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function 一覧を取得()
    {
        $tasks = Task::factory()->count(10)->create();
        $response = $this->getJson('api/tasks');

        $response->assertOk()
                 ->assertJsonCount($tasks->count());
    }
    /**
     * @test
     */
    public function 登録Success()
    {
        $data = [
            'title' => 'テストタスク',
        ];
        $response = $this->postJson('api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }
    /**
     * @test
     */
    public function 登録FailTitleEmpty()
    {
        $data = [
            'title' => '',
        ];
        $response = $this->postJson('api/tasks', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'title' => 'タイトルは、必ず指定してください。'
                 ]);
    }
    /**
     * @test
     */
    public function 登録FailTitleMaxLength()
    {
        $data = [
            'title' => str_repeat('あ', 256),
        ];
        $response = $this->postJson('api/tasks', $data);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'title' => 'タイトルは、255文字以下にしてください。'
                 ]);
    }
    /**
     * @test
     */
    public function 更新Success()
    {
        $task = Task::factory()->create();
        $task->title = '名称更新';

        $response = $this->patchJson("api/tasks/{$task->id}", $task->toArray());
        $response->assertOk()
                 ->assertJsonFragment($task->toArray());
    }
    /**
     * @test
     */
    public function 削除Success()
    {
        $tasks = Task::factory()->count(10)->create();

        $response = $this->deleteJson("api/tasks/{$tasks[0]->id}");
        $response->assertOk();
        $response = $this->getJson("api/tasks");
        $response->assertJsonCount($tasks->count() - 1);
    }
}
