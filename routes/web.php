<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/task', function () {
    $tasks = App\Task::orderBy('created_at','asc')->get();

    return view('tasks' ,[
        'tasks' => $tasks
    ]);
});

use Illuminate\Http\Request;
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
/*
Route::post('/task', function () {
    $validator = Validator::make(Request::all(), [
*/
        'name' => 'required|max:255',
    ]);

    if($validator->fails()){
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $task = new App\Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/task');
});

Route::delete('/task/{task}', function (App\Task $task) {
    $task->delete();
    return redirect('/task');
});

// 記事一覧
Route::get('/article', 'ArticleController@index');
// 記事作成
Route::get('/article/create', 'ArticleController@create');
// 記事登録
Route::post('/article/create', 'ArticleController@store');

