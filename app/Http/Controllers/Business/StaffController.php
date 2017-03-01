<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\StaffModel;

class StaffController extends BaseController
{
    /**
     * 人员
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new StaffModel();
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
        $typeArr = $type ? [$type] : [
                        0,1,2,3,4,5,
                        21,22,23,24,25,
                    ];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $models = StaffModel::where('uid',$uid)
                ->where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StaffModel::where('uid',$uid)
                ->where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
                ->count();
        } else {
            $models = StaffModel::where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = StaffModel::where('del',$del)
                ->whereIn('genre',$genreArr)
                ->whereIn('type',$typeArr)
                ->whereIn('isshow',$isshowArr)
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
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['sexName'] = $model->getSexName();
            $datas[$k]['eduName'] = $model->getEduName();
            $datas[$k]['hobbys'] = $model->getHobbys();
            $datas[$k]['hobbyName'] = $model->getHobbyName();
            $datas[$k]['etName'] = $model->getEntertainTitle();
            $datas[$k]['isshowName'] = $model->getIsshowName();
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
     * 通过 uid 获取艺人列表
     */
    public function getStaffsByUid()
    {
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        $type = $_POST['type'];
        if (!$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $genreArr = $genre ? [$genre] : [0,1,2];
        $typeArr = $type ? [$type] : [0,1,2,3,4,5,21,22,23,24,25];
        $models = StaffModel::where('uid',$uid)
            ->whereIn('genre',$genreArr)
            ->whereIn('type',$typeArr)
            ->where('isshow',2)
            ->where('del',0)
            ->orderBy('id','desc')
            ->get();
        $total = StaffModel::where('uid',$uid)
            ->whereIn('genre',$genreArr)
            ->whereIn('type',$typeArr)
            ->where('isshow',2)
            ->where('del',0)
            ->count();
        if (!$models) {
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
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['sexName'] = $model->getSexName();
            $datas[$k]['eduName'] = $model->getEduName();
            $datas[$k]['hobbys'] = $model->getHobbys();
            $datas[$k]['hobbyName'] = $model->getHobbyName();
            $datas[$k]['etName'] = $model->getEntertainTitle();
            $datas[$k]['isshowName'] = $model->getIsshowName();
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
        $model = StaffModel::find($id);
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
        $datas['sexName'] = $model->getSexName();
        $datas['eduName'] = $model->getEduName();
        $datas['hobbys'] = $model->getHobbys();
        $datas['hobbyName'] = $model->getHobbyName();
        $datas['etName'] = $model->getEntertainTitle();
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
        $sex = $_POST['sex'];
        $realname = $_POST['realname'];
        $origin = $_POST['origin'];
        $edu = $_POST['edu'];
        $school = $_POST['school'];
        $hobby = $_POST['hobby'];
        $height = $_POST['height'];
        $type = $_POST['type'];
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        if (!$name || !$sex || !$realname || !$origin || !$edu || !$school || !$hobby || !$height || !$type || !$uid) {
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
            'sex'   =>  $sex,
            'realname'  =>  $realname,
            'origin'    =>  $origin,
            'education' =>  $edu,
            'school'    =>  $school,
            'hobby'     =>  $hobby,
            'height'    =>  $height,
            'type'      =>  $type,
            'uid'       =>  $uid,
            'genre'     =>  $genre,
            'created_at'    =>  time(),
        ];
        StaffModel::create($data);
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
        $sex = $_POST['sex'];
        $realname = $_POST['realname'];
        $origin = $_POST['origin'];
        $edu = $_POST['edu'];
        $school = $_POST['school'];
        $hobby = $_POST['hobby'];
        $height = $_POST['height'];
        $type = $_POST['type'];
        $uid = $_POST['uid'];
        $genre = $_POST['genre'];
        if (!$id || !$name || !$sex || !$realname || !$origin || !$edu || !$school || !$hobby || !$height || !$type || !$uid) {
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
            'sex'   =>  $sex,
            'realname'  =>  $realname,
            'origin'    =>  $origin,
            'education' =>  $edu,
            'school'    =>  $school,
            'hobby'     =>  $hobby,
            'height'    =>  $height,
            'updated_at'    =>  time(),
        ];
        StaffModel::where('id',$id)->update($data);
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
            'edus'    =>  $this->selfModel['educations'],
            'hobbys'    =>  $this->selfModel['hobbys'],
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