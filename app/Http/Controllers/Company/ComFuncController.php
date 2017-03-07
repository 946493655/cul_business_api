<?php
namespace App\Http\Controllers\Company;

use App\Models\Company\ComFuncModel;

class ComFuncController extends BaseController
{
    /**
     * 公司功能信息
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new ComFuncModel();
    }

    public function index()
    {
        $cid = $_POST['cid'];
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($cid) {
            $models = ComFuncModel::where('cid',$cid)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ComFuncModel::where('cid',$cid)
                ->whereIn('isshow',$isshowArr)
                ->count();
        } else {
            $models = ComFuncModel::whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ComFuncModel::whereIn('isshow',$isshowArr)
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
            $datas[$k] = $this->getFuncModel($model);
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
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ComFuncModel::find($id);
        $datas = $this->getFuncModel($model);
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
            'types'     =>  $this->selfModel['types'],
            'isshows'   =>  $this->selfModel['isshows'],
        ];
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model'  =>  $model,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取 model 集合
     */
    public function getFuncModel($model)
    {
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['isshowName'] = $model->getIsshowName();
        $datas['moduleName'] = $model->getModuleName();
        $datas['typeName'] = $model->getTypeName();
        return $datas;
    }
}