<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\AreaModel;

class AreaController extends BaseController
{
    /**
     * 城市地址接口
     */

    /**
     * 通过 area_id 获取地址/字符串
     */
    public function getAreaNameByAreaId()
    {
        $area_id = $_POST['area_id'];
        $type = $_POST['type'];     //1单个地区，2地区的拼接字符串
        if (!$area_id || !$type) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = AreaModel::find($area_id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        if ($type==1) {
            $datas['areaName'] = $model->cityname;
        } else {
            $datas['areaName'] = AreaModel::getAreaStr($area_id);
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
     * 通过 areaName 获取记录
     */
    public function getAreaByName()
    {
        $areaName = $_POST['areaName'];
        if (!$areaName) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = AreaModel::where('cityname',$areaName)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        $datas['areaNameStr'] = $model->getAreaStr($model->id);
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