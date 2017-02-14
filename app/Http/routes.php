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
    $app->post('entertain/show', 'EntertainController@show');
    $app->post('entertain/getmodel', 'EntertainController@getModel');
    //产品(发布)路由
    $app->post('goods', 'GoodsController@index');
    $app->post('goods/goodsbycate', 'GoodsController@getGoodsByCate');
    $app->post('goods/show', 'GoodsController@show');
    $app->post('goods/getmodel', 'GoodsController@getModel');
    //产品(定制)路由
    $app->post('goodscus', 'GoodsCusController@index');
    //创意路由
    $app->post('idea', 'IdeaController@index');
    $app->post('idea/getmodel', 'IdeaController@getModel');
    //订单路由
    $app->post('order', 'OrderController@index');
    $app->post('order/getmodel', 'OrderController@getModel');
    //租赁路由
    $app->post('rent', 'RentController@index');
    $app->post('rent/show', 'RentController@show');
    $app->post('rent/rentsbymoney', 'RentController@getRentsByMoney');
    $app->post('rent/getmodel', 'RentController@getModel');
    //人员路由
    $app->post('staff', 'StaffController@index');
    $app->post('staff/show', 'StaffController@show');
    $app->post('staff/getmodel', 'StaffController@getModel');
    //分镜路由
    $app->post('storyboard', 'StoryboardController@index');
    $app->post('storyboard/getmodel', 'StoryboardController@getModel');
    //影视作品路由
    $app->post('works', 'WorksController@index');
    $app->post('works/show', 'WorksController@show');
    $app->post('works/getmodel', 'WorksController@getModel');
    //广告路由
    $app->post('ad', 'AdController@index');
    $app->post('ad/getmodel', 'AdController@getModel');
    $app->post('adplace', 'AdPlaceController@index');
    $app->post('message', 'MessageController@index');
    //动画、效果定制路由
    $app->post('provideo', 'ProVideoController@index');
    $app->post('provideo/getmodel', 'ProVideoController@getmodel');
    //分镜路由
    $app->post('storyboard', 'StoryBoardController@index');
    $app->post('storyboard/sbsbyway', 'StoryBoardController@getSBsByWay');
    $app->post('storyboard/getmodel', 'StoryBoardController@getModel');
    //人员路由
    $app->post('staff', 'StaffController@index');
    $app->post('staff/getmodel', 'StaffController@getModel');
    //链接路由
    $app->post('link', 'LinkController@index');
    //地区路由
    $app->post('area/namebyid', 'AreaController@getAreaNameByAreaId');
});
//公司业务路由
$app->group(['prefix' => 'api/v1/com', 'namespace'=>'App\Http\Controllers\Company'], function () use ($app) {
});