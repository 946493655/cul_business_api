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
    $app->post('design/show', 'DesignController@show');
    $app->post('design/add', 'DesignController@store');
    $app->post('design/modify', 'DesignController@update');
    $app->post('design/setthumb', 'DesignController@setThumb');
    $app->post('design/setshow', 'DesignController@setShow');
    $app->post('design/getmodel', 'DesignController@getModel');
    //娱乐路由
    $app->post('entertain', 'EntertainController@index');
    $app->post('entertain/show', 'EntertainController@show');
    $app->post('entertain/add', 'EntertainController@store');
    $app->post('entertain/modify', 'EntertainController@update');
    $app->post('entertain/setthumb', 'EntertainController@setThumb');
    $app->post('entertain/setshow', 'EntertainController@setShow');
    $app->post('entertain/getmodel', 'EntertainController@getModel');
    //产品(发布)路由
    $app->post('goods', 'GoodsController@index');
    $app->post('goods/goodsbyuid', 'GoodsController@getGoodsByUid');
    $app->post('goods/show', 'GoodsController@show');
    $app->post('goods/add', 'GoodsController@store');
    $app->post('goods/modify', 'GoodsController@update');
    $app->post('goods/thumb', 'GoodsController@setThumb');
    $app->post('goods/link', 'GoodsController@setLink');
    $app->post('goods/setshow', 'GoodsController@setShow');
    $app->post('goods/getmodel', 'GoodsController@getModel');
    //产品(定制)路由
    $app->post('goodscus', 'GoodsCusController@index');
    $app->post('goodscus/add', 'GoodsCusController@store');
    $app->post('goodscus/modify', 'GoodsCusController@update');
    $app->post('goodscus/show', 'GoodsCusController@show');
    //产品(定制)之用户竞价路由
    $app->post('goodscususer', 'GoodsCusUsersController@index');
    $app->post('goodscususer/add', 'GoodsCusUsersController@store');
    $app->post('goodscususer/modify', 'GoodsCusUsersController@update');
    $app->post('goodscususer/show', 'GoodsCusUsersController@show');
    //创意路由
    $app->post('idea', 'IdeaController@index');
    $app->post('idea/show', 'IdeaController@show');
    $app->post('idea/add', 'IdeaController@store');
    $app->post('idea/modify', 'IdeaController@update');
    $app->post('idea/setshow', 'IdeaController@setShow');
    $app->post('idea/getmodel', 'IdeaController@getModel');
    //订单路由
    $app->post('order', 'OrderController@index');
    $app->post('order/ordersbyuid', 'OrderController@getOrdersByUid');
    $app->post('order/ordersbylimit', 'OrderController@getOrdersByLimit');
    $app->post('order/ordersbyweal', 'OrderController@getOrdersByWeal');
    $app->post('order/getmodel', 'OrderController@getModel');
    //租赁路由
    $app->post('rent', 'RentController@index');
    $app->post('rent/rentsbymoney', 'RentController@getRentsByMoney');
    $app->post('rent/show', 'RentController@show');
    $app->post('rent/add', 'RentController@store');
    $app->post('rent/modify', 'RentController@update');
    $app->post('rent/setthumb', 'RentController@setThumb');
    $app->post('rent/setshow', 'RentController@setShow');
    $app->post('rent/getmodel', 'RentController@getModel');
    //人员路由
    $app->post('staff', 'StaffController@index');
    $app->post('staff/add', 'StaffController@store');
    $app->post('staff/modify', 'StaffController@update');
    $app->post('staff/show', 'StaffController@show');
    $app->post('staff/staffsbyuid', 'StaffController@getStaffsByUid');
    $app->post('staff/getmodel', 'StaffController@getModel');
    //影视作品路由
//    $app->post('works', 'WorksController@index');
//    $app->post('works/show', 'WorksController@show');
//    $app->post('works/getmodel', 'WorksController@getModel');
    //广告路由
    $app->post('ad', 'AdController@index');
    $app->post('ad/getmodel', 'AdController@getModel');
    $app->post('adplace', 'AdPlaceController@index');
    $app->post('message', 'MessageController@index');
    //动画、效果定制路由
    $app->post('provideo', 'ProVideoController@index');
    $app->post('provideo/show', 'ProVideoController@show');
    $app->post('provideo/add', 'ProVideoController@store');
    $app->post('provideo/modify', 'ProVideoController@update');
    $app->post('provideo/getmodel', 'ProVideoController@getmodel');
    //分镜路由
    $app->post('storyboard', 'StoryBoardController@index');
    $app->post('storyboard/sbsbyway', 'StoryBoardController@getSBsByWay');
    $app->post('storyboard/add', 'StoryBoardController@store');
    $app->post('storyboard/modify', 'StoryBoardController@update');
    $app->post('storyboard/show', 'StoryBoardController@show');
    $app->post('storyboard/setthumb', 'StoryBoardController@setThumb');
    $app->post('storyboard/setshow', 'StoryBoardController@setShow');
    $app->post('storyboard/getmodel', 'StoryBoardController@getModel');
    //人员路由
    $app->post('staff', 'StaffController@index');
    $app->post('staff/getmodel', 'StaffController@getModel');
    //消息路由
    $app->post('message', 'MessageController@index');
    $app->post('message/add', 'MessageController@store');
    //地区路由
    $app->post('area/namebyid', 'AreaController@getAreaNameByAreaId');
    $app->post('area/areabyName', 'AreaController@getAreaByName');
    //链接路由
    $app->post('link', 'LinkController@index');
    //菜单路由
    $app->post('menu', 'MenuController@index');
    $app->post('menu/menusbytype', 'MenuController@getMenusByType');
    $app->post('menu/show', 'MenuController@show');
    $app->post('menu/add', 'MenuController@store');
    $app->post('menu/modify', 'MenuController@update');
    $app->post('menu/setshow', 'MenuController@setIsShow');
    $app->post('menu/parent', 'MenuController@getParent');
    $app->post('menu/getmodel', 'MenuController@getModel');
    //权限路由
    $app->post('menu/auth/authsbyusertype', 'AuthController@getAuthsByUserType');
    $app->post('menu/auth/setauth', 'AuthController@setAuth');
    $app->post('menu/auth/getmodel', 'AuthController@getModel');
});
//公司业务路由
$app->group(['prefix' => 'api/v1/com', 'namespace'=>'App\Http\Controllers\Company'], function () use ($app) {
    $app->post('main', 'ComMainController@index');
    $app->post('main/onebyuid', 'ComMainController@getOneByUid');
    $app->post('main/getmodel', 'ComMainController@getModel');
});