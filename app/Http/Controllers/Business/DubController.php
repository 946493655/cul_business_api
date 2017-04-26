<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\DubsModel;

class DubController extends BaseController
{
    /**
     * 配音
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new DubsModel();
    }

    public function index()
    {
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = $_POST['limit'];
        $page = $_POST['page'];
        $start = $limit * ($page - 1);

        $genreArr = $genre ? [$genre] : [0,1,2,3,4,5,6,7,8,9,10];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $query = DubsModel::where('del',$del)
                ->where('uid',$uid);
        } else {
            $query = DubsModel::where('del',$del);
        }
        $models = $query->whereIn('genre',$genreArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->whereIn('genre',$genreArr)
            ->whereIn('isshow',$isshowArr)
            ->count();
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
            $datas[$k] = $this->getArrByModel($model);
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
            'pagelist'  =>  [
                'total' =>  $total,
            ],
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

    /**
     * 数据对象转为数组
     */
    public function getArrByModel($model)
    {
        $data = $this->objToArr($model);
        $data['createTime'] = $model->createTime();
        $data['updateTime'] = $model->updateTime();
        $data['genreName'] = $model->getGenreName();
        $data['ishowName'] = $model->getIsshowName();
        return $data;
    }
}