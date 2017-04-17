<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\HuaxuModel;

class HuaxuController extends BaseController
{
    /**
     * 视频制作花絮
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new HuaxuModel();
    }

    public function index()
    {
        $genre = $_POST['genre'];
        $uid = $_POST['uid'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if (!$genre) {
            $genreArr = [0,1,2,3,4,5];
        } else if (is_array($genre)) {
            $genreArr = $genre;
        } else {
            $genreArr = [$genre];
        }
        if ($uid && $genreArr) {
            $query = HuaxuModel::whereIn('genre',$genreArr)
                ->where('del',$del)
                ->where('uid',$uid);
        } else if (!$uid && $genreArr) {
            $query = HuaxuModel::whereIn('genre',$genreArr)
                ->where('del',$del);
        } else if ($uid && !$genreArr) {
            $query = HuaxuModel::where('del',$del)
                ->where('uid',$uid);
        } else {
            $query = HuaxuModel::where('del',$del);
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

    public function store()
    {
        $genre = $_POST['genre'];
        $name = $_POST['name'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$name || !$intro || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);
        }
        $data = [
            'genre' =>  $genre,
            'name'  =>  $name,
            'intro' =>  $intro,
            'uid'   =>  $uid,
            'uname' =>  $uname,
            'created_at'    =>  time(),
        ];
        HuaxuModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);
    }

    public function modify()
    {
        $id = $_POST['id'];
        $genre = $_POST['genre'];
        $name = $_POST['name'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$id || !$name || !$intro || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);
        }
        $data = [
            'genre' =>  $genre,
            'name'  =>  $name,
            'intro' =>  $intro,
            'uid'   =>  $uid,
            'uname' =>  $uname,
            'created_at'    =>  time(),
        ];
        HuaxuModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);
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
            echo json_encode($rstArr);
        }
        $model = HuaxuModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);
        }
        $datas = $this->getArrByModel($model);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);
    }





    /**
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'linkTypes'     =>  $this->selfModel['linkTypes'],
            'genres'        =>  $this->selfModel['genres'],
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
        $data['genreName'] = $model->getGenreName();
        $data['linkTypeName'] = $model->getLinkTypeName();
        return $data;
    }
}