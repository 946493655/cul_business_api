<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\AdModel;

class AdController extends BaseController
{
    /**
     * 广告
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new AdModel();
    }

    public function index()
    {
        $uid = $_POST['uid'];
        $adplace = $_POST['adplace'];
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $isuse = $_POST['isuse'];
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;        //每页显示记录数
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;       //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        if ((!$fromTime&&$toTime) || ($fromTime&&!$toTime)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $isuseArr = $isuse ? [$isuse] : [0,1,2];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($fromTime && $toTime) {
            $models = AdModel::where('uid',$uid)
                ->where('adplace_id',$adplace)
                ->where('fromTime','<',time())
                ->where('toTime','>',time())
                ->whereIn('isuse',$isuseArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = AdModel::where('uid',$uid)
                ->where('adplace_id',$adplace)
                ->whereIn('isuse',$isuseArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        }
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
            $datas[$k]['adplaceName'] = $model->getAdplaceName();
            $datas[$k]['fromTime'] = $model->fromTime();
            $datas[$k]['toTime'] = $model->toTime();
            $datas[$k]['period'] = $model->period();
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

    public function getModel()
    {
        $model = [
            'isauths'   =>  $this->selfModel['isauths'],
            'isuses'    =>  $this->selfModel['isuses'],
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