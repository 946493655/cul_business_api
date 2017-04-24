<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\IdeasModel;

class IdeaController extends BaseController
{
    /**
     * 创意
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new IdeasModel();
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

        $genreArr = $genre ? [$genre] : [0,1,2];
        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $query = IdeasModel::where('del',$del)
                ->where('uid',$uid);
        } else {
            $query = IdeasModel::where('del',$del);
        }
        $models = $query->whereIn('genre',$genreArr)
            ->whereIn('cate',$cateArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->whereIn('genre',$genreArr)
            ->whereIn('cate',$cateArr)
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
        static $number = 1;
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->getArrByModel($model);
            $datas[$k]['number'] = $number ++;
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
        $model = IdeasModel::find($id);
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
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $money = $_POST['money'];
        if (!$name || !$genre || !$cate || !$intro || !$uid) {
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
            'money' =>  $money,
            'created_at'    =>  time(),
        ];
        IdeasModel::create($data);
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
        $money = $_POST['money'];
        if (!$id || !$name || !$genre || !$cate || !$intro || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = IdeasModel::where('id',$id)->where('uid',$uid)->first();
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
            'isdetail' =>  $isdetail,
            'detail'    =>  $detail,
            'uid'   =>  $uid,
            'money' =>  $money,
            'updated_at'    =>  time(),
        ];
        IdeasModel::where('id',$id)->update($data);
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
    public static function setShow()
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
        $model = IdeasModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        IdeasModel::where('id',$id)->update(['isshow'=>$isshow]);
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
     * 数据对象转数组
     */
    public function getArrByModel($model)
    {
        $data = $this->objToArr($model);
        $data['createTime'] = $model->createTime();
        $data['updateTime'] = $model->updateTime();
        $data['genreName'] = $model->getGenreName();
        $data['cateName'] = $model->getCateName();
        $data['isshowName'] = $model->getIsshowName();
        $data['fileType'] = $model->getFileType();
        $data['fileLink'] = $model->getFileLink();
        $data['fileCode'] = $model->getFileCode();
        return $data;
    }
}