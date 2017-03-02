<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\AdModel;

class AdController extends BaseController
{
    /**
     * 广告
     */

    public function __construct()
    {
        parent::__construct();
        $this->selfModel = new AdModel();
    }

    public function index()
    {
        $uid = $_POST['uid'];
        $adplace = $_POST['adplace'];
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $isuse = $_POST['isuse'];
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;        //每页显示记录数
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;       //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        if ((!$fromTime&&$toTime) || ($fromTime&&!$toTime)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $isuseArr = $isuse ? [$isuse] : [0,1,2];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            if ($adplace && ($fromTime && $toTime)) {
                $query = AdModel::where('uid',$uid)
                    ->where('adplace_id',$adplace)
                    ->where('fromTime','<',time())
                    ->where('toTime','>',time());
            } else if (!$adplace && ($fromTime && $toTime)) {
                $query = AdModel::where('uid',$uid)
                    ->where('fromTime','<',time())
                    ->where('toTime','>',time());
            } else if ($adplace && !($fromTime && $toTime)) {
                $query = AdModel::where('uid',$uid)
                    ->where('adplace_id',$adplace);
            } else {
                $query = AdModel::where('uid',$uid);
            }
        } else {
            if ($adplace && ($fromTime && $toTime)) {
                $query = AdModel::where('adplace_id',$adplace)
                    ->where('fromTime','<',time())
                    ->where('toTime','>',time());
            } else if (!$adplace && ($fromTime && $toTime)) {
                $query = AdModel::where('fromTime','<',time())
                    ->where('toTime','>',time());
            } else if ($adplace && !($fromTime && $toTime)) {
                $query = AdModel::where('adplace_id',$adplace);
            } else {
                $query = AdModel::where('uid','>',-1);
            }
        }
        $models = $query->whereIn('isuse',$isuseArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
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
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['adplaceName'] = $model->getAdplaceName();
            $datas[$k]['fromTimeName'] = $model->getFromTimeName();
            $datas[$k]['toTimeName'] = $model->getToTimeName();
            $datas[$k]['period'] = $model->period();
            $datas[$k]['isauthName'] = $model->getIsauthName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
            $datas[$k]['isuseName'] = $model->getIsuseName();
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
        $model = AdModel::find($id);
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
        $datas['adplaceName'] = $model->getAdplaceName();
        $datas['fromTimeName'] = $model->getFromTimeName();
        $datas['toTimeName'] = $model->getToTimeName();
        $datas['period'] = $model->period();
        $datas['isauthName'] = $model->getIsauthName();
        $datas['isshowName'] = $model->getIsshowName();
        $datas['isuseName'] = $model->getIsuseName();
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
        $adplace = $_POST['adplace'];
        $intro = $_POST['intro'];
        $link = $_POST['link'];
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $uid = $_POST['uid'];
        if (!$name || !$adplace || !$link || !$uid) {
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
            'adplace_id'    =>  $adplace,
            'intro'     =>  $intro,
            'link'      =>  $link,
            'fromTime'  =>  $fromTime,
            'toTime'    =>  $toTime,
            'uid'       =>  $uid,
            'created_at'    =>  time(),
        ];
        AdModel::create($data);
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
        $adplace = $_POST['adplace'];
        $intro = $_POST['intro'];
        $link = $_POST['link'];
        $fromTime = $_POST['fromTime'];
        $toTime = $_POST['toTime'];
        $uid = $_POST['uid'];
        if (!$id || !$name || !$adplace || !$link || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = AdModel::find($id);
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
            'adplace_id'    =>  $adplace,
            'intro'     =>  $intro,
            'link'      =>  $link,
            'fromTime'  =>  $fromTime,
            'toTime'    =>  $toTime,
            'uid'       =>  $uid,
            'updated_at'    =>  time(),
        ];
        AdModel::where('id',$id)->update($data);
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
        $model = AdModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        AdModel::where('id',$id)->update(['thumb'=>$thumb]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置是否启用
     */
    public function setUse()
    {
        $id = $_POST['id'];
        $isuse = $_POST['isuse'];
        if (!$id || !in_array($isuse,[1,2])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = AdModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        AdModel::where('id',$id)->update(['isuse'=>$isuse]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function getModel()
    {
        $model = [
            'isauths'   =>  $this->selfModel['isauths'],
            'isuses'    =>  $this->selfModel['isuses'],
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