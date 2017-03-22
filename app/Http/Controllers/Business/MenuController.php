<?php
namespace App\Http\Controllers\Business;

use App\Models\MenusModel;

class MenuController extends BaseController
{
    /**
     * 用户后台、公司后台、个人后台、总后台菜单接口
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new MenusModel();
    }

    public function index()
    {
        $type = $_POST['type'];
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $typeArr = $type ? [$type] : [0,1,2,3];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = MenusModel::whereIn('type',$typeArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = MenusModel::whereIn('type',$typeArr)
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
     * 通过 type 获取菜单
     * type：1member、2person、3company
     */
    public function getMenusByType()
    {
        $type = $_POST['type'];
//        if (!$type) {
//            $rstArr = [
//                'error' =>  [
//                    'error' =>  -1,
//                    'msg'   =>  '参数有误！',
//                ],
//            ];
//            echo json_encode($rstArr);exit;
//        }
        $typeArr = $type ? [$type] : [0,1,2,3];
        $models = MenusModel::where('pid',0)
            ->whereIn('type',$typeArr)
            ->where('isshow',2)
            ->orderBy('sort','desc')
            ->orderBy('id','asc')
            ->get();
        $total = MenusModel::where('pid',0)
            ->whereIn('type',$typeArr)
            ->where('isshow',2)
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
        $model = MenusModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->getArrByModel($model);
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
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $namespace = $_POST['namespace'];
        $controller_prefix = $_POST['controller_prefix'];
        $platUrl = $_POST['platUrl'];
        $url = $_POST['url'];
        $action = $_POST['action'];
        $style_class = $_POST['style_class'];
        $pid = $_POST['pid'];
        $sort = $_POST['sort'];
        if (!$name || !$type || !$namespace || !$controller_prefix || !$platUrl || !$url || !$action) {
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
            'type'  =>  $type,
            'intro' =>  $intro,
            'namespace' =>  $namespace,
            'controller_prefix' =>  $controller_prefix,
            'platUrl'   =>  $platUrl,
            'url'       =>  $url,
            'action'    =>  $action,
            'style_class'   =>  $style_class,
            'pid'       =>  $pid,
            'created_at'    =>  time(),
        ];
        MenusModel::create($data);
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
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $namespace = $_POST['namespace'];
        $controller_prefix = $_POST['controller_prefix'];
        $platUrl = $_POST['platUrl'];
        $url = $_POST['url'];
        $action = $_POST['action'];
        $style_class = $_POST['style_class'];
        $pid = $_POST['pid'];
        $sort = $_POST['sort'];
        if (!$id || !$name || !$type || !$namespace || !$controller_prefix || !$platUrl || !$url || !$action) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = MenusModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'type'  =>  $type,
            'intro' =>  $intro,
            'namespace' =>  $namespace,
            'controller_prefix' =>  $controller_prefix,
            'platUrl'   =>  $platUrl,
            'url'       =>  $url,
            'action'    =>  $action,
            'style_class'   =>  $style_class,
            'pid'       =>  $pid,
            'sort'      =>  $sort,
            'updated_at'    =>  time(),
        ];
        MenusModel::where('id',$id)->update($data);
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
    public function setIsShow()
    {
        $id = $_POST['id'];
        $isshow = $_POST['isshow'];
        if (!$id || !$isshow) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = MenusModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        MenusModel::where('id',$id)->update(['isshow'=>$isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取顶级父菜单
     */
    public function getParent()
    {
        $models = MenusModel::where('pid',0)->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！' ,
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
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'types' =>  $this->selfModel['types'],
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
     * 讲 model 转为 array
     */
    public function getArrByModel($model)
    {
        $data = $this->objToArr($model);
        $data['createTime'] = $model->createTime();
        $data['updateTime'] = $model->updateTime();
        $data['typeName'] = $model->getTypeName();
        $data['isshowName'] = $model->getIsshowName();
        $data['parentName'] = $model->getParentName();
        $data['controller'] = $model->getController();
        $data['urlStr'] = $model->getUrl();
        $data['child'] = $model->getChild();
        return $data;
    }
}