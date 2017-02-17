<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\OrderModel;

class OrderController extends BaseController
{
    /**
     * 主体业务订单
     */

    public function index()
    {
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = OrderModel::where('del',$del)
            ->whereIn('isshow',$isshowArr)
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
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['statusBtn'] = $model->getStatusBtn();
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
     * 通过 uid 获取订单列表
     */
    public function getOrdersByUid()
    {
        $uid = $_POST['uid'];
        $status = $_POST['status'];
        if (!$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        if (!$status) {
            $models = OrderModel::where('buyer',$uid)
                ->where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->get();
        } else if (is_array($status)) {
            $models = OrderModel::where('buyer',$uid)
                ->whereIn('status',$status)
                ->where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->get();
        } else {
            $models = OrderModel::where('buyer',$uid)
                ->where('status',$status)
                ->where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
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
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['statusBtn'] = $model->getStatusBtn();
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
     * 通过 uid、weal 获取已支付福利列表
     */
    public function getOrdersByWeal()
    {
        $uid = $_POST['uid'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $models = OrderModel::where('del',$del)
                ->where('uid',$uid)
                ->where('weal','>',0)
                ->whereIn('status',[12,13])
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = OrderModel::where('del',$del)
                ->where('weal','>',0)
                ->whereIn('status',[12,13])
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
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['statusBtn'] = $model->getStatusBtn();
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
            'isshows'   =>  $this->selfModel['isshows'],
            'status'    =>  [
                $this->selfModel['status1s'],
                $this->selfModel['status2s'],
                $this->selfModel['status3s'],
            ],
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