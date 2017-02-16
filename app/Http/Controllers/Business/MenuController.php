<?php
namespace App\Http\Controllers\Business;

use App\Models\MenusModel;

class MenuController extends BaseController
{
    /**
     * 用户后台、公司后台、个人后台、总后台菜单接口
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new MenusModel();
    }

    public function getMenusByType()
    {
        $type = $_POST['type'];
        if (!$type) {
            $rstArr = [
                'error' =>  [
                    'error' =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = MenusModel::where('pid',0)
            ->where('isshow',2)
            ->where('type',$type)
            ->orderBy('sort','desc')
            ->orderBy('id','asc')
            ->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['child'] = $model->getChild();
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
}