<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\RentModel;

class RentController extends BaseController
{
    /**
     * 租赁
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new RentModel();
    }

    public function index()
    {
        $genre = $_POST['genre'];
        $type = $_POST['type'];
        $uid = $_POST['uid'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $genreArr = $genre ? [$genre] : [0,1,2];
        $typeArr = $type ? [$type] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $models = RentModel::where('uid',$uid)
                ->where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = RentModel::where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
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
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['period'] = $model->period();
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
     * 通过价格，获取列表
     */
    public function getRentsByMoney()
    {
        $type = $_POST['type'];
        $fromMoney = $_POST['fromMoney'];
        $toMoney = $_POST['toMoney'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);
        if ($fromMoney > $toMoney) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $typeArr = $type ? [$type] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $models = RentModel::where('genre',1)
            ->where('isshow',2)
            ->whereBetween('money',[$fromMoney,$toMoney])
            ->whereIn('type',$typeArr)
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
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['period'] = $model->period();
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
        $model = RentModel::find($id);
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
        $datas['typeName'] = $model->getTypeName();
        $datas['period'] = $model->period();
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
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $money = $_POST['money'];
        if (!$name || !$genre || !$type || !$uid) {
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
            'type'  =>  $type,
            'intro' =>  $intro,
            'uid'   =>  $uid,
            'money' =>  $money,
            'created_at'    =>  time(),
        ];
        RentModel::create($data);
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
        $type = $_POST['type'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $money = $_POST['money'];
        if (!$id || !$name || !$genre || !$type || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = RentModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'genre' =>  $genre,
            'type'  =>  $type,
            'intro' =>  $intro,
            'uid'   =>  $uid,
            'money' =>  $money,
            'updated_at'    =>  time(),
        ];
        RentModel::where('id',$id)->update($data);
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
            'types'     =>  $this->selfModel['types'],
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