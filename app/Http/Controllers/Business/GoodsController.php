<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\GoodsModel;

class GoodsController extends BaseController
{
    /**
     * 产品(发布的)
     */

    public function index()
    {
        $type = $_POST['type'];
        $del = $_POST['del'];
        $isshow = $_POST['isshow'];
        $recommend = $_POST['recommend'];
        $newest = $_POST['newest'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if (!$type) {
            $type = [1,2,3,4];
        } elseif ($type && !is_array($type)) {
            $type = [$type];
        }
        $delArr = $del ? [$del] : [0,1,2];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $recommendArr = $recommend ? [$recommend] : [0,1,2];
        $newestArr = $newest ? [$newest] : [0,1,2];
        $models = GoodsModel::whereIn('type',$type)
            ->whereIn('del',$delArr)
            ->whereIn('recommend',$recommendArr)
            ->whereIn('newest',$newestArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
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
//        static $number = 1;
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
//            $datas[$k]['number'] = $number ++;
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
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'genres'    =>  $this->selfModel['genres'],
            'types'     =>  $this->selfModel['types'],
            'cates'     =>  $this->selfModel['cates2'],
            'recommends'    =>  $this->selfModel['recommends'],
            'newests'   =>  $this->selfModel['newests'],
            'isshows'   =>  $this->selfModel['isshows'],
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