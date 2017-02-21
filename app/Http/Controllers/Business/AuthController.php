<?php
namespace App\Http\Controllers\Business;

use App\Models\AuthModel;

class AuthController extends BaseController
{
    /**
     * 功能权限管理
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new AuthModel();
    }

    public function getAuthsByUserType()
    {
        $auth = $_POST['userType'];
        if (!in_array($auth,[0,1,2,3,4,5,6,7,50])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = AuthModel::where('auth',$auth)->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置更新权限
     */
    public function setAuth()
    {
        $auth = $_POST['auth'];
        $menu = $_POST['menu'];
        if (!in_array($auth,[0,1,2,3,4,5,6,7,50]) || !$menu) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $menuArr = is_array($menu) ? $menu : [$menu];
        $authOldModels = AuthModel::where('auth',$auth)->get();
        //去除多余的
        if ($authOldModels) {
            foreach ($authOldModels as $authOldModel) {
                if (!in_array($authOldModel->menu,$menuArr)) {
                    AuthModel::where('id',$authOldModel->id)->delete();
                }
            }
        }
        //增加新的
        foreach ($menuArr as $m) {
            $authModel = AuthModel::where('menu',$m)->first();
            if (!$authModel) {
                $data = [
                    'auth'  =>  $auth,
                    'menu'  =>  $m,
                    'created_at'    =>  time(),
                ];
                AuthModel::create($data);
            }
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function getModel()
    {
        $model = [
            'auths' =>  $this->selfModel['auths'],
        ];
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  $model,
        ];
        echo json_encode($rstArr);exit;
    }
}