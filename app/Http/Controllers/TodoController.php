<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     * 機能の概要
     *  ・リソースのリストを表示するためのもの。
     *  ・Todoリソースの一覧を表示する。
     * 戻り値
     *  ・Inertia\Response型のレスポンスを返す。
     * 具体的な機能
     *  ・Inertia::renderメソッド
     *      ->Todo/Index.jsxをレンダリング
     *  ・Index.jsxには'todos'データを渡す。
     *      \Auth::user()->todosの部分で現在ログインしているユーザーに関するTodoリソースを取得
     */
    public function index(): Response
    {
        return Inertia::render('Todos/Index', [ 'todos' => \Auth::user()->todos,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $request->user()->todos()->create($validated);
        return redirect(route('todo.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * $request:現在のHTTPリクエストの情報を持つ'Request'オブジェクト。
     *      クライアントから送信されたデータにアクセスする。
     * $todo:'Todo'モデルのインスタンス。Laravelのルートモデルバインディング機能を使用して、指定されたIDに関連する'Todo'エントリのデータを自動的に取得する。
     * RedirectReponse:メソッドが実行された後、ユーザーは別のURLにリダイレクトされることを意味する。
     * 
     * This->authorize('update', $todo);:
     *      ログインしているユーザーが指定された'$todo'エントリを更新する権限を持っているかどうかをチェック。
     *      ->'update'メソッド内でどのユーザーがどの'Todo'エントリを更新できるかを定義。
     * 
     * $todo->update($request->all());:
     *      $todoエントリの更新
     *     リクエストから送信されたすべてのデータを取得し、'Todo'エントリを更新。
     * 
     * return redirect(route('todo.index));
     *      todo.indexルートにリダイレクト
     */
    public function update(Request $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);
        $todo->update($request->all());
        return redirect(route('todo.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
        $todo->delete();
        return redirect(route('todo.index'));
    }
}
