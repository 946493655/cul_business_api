<?php
namespace App\Http\Controllers\Company;

use App\Models\Company\VisitlogModel;

class VisitlogController extends BaseController
{
    /**
     * 公司来客访问的路由
     */

    public function index()
    {
        $cid = $_POST['cid'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if ($cid) {
            $models = VisitlogModel::where('cid',$cid)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = VisitlogModel::where('cid',$cid)->count();
        } else {
            $models = VisitlogModel::orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = VisitlogModel::count();
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
            $datas[$k]['loginTimeStr'] = $model->getLoginTime();
            $datas[$k]['logoutTimeStr'] = $model->getLogoutTime();
            $datas[$k]['actionName'] = $model->getAction();
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

    public function show()
    {
        $id = $_POST['id'];
        if (!$id) {
            $rstArr = [
                'error'     =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = VisitlogModel::find($id);
        if (!$model) {
            $rstArr = [
                'error'     =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        $datas['loginTimeStr'] = $model->getLoginTime();
        $datas['logoutTimeStr'] = $model->getLogoutTime();
        $datas['actionName'] = $model->getAction();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

//    /**
//     * 获取 model
//     */
//    public function getModel(){}
}