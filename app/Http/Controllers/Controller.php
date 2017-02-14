<?php

namespace App\Http\Controllers;

use App\Models\Business\AreaModel;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $limit = 20;      //每页显示记录数
    protected $selfModel;

    public function __construct()
    {
    }

    /**
     * 对象转数组
     */
    public function objToArr($obj)
    {
        return json_decode(json_encode($obj),true);
    }

//    /**
//     * 通过 area_id 获取 area_name 字符串
//     */
//    public function getAreaNameByAreaId($area_id)
//    {
//        $areaStr = '';
//        $areaModel = AreaModel::find($area_id);
//        $areaStr = $areaModel ? $areaModel->cityname : '';
//        if ($areaModel && $areaModel->parentid!=0) {
//            $areaModel2 = AreaModel::find($areaModel->parentid);
//            $areaStr = $areaModel2 ? $areaModel2->cityname.'，'.$areaStr : '';
//        }
//        if ($areaModel && $areaModel2 && $areaModel2->parentid!=0) {
//            $areaModel3 = AreaModel::find($areaModel2->parentid);
//            $areaStr = $areaModel3 ? $areaModel3->cityname.'，'.$areaStr : '';
//        }
//        return $areaStr;
//    }
}
