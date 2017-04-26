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
    //产品(定制)之用户竞价路由
    $app->post('goodsuser', 'GoodsUsersController@index');
    $app->post('goodsuser/add', 'GoodsUsersController@store');
    $app->post('goodsuser/modify', 'GoodsUsersController@update');
    $app->post('goodsuser/show', 'GoodsUsersController@show');
    //视频制作花絮
    $app->post('huaxu', 'HuaxuController@index');
    $app->post('huaxu/add', 'HuaxuController@store');
    $app->post('huaxu/modify', 'HuaxuController@modify');
    $app->post('huaxu/show', 'HuaxuController@show');
    $app->post('huaxu/getmodel', 'HuaxuController@getModel');
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
    $app->post('order/onebygenre', 'OrderController@getOneByGenre');
    $app->post('order/show', 'OrderController@show');
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
    //配音路由
    $app->post('dub', 'DubController@index');
    $app->post('dub/getmodel', 'DubController@getModel');
    //视频投放路由
    $app->post('delivery', 'DeliveryController@index');
    $app->post('delivery/getmodel', 'DeliveryController@getModel');
    //消息路由
    $app->post('message', 'MessageController@index');
    $app->post('message/add', 'MessageController@store');
    $app->post('message/show', 'MessageController@show');
    $app->post('message/setshow', 'MessageController@setShow');
    $app->post('message/getmodel', 'MessageController@getModel');
    //广告位路由
    $app->post('adplace', 'AdPlaceController@index');
    $app->post('adplace/all', 'AdPlaceController@getAdPlaceAll');
    $app->post('adplace/show', 'AdPlaceController@show');
    $app->post('adplace/add', 'AdPlaceController@store');
    $app->post('adplace/modify', 'AdPlaceController@update');
    $app->post('adplace/getmodel', 'AdPlaceController@getModel');
    //广告路由
    $app->post('ad', 'AdController@index');
    $app->post('ad/show', 'AdController@show');
    $app->post('ad/add', 'AdController@store');
    $app->post('ad/modify', 'AdController@update');
    $app->post('ad/setthumb', 'AdController@setThumb');
    $app->post('ad/setuse', 'AdController@setUse');
    $app->post('ad/getmodel', 'AdController@getModel');
    //地区路由
    $app->post('area', 'AreaController@index');
    $app->post('area/namebyid', 'AreaController@getAreaNameByAreaId');
    $app->post('area/areabyName', 'AreaController@getAreaByName');
    //链接路由
    $app->post('link', 'LinkController@index');
    $app->post('link/linksbypid', 'LinkController@getLinksByPid');
    $app->post('link/show', 'LinkController@show');
    $app->post('link/add', 'LinkController@store');
    $app->post('link/modify', 'LinkController@update');
    $app->post('link/setthumb', 'LinkController@setThumb');
    $app->post('link/setshow', 'LinkController@setShow');
    $app->post('link/getmodel', 'LinkController@getModel');
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
    //模块路由
    $app->post('module', 'ComModuleController@index');
    $app->post('module/modulesbycid', 'ComModuleController@getModulesByCid');
    $app->post('module/modulebygenre', 'ComModuleController@getOneByGenre');
    $app->post('module/show', 'ComModuleController@show');
    $app->post('module/add', 'ComModuleController@store');
    $app->post('module/modify', 'ComModuleController@update');
    $app->post('module/init', 'ComModuleController@initModule');
    $app->post('module/setshow', 'ComModuleController@setShow');
    $app->post('module/setsort', 'ComModuleController@setSort');
    $app->post('module/getmodel', 'ComModuleController@getModel');
    //功能路由
    $app->post('func', 'ComFuncController@index');
    $app->post('func/show', 'ComFuncController@show');
    $app->post('func/add', 'ComFuncController@store');
    $app->post('func/modify', 'ComFuncController@update');
    $app->post('func/init', 'ComFuncController@initFunc');
    $app->post('func/getmodel', 'ComFuncController@getModel');
    //单页模块路由
    $app->post('singlemodule', 'ComModuleController@getSingleModuleList');
    //单页路由
    $app->post('single', 'ComFuncController@getSingleList');
    //访问路由
    $app->post('visit', 'VisitlogController@index');
    $app->post('visit/show', 'VisitlogController@show');
});
//搜索路由
$app->group(['prefix' => 'api/v1/search', 'namespace'=>'App\Http\Controllers\Search'], function () use ($app) {
    $app->post('/', 'SearchController@index');
    $app->post('getmodel', 'SearchController@getModel');
});