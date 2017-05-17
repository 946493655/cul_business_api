<?php
namespace App\Http\Controllers\Search;

use App\Models\Business\DeliverysModel;
use App\Models\Business\DesignModel;
use App\Models\Business\DubsModel;
use App\Models\Business\GoodsModel;
use App\Models\Business\HuaxuModel;
use App\Models\Business\IdeasModel;
use App\Models\Business\RentModel;
use App\Models\Business\StaffModel;
use App\Models\Search\SearchsModel;

class SearchController extends BaseController
{
    /**
     * 业务检索
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new SearchsModel();
    }

    public function index()
    {
        $genre = $_POST['genre'];
        $keyword = $_POST['keyword'];
        $limit = $_POST['limit'];
        $page = $_POST['page'];
        $start = $limit * ($page - 1);

        if (!$genre) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $query = SearchsModel::where('genre',$genre)
            ->where('words','like','%'.$keyword.'%');
        $models = $query->skip($start)
            ->take($limit)
            ->get();
        $total = $query->count();
        if (!$models) {
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
//            $datas[$k] = $this->getArrByModel($model);
            $datas[$k] = $this->objToArr($model);
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
     * 数据对象转化为数组
     */
    public function getArrByModel($model)
    {
        /**
         * genre：
         * 1视频动画（产品），2故事（脚本），3设备（租赁），4人员（演员等），
         * 5配音，6设计，7投放（视频），8花絮
         */
        if ($model->genre==1) {
            $rstData = GoodsModel::find($model->fromid);
        } else if ($model->genre==2) {
            $rstData = IdeasModel::find($model->fromid);
        } else if ($model->genre==3) {
            $rstData = RentModel::find($model->fromid);
        } else if ($model->genre==4) {
            $rstData = StaffModel::find($model->fromid);
        } else if ($model->genre==5) {
            $rstData = DubsModel::find($model->fromid);
        } else if ($model->genre==6) {
            $rstData = DesignModel::find($model->fromid);
        } else if ($model->genre==7) {
            $rstData = DeliverysModel::find($model->fromid);
        } else if ($model->genre==8) {
            $rstData = HuaxuModel::find($model->fromid);
        }
        if (isset($rstData) && $rstData) {
            $data = $this->objToArr($rstData);
            $data['createTime'] = $rstData->createTime();
            $data['updateTime'] = $rstData->updateTime();
        }
        return isset($data) ? $data : [];
    }

    /**
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'genres'    =>  $this->selfModel['genres'],
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