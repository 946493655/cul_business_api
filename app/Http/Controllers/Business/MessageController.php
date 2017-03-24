<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\MessageModel;

class MessageController extends BaseController
{
    /**
     * 消息
     */

    public function index()
    {
        $uid = $_POST['uid'];
        $menu = $_POST['menu'];
        $status = $_POST['status'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $isshowArr = $isshow ? [$isshow] : [0,1,2,];
        if (!$status) {
            $statusArr = [0,1,2,3,4];
        } else if (is_array($status)) {
            $statusArr = $status;
        } else {
            $statusArr = [$status];
        }
        if ($menu==1) {
            $query = MessageModel::where('accept',$uid)
                ->where('del',$del);
        } else if ($menu==2) {
            $query = MessageModel::where('sender',$uid)
                ->where('del',$del);
        } else {
            $query = MessageModel::where('del',$del);
        }
        $models = $query->whereIn('isshow',$isshowArr)
            ->whereIn('status',$statusArr)
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = $query->whereIn('isshow',$isshowArr)
            ->whereIn('status',$statusArr)
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
        $model = MessageModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //更新状态
        if ($model->status==3) {
            MessageModel::where('id',$id)->update(['status'=>4]);
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
        $title = $_POST['title'];
        $intro = $_POST['intro'];
        $sender = $_POST['sender'];
        $accept = $_POST['accept'];
        $status = $_POST['status'];
        if (!$title || !$intro || !$sender || !$accept || !$status) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'title' =>  $title,
            'intro' =>  $intro,
            'sender'    =>  $sender,
            'accept'    =>  $accept,
            'status'    =>  $status,
            'senderTime'    =>  time(),
            'created_at'    =>  time(),
        ];
        MessageModel::create($data);
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
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = MessageModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有记录！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        MessageModel::where('id',$id)->update(['isshow'=>$isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
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
        $data['getSenderTime'] = $model->getSenderTime();
        $data['getAcceptTime'] = $model->getAcceptTime();
        $data['genreName'] = $model->getGenreName();
        $data['statusName'] = $model->getStatusName();
        return $data;
    }
}