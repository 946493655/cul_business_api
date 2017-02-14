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
        $genre = $_POST['genre'];
        $del = $_POST['del'];
        $isshow = $_POST['isshow'];
        $recommend = $_POST['recommend'];
        $newest = $_POST['newest'];
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
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $recommendArr = $recommend ? [$recommend] : [0,1,2];
        $newestArr = $newest ? [$newest] : [0,1,2];
        $models = GoodsModel::whereIn('genre',$genreArr)
            ->whereIn('del',$del)
            ->whereIn('recommend',$recommendArr)
            ->whereIn('newest',$newestArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
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

    /**
     * 通过 category 获取记录
     */
    public function getGoodsByCate()
    {
        $cate = $_POST['cate'];
        $limit = $_POST['limit'];
        if (!$cate) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = GoodsModel::where('cate',$cate)
            ->where('del',0)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->skip(1)
            ->take($limit)
            ->get();
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
            $datas[$k]['titleName'] = $model->getTitleName();
            $datas[$k]['recommendName'] = $model->getRecommendName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
            $datas[$k]['cateName'] = $model->getCateName();
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
        $datas['genreName'] = $model->getGenreName();
        $datas['titleName'] = $model->getTitleName();
        $datas['recommendName'] = $model->getRecommendName();
        $datas['isshowName'] = $model->getIsshowName();
        $datas['cateName'] = $model->getCateName();
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
            'genres'    =>  $this->selfModel['genres'],
            'cates'     =>  $this->selfModel['cates2'],
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