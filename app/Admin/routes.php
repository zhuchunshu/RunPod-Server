<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');


});

// 设置
Route::group([
    'prefix'     => config('admin.route.prefix')."/setting",
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function () {

    // 基本设置
    Route::get('/basic',[\App\Admin\Controllers\Setting\BasicController::class,'index']);
    Route::post('/basic',[\App\Admin\Controllers\Setting\BasicController::class,'update']);

    // 支付设置
    Route::get('/pay',[\App\Admin\Controllers\Setting\PayController::class,'index']);
    Route::post('/pay',[\App\Admin\Controllers\Setting\PayController::class,'update']);
    Route::post('/pay/upload',[\App\Admin\Controllers\Setting\PayController::class,'upload']);

    // 公众号设置
    Route::get('/officialAccount',[\App\Admin\Controllers\Setting\OfficialAccountController::class,'index']);
    Route::post('/officialAccount',[\App\Admin\Controllers\Setting\OfficialAccountController::class,'update']);
});
