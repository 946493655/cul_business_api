<?php
namespace App\Http\Controllers\Business;

use App\Models\LinkModel;

class LinkController extends BaseController
{
    /**
     * 链接
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new LinkModel();
    }

    public function index()
    {
        $cid = $_POST['cid'];
        $type = $_POST['type'];
        $sortid = $_POST['sortid'];
        $isshow = (isset($_POST['isshow'])&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

//        if (!$type) {
//            $rstArr = [
//                'error' =>  [
//                    'code'  =>  -1,
//                    'msg'   =>  '参数有误！',
//                ],
//            ];
//            echo json_encode($rstArr);exit;
//        }
        $typeArr = $type ? [$type] : [0,1,2,3];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = LinkModel::where('cid', $cid)
            ->whereIn('type', $typeArr)
            ->whereIn('isshow', $isshowArr)
            ->orderBy('sort', $sortid)
            ->skip($start)
            ->take($limit)
            ->get();
        $total = LinkModel::where('cid', $cid)
            ->whereIn('type', $typeArr)
            ->whereIn('isshow', $isshowArr)
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
        $model = LinkModel::find($id);
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

    /**
     * 通过 pid 获取链接列表
     */
    public function getLinksByPid()
    {
        $pid = $_POST['pid'];
        $models = LinkModel::where('pid',$pid)->get();
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
        ];
        echo json_encode($rstArr);exit;
    }

    public function store()
    {
        $name = $_POST['name'];
        $display_way = $_POST['display_way'];
        $cid = $_POST['cid'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $link = $_POST['link'];
        $pid = $_POST['pid'];
        if (!$name || !in_array($display_way,[1,2]) || !in_array($type,[1,2,3]) || !$link) {
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
            'display_way'   =>  $display_way,
            'cid'   =>  $cid,
            'title' =>  $title,
            'type'  =>  $type,
            'intro' =>  $intro,
            'link'  =>  $link,
            'pid'   =>  $pid,
            'created_at'    =>  time(),
        ];
        LinkModel::create($data);
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
        $display_way = $_POST['display_way'];
        $cid = $_POST['cid'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $link = $_POST['link'];
        $pid = $_POST['pid'];
        if (!$id || !$name || !in_array($display_way,[1,2]) || !in_array($type,[1,2,3]) || !$link) {
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
            'display_way'   =>  $display_way,
            'cid'   =>  $cid,
            'title' =>  $title,
            'type'  =>  $type,
            'intro' =>  $intro,
            'link'  =>  $link,
            'pid'   =>  $pid,
            'updated_at'    =>  time(),
        ];
        LinkModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置图片
     */
    public function setThumb()
    {
        $id = $_POST['id'];
        $thumb = $_POST['thumb'];
        if (!$id || !$thumb) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = LinkModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        LinkModel::where('id',$id)->update(['thumb'=>$thumb]);
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
        if (!$id || !$isshow) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = LinkModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        LinkModel::where('id',$id)->update(['isshow'=>$isshow]);
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
            'types' =>  $this->selfModel['types'],
            'ways'  =>  $this->selfModel['ways'],
            'isshows'    =>  $this->selfModel['isshows'],
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
     * 将 model 转化为 array
     */
    public function getArrByModel($model)
    {
        $data = $this->objToArr($model);
        $data['createTime'] = $model->createTime();
        $data['updateTime'] = $model->updateTime();
        $data['typeName'] = $model->getTypeName();
        $data['isshowName'] = $model->getIsshowName();
        $data['wayName'] = $model->getWayName();
        return $data;
    }
}