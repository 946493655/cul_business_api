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
        $recommend = $_POST['recommend'];
        $newest = $_POST['newest'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if (!$genre) {
            $genreArr = [1,2,3,4];
        } elseif (is_array($genre)) {
            $genreArr = $genre;
        } else {
            $genreArr = [$genre];
        }
        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $recommendArr = $recommend ? [$recommend] : [0,1,2];
        $newestArr = $newest ? [$newest] : [0,1,2];
        if ($uid) {
            $models = GoodsModel::where('uid',$uid)
                ->whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->whereIn('recommend',$recommendArr)
                ->whereIn('newest',$newestArr)
                ->whereIn('isshow',$isshowArr)
                ->where('del',$del)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = GoodsModel::whereIn('genre',$genreArr)
                ->whereIn('cate',$cateArr)
                ->whereIn('recommend',$recommendArr)
                ->whereIn('newest',$newestArr)
                ->whereIn('isshow',$isshowArr)
                ->where('del',$del)
                ->orderBy('sort','desc')
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
//        static $number = 1;
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['titleName'] = $model->getTitleName();
            $datas[$k]['recommendName'] = $model->getRecommendName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
            $datas[$k]['cateName'] = $model->getCateName();
//            $datas[$k]['number'] = $number ++;
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
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['titleName'] = $model->getTitleName();
        $datas['genreName'] = $model->getGenreName();
        $datas['cateName'] = $model->getCateName();
        $datas['recommendName'] = $model->getRecommendName();
        $datas['isshowName'] = $model->getIsshowName();
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
            'uid'   =>  $uid,
            'uname' =>  $uname,
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
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$id || !$name || !$genre || !$cate || !$uid || !$uname) {
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
            'uid'   =>  $uid,
            'uname' =>  $uname,
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
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'genres'    =>  $this->selfModel['genres'],
            'cates'     =>  $this->selfModel['cates2'],
            'linkTypes'     =>  $this->selfModel['linkTypes'],
            'recommends'    =>  $this->selfModel['recommends'],
            'newests'   =>  $this->selfModel['newests'],
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
}