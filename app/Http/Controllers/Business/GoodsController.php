<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\GoodsModel;

class GoodsController extends BaseController
{
    /**
     * 产品(发布的)
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new GoodsModel();
    }

    public function index()
    {
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if (!$genre) {
            $genreArr = [0,1,2,3,4];
        } elseif (is_array($genre)) {
            $genreArr = $genre;
        } else {
            $genreArr = [$genre];
        }
        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $query = GoodsModel::where('uid',$uid)
                ->whereIn('genre',$genreArr);
        } else {
            $query = GoodsModel::whereIn('genre',$genreArr);
        }
        $models = $query->whereIn('cate',$cateArr)
            ->whereIn('isshow',$isshowArr)
            ->where('del',$del)
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->whereIn('cate',$cateArr)
            ->whereIn('isshow',$isshowArr)
            ->where('del',$del)
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
     * 通过 uid 获取列表
     */
    public function getGoodsByUid()
    {
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        if (!$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        if (!$genre) {
            $genreArr = [1,2,3,4];
        } elseif (is_array($genre)) {
            $genreArr = $genre;
        } else {
            $genreArr = [$genre];
        }
        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $models = GoodsModel::whereIn('genre',$genreArr)
            ->whereIn('cate',$cateArr)
            ->where('uid',$uid)
            ->where('del',0)
            ->orderBy('id','desc')
            ->get();
        $total = GoodsModel::whereIn('genre',$genreArr)
            ->whereIn('cate',$cateArr)
            ->where('uid',$uid)
            ->where('del',0)
            ->count();
        if (!$models) {
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
        $model = GoodsModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
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
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        $money = $_POST['money'];
        $uid = $_POST['uid'];
        if (!$name || !$genre || !$cate || !$uid) {
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
            'money' =>  $money,
            'uid'   =>  $uid,
            'created_at'    =>  time(),
        ];
        GoodsModel::create($data);
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
        if (!$id || !$name || !$genre || !$cate || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = GoodsModel::find($id);
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
            'genre' =>  $genre,
            'cate'  =>  $cate,
            'intro' =>  $intro,
            'money' =>  $money,
            'uid'   =>  $uid,
            'updated_at'    =>  time(),
        ];
        GoodsModel::where('id',$id)->update($data);
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
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = GoodsModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        GoodsModel::where('id',$id)->update(['thumb'=>$thumb, 'updated_at'=>time()]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置视频链接
     */
    public function setLink()
    {
        $id = $_POST['id'];
        $uid = $_POST['uid'];
        $linkType = $_POST['linkType'];
        $link = $_POST['link'];
        if (!$id || !$uid || !$linkType || !$link) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = GoodsModel::where('id',$id)->where('uid',$uid)->first();
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
            'linkType'  =>  $linkType,
            'link'      =>  $link,
            'updated_at'    =>  time(),
        ];
        GoodsModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置显示/隐藏
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
        $model = GoodsModel::find($id);
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
            'isshow'        =>  $isshow,
            'updated_at'    =>  time(),
        ];
        GoodsModel::where('id',$id)->update($data);
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
            'linkTypes'     =>  $this->selfModel['linkTypes'],
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

    /**
     * model 转为 array
     */
    public function getArrByModel($model)
    {
        $data = $this->objToArr($model);
        $data['createTime'] = $model->createTime();
        $data['updateTime'] = $model->updateTime();
        $data['genreName'] = $model->getGenreName();
        $data['cateName'] = $model->getCateName();
        $data['isshowName'] = $model->getIsshowName();
        return $data;
    }
}