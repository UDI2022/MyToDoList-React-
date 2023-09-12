<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;

class TodoControllerTest extends TestCase
{

    // データベースをリフレッシュし、Fakerを使用
    use RefreshDatabase, WithFaker;
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = user::factory()->create();
    }
    public function testIndex()
    {
        $this->actingAs($this->user); // ユーザーをログイン状態にする
    
        $todo = Todo::create([
            'title' => 'テストタイトル',
            'user_id' => $this->user->id // ユーザーのIDを設定
        ]);
        // 'index'メソッドにアクセス
        $response = $this->get(route('todo.index'));
        // レスポンスが正常であることを検証
        $response->assertStatus(200);
        // 作成したTodoがレスポンスに含まれていることを検証
        $response->assertSee($todo->title);
        // 作成したTodoがレスポンスに含まれていることを検証
        foreach ($todos as $todo) {
            $response->assertStatus($todo->title);
        }
    }

    public function testStore()
    {
        //ユーザーとしてログイン
        $this->actingAs($this->user);
        // テストデータの作成
        $data = ['title' => $this->faker->sentence];
        // 'store'メソッドにPOSTリクエスト
        $response = $this->post(route('todo.store'), $data);
        // データベースにTodoが追加されていることを検証
        $this->assertDatabaseHas('todos', $data);
        // 正しくリダイレクトされているかを検証
        $response->assertRedirect(route('todo.index'));
    }

    public function testUpdate()
    {
        $todo = Todo::create([
            'title' => 'テストタイトル',
            'user_id' => $this->user->id
        ]);
    
        // ユーザーとしてログイン
        $this->actingAs($this->user);
        $updateData = ['title' => 'updated Todo'];
        // 'update' メソッドにPutリクエスト
        $response = $this->put(route('todo.update', $todo->id), $updateData);
        // データベースにTodoが更新されていることを検証
        $this->assertDatabaseHas('todos', $updateData);
        //正しくリダイレクトされているかを検証
        $response->assertRedirect(route('todo.index'));
    }

    public function testDestroy()
    {
        $todo = Todo::create([
            'title' => 'テストタイトル',
            'user_id' => $this->user->id
        ]);
        // ユーザーとしてログイン
        $this->actingAs($this->user);
        // destroyメソッドにDELETEリクエスト
        $response = $this->delete(route('todo.destroy', $todo->id));
        // データベースからTodoが削除されていることを検証
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
        // 正しくリダイレクトされているかを検証
        $response->assertRedirect(route('todo.index'));
    }

}
  