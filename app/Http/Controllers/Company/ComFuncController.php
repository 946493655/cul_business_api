<?php
namespace App\Http\Controllers\Company;

use App\Models\Company\ComFuncModel;
use App\Models\Company\ComModuleModel;

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
        $module = $_POST['module'];
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($cid && $module) {
            $query = ComFuncModel::whereIn('isshow',$isshowArr)
                ->where('cid',$cid)
                ->where('module_id',$module);
        } else if (!$cid && $module) {
            $query = ComFuncModel::whereIn('isshow',$isshowArr)
                ->where('module_id',$module);
        } else if ($cid && !$module) {
            $query = ComFuncModel::whereIn('isshow',$isshowArr)
                ->where('cid',$cid);
        } else {
            $query = ComFuncModel::whereIn('isshow',$isshowArr);
        }
        $models = $query->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->count();
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

    public function store()
    {
        $name = $_POST['name'];
        $cid = $_POST['cid'];
        $module_id = $_POST['module_id'];
        $intro = $_POST['intro'];
        $small = $_POST['small'];
        if (!$name || !$module_id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'cid'   =>  $cid,
            'module_id' =>  $module_id,
            'intro' =>  $intro,
            'small' =>  $small,
            'created_at'    =>  time(),
        ];
        ComFuncModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $cid = $_POST['cid'];
        $module_id = $_POST['module_id'];
        $intro = $_POST['intro'];
        $small = $_POST['small'];
        if (!$id || !$name || !$module_id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'intro' =>  $intro,
            'small' =>  $small,
            'updated_at'    =>  time(),
        ];
        ComFuncModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 初始化功能
     */
    public function initFunc()
    {
        $cid = $_POST['cid'];
        if (!$cid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //判断模块
        if (!$this->initModule($cid)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -3,
                    'msg'   =>  '模块数据错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $funcs = ComFuncModel::where('cid',$cid)->get();
        if (count($funcs)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  0,
                    'msg'   =>  '已有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $func0s = ComFuncModel::where('cid',0)->get();
        if (count($func0s)!=9) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '数据错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        foreach ($func0s as $func0) {
            $data = [
                'name'  =>  $func0->name,
                'cid'   =>  $cid,
                'module_id' =>  $func0->module_id,
                'intro' =>  $func0->intro,
                'small' =>  $func0->small,
                'created_at'    =>  time(),
            ];
            ComFuncModel::create($data);
        }
//        //获取功能数据
//        $models = ComFuncModel::where('cid',$cid)->get();
//        $datas = array();
//        foreach ($models as $k=>$model) {
//            $datas[$k] = $this->getFuncModel($model);
//        }
        //获取模块数据
        $models = ComModuleModel::where('cid',$cid)->get();
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
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
     * 初始化模块
     */
    public function initModule($cid)
    {
        $modules = ComModuleModel::where('cid',$cid)->get();
        if (count($modules)) { return true; }
        $module0s = ComModuleModel::where('cid',0)->get();
        if (count($module0s)!=6) { return false; }
        foreach ($module0s as $module0) {
            $data = [
                'name'  =>  $module0->name,
                'cid'   =>  $cid,
                'genre' =>  $module0->genre,
                'intro' =>  $module0->intro,
                'created_at'    =>  time(),
            ];
            ComModuleModel::create($data);
        }
        return true;
    }

    /**
     * 获取 model
     */
    public function getModel()
    {
        $model = [
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
        $datas['typeName'] = $model->getModuleTypeName();
        return $datas;
    }
}