<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

//$app->group(['prefix'=>'/', 'namespace'=>'App\Http\Controllers\Business'], function () use ($app) {
//    $app->get('ad', 'AdController@index');
//});

/**
 * 主体业务路由
 */
$app->group(['prefix' => 'api/v1', 'namespace'=>'App\Http\Controllers\Business'], function () use ($app) {
    //设计路由
    $app->post('design', 'DesignController@index');
    $app->post('design/getmodel', 'DesignController@getModel');
    //娱乐路由
    $app->post('entertain', 'EntertainController@index');
    $app->post('entertain/getmodel', 'EntertainController@getModel');
    //产品(发布)路由
    $app->post('goods', 'GoodsController@index');
    $app->post('goodscus', 'GoodsCusController@index');
    //创意路由
    $app->post('idea', 'IdeaController@index');
    $app->post('idea/getmodel', 'IdeaController@getModel');
    //订单路由
    $app->post('order', 'OrderController@index');
    $app->post('order/getmodel', 'OrderController@getModel');
    //租赁路由
    $app->post('rent', 'RentController@index');
    $app->post('rent/getmodel', 'RentController@getModel');
    $app->post('staff', 'StaffController@index');
    $app->post('storyboard', 'StoryboardController@index');
    $app->post('works', 'WorksController@index');
    //广告路由
    $app->post('ad', 'AdController@index');
    $app->post('ad/getmodel', 'AdController@getModel');
    $app->post('adplace', 'AdPlaceController@index');
    $app->post('area', 'AreaController@index');
    $app->post('message', 'MessageController@index');
});
//公司业务路由
$app->group(['prefix' => 'api/v1/com', 'namespace'=>'App\Http\Controllers\Company'], function () use ($app) {
});