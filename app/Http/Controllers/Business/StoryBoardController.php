<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\StoryBoardModel;

class StoryBoardController extends BaseController
{
    /**
     * 分镜
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new StoryBoardModel();
    }

    public function index()
    {
        $uid = $_POST['uid'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $models = StoryBoardModel::where('uid',$uid)
                ->where('del',$del)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StoryBoardModel::where('uid',$uid)
                ->where('del',$del)
                ->whereIn('isshow',$isshowArr)
                ->count();
        } else {
            $models = StoryBoardModel::where('del',$del)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StoryBoardModel::where('del',$del)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
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
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
            $datas[$k]['isnewName'] = $model->getIsnewName();
            $datas[$k]['ishotName'] = $model->getIshotName();
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
     * 通过 way、category 获取列表
     * way：0 所有，1isnew，2ishot
     */
    public function getSBsByWay()
    {
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        $way = $_POST['way'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $genreArr = $genre ? [$genre] : [0,1,2,3,4];
        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        if ($way==1) {
            $models = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->where('isnew',1)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->where('isnew',1)
                ->count();
        } elseif ($way==2) {
            $models = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->where('ishot',1)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->where('ishot',1)
                ->count();
        } else {
            $models = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StoryBoardModel::where('isshow',2)
                ->where('del',0)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
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
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
            $datas[$k]['isnewName'] = $model->getIsnewName();
            $datas[$k]['ishotName'] = $model->getIshotName();
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
        $model = StoryBoardModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['genreName'] = $model->getGenreName();
        $datas['cateName'] = $model->getCateName();
        $datas['isshowName'] = $model->getIsshowName();
        $datas['isnewName'] = $model->getIsnewName();
        $datas['ishotName'] = $model->getIshotName();
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
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        $detail = $_POST['detail'];
        $money = $_POST['money'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$name || !$genre || !$cate || !$uid || !$uname) {
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
            'genre' =>  $genre,
            'cate'  =>  $cate,
            'intro' =>  $intro,
            'detail'    =>  $detail,
            'money'     =>  $money,
            'uid'       =>  $uid,
            'uname'     =>  $uname,
            'created_at'    =>  time(),
        ];
        StoryBoardModel::create($data);
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
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        $money = $_POST['money'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$id || !$name || !$genre || !$cate || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数要求！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = StoryBoardModel::where('id',$id)->where('uid',$uid)->first();
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
            'cate'  =>  $cate,
            'intro' =>  $intro,
            'money' =>  $money,
            'updated_at'    =>  time(),
        ];
        StoryBoardModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置缩略图
     */
    public function setThumb()
    {
        $id = $_POST['id'];
        $thumb = $_POST['thumb'];
        if (!$id || !$thumb) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数要求！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = StoryBoardModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        StoryBoardModel::where('id',$id)->update(['thumb'=>$thumb]);
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
                    'msg'   =>  '参数要求！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = StoryBoardModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        StoryBoardModel::where('id',$id)->update(['isshow'=>$isshow]);
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
            'cates'     =>  $this->selfModel['cates2'],
            'isshows'   =>  $this->selfModel['isshows'],
            'isnews'    =>  $this->selfModel['isnews'],
            'ishots'    =>  $this->selfModel['ishots'],
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