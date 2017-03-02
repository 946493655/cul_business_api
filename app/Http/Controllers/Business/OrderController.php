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
        $total = OrderModel::where('del',$del)
            ->whereIn('isshow',$isshowArr)
            ->count();
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
            $datas[$k] = $this->modelToArray($model);
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
            $query = OrderModel::where('del',0);
        } else if (is_array($status)) {
            $query = OrderModel::where('del',0)->whereIn('status',$status);
        } else {
            $query = OrderModel::where('del',0)->where('status',$status);
        }
        $models = $query->where('isshow',2)
            ->where('uid',$uid)
            ->orderBy('id','desc')
            ->get();
        $total = $query->where('isshow',2)
            ->where('uid',$uid)
            ->count();
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
            $datas[$k] = $this->modelToArray($model);
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
     * 通过 uid 获取订单列表
     */
    public function getOrdersByLimit()
    {
        $uid = $_POST['uid'];
        $limit = $_POST['limit'];
        if ($uid && $limit) {
            $models = OrderModel::where('buyer',$uid)
                ->where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->skip(1)
                ->take($limit)
                ->get();
            $total = OrderModel::where('buyer',$uid)
                ->where('isshow',2)
                ->where('del',0)
                ->count();
        } else if (!$uid && $limit) {
            $models = OrderModel::where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->skip(1)
                ->take($limit)
                ->get();
            $total = OrderModel::where('isshow',2)
                ->where('del',0)
                ->count();
        } else if ($uid && !$limit) {
            $models = OrderModel::where('buyer',$uid)
                ->where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->get();
            $total = OrderModel::where('buyer',$uid)
                ->where('isshow',2)
                ->where('del',0)
                ->count();
        } else {
            $models = OrderModel::where('isshow',2)
                ->where('del',0)
                ->orderBy('id','desc')
                ->get();
            $total = OrderModel::where('isshow',2)
                ->where('del',0)
                ->count();
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
            $datas[$k] = $this->modelToArray($model);
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
            $query = OrderModel::where('del',$del)->where('uid',$uid);
        } else {
            $query = OrderModel::where('del',$del);
        }
        $models = $query->where('weal','>',0)
            ->whereIn('status',[12,13])
            ->whereIn('isshow',$isshowArr)
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->where('weal','>',0)
            ->whereIn('status',[12,13])
            ->whereIn('isshow',$isshowArr)
            ->count();
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
            $datas[$k] = $this->modelToArray($model);
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

    public function store(){}

    /**
     * 对象统一转数组
     */
    public function modelToArray($model)
    {
        $arr = $this->objToArr($model);
        $arr['createTime'] = $model->createTime();
        $arr['updateTime'] = $model->updateTime();
        $arr['genreName'] = $model->getGenreName();
        $arr['statusName'] = $model->getStatusName();
        $arr['statusBtn'] = $model->getStatusBtn();
        return $arr;
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