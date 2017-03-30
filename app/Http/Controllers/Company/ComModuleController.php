<?php
namespace App\Http\Controllers\Company;

use App\Models\Company\ComModuleModel;

class ComModuleController extends BaseController
{
    /**
     * 公司模块管理
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new ComModuleModel();
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
            $models = ComModuleModel::where('cid',$cid)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ComModuleModel::where('cid',$cid)
                ->whereIn('isshow',$isshowArr)
                ->count();
        } else {
            $models = ComModuleModel::whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ComModuleModel::whereIn('isshow',$isshowArr)->count();
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
            $datas[$k] = $this->getModuleModel($model);
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
     * 通过 cid 获取模块集合
     */
    public function getModulesByCid()
    {
        $cid = $_POST['cid'];
        $isshow = $_POST['isshow'];
        if (!in_array($isshow,[0,1,2])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = ComModuleModel::where('cid',$cid)
            ->where('isshow',$isshow)
            ->get();
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
            $datas[$k] = $this->getModuleModel($model);
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
     * 通过 cid、genre 获取记录
     */
    public function getOneByGenre()
    {
        $cid = $_POST['cid'];
        $genre = $_POST['genre'];
        if (!$genre) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ComModuleModel::where('cid',$cid)
            ->where('genre',$genre)
            ->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->getModuleModel($model);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
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
        $model = ComModuleModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->getModuleModel($model);
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
        $genre = $_POST['genre'];
        $intro = $_POST['intro'];
        $cid = $_POST['cid'];
        if (!$name || !$genre || !$intro) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
//        if (!$this->initModule($cid)) {
//            $rstArr = [
//                'error' =>  [
//                    'code'  =>  -2,
//                    'msg'   =>  '初始化错误！',
//                ],
//            ];
//            echo json_encode($rstArr);exit;
//        }
        $data = [
            'name'  =>  $name,
            'genre' =>  $genre,
            'intro' =>  $intro,
            'cid'   =>  $cid,
            'created_at'    =>  time(),
        ];
        ComModuleModel::create($data);
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
        $genre = $_POST['genre'];
        $intro = $_POST['intro'];
        $cid = $_POST['cid'];
        if (!$id || !$name || !$genre || !$intro) {
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
            'updated_at'    =>  time(),
        ];
        ComModuleModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 初始化公司模块
     */
    public function initModule()
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
        $modules = ComModuleModel::where('cid',$cid)->get();
        if (count($modules)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  0,
                    'msg'   =>  '已有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $module0s = ComModuleModel::where('cid',0)->get();
        if (count($module0s)!=9) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '数据错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
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
        //获取模块数据
        $models = ComModuleModel::where('cid',$cid)->get();
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->getModuleModel($model);
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
     * 设置排序
     */
    public function setSort()
    {
        $id = $_POST['id'];
        $sort = $_POST['sort'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ComModuleModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        ComModuleModel::where('id',$id)->update(['sort'=>$sort]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置是否显示
     */
    public function setShow()
    {
        $id = $_POST['id'];
        $isshow = $_POST['isshow'];
        if (!$id || !in_array($isshow,[1,2])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ComModuleModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        ComModuleModel::where('id',$id)->update(['isshow'=>$isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
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
    public function getModuleModel($model)
    {
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['genreName'] = $model->getGenreName();
        $datas['isshowName'] = $model->getIsshowName();
        return $datas;
    }
}