<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource("chat-groups", \App\Http\Controllers\ChatGroupController::class);


Route::get('/user-id', function () {
    $userId = substr(floor(time() - 999999999), 4, 18);
    return response()->json(['status' => 'success', 'user_id' => $userId]);
});
Route::post('/send-message', function (\Illuminate\Http\Request $request) {
    broadcast(new \App\Events\NewChatGroupMessage($request->message, $request->author, $request->chatGroupId))->toOthers();
});
