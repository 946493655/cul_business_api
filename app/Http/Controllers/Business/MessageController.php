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
        $genre = $_POST['genre'];
        $status = $_POST['status'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $genreArr = $genre ? [$genre] : [0,1,2];
        if (!$status) {
            $statusArr = [0,1,2,3,4];
        } else if (is_array($status)) {
            $statusArr = $status;
        } else {
            $statusArr = [$status];
        }
        $models = MessageModel::where('del',$del)
            ->whereIn('genre',$genreArr)
            ->whereIn('status',$statusArr)
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
            $datas[$k]['senderTime'] = $model->senderTime();
            $datas[$k]['acceptTime'] = $model->acceptTime();
            $datas[$k]['genreName'] = $model->getGenreName();
            $datas[$k]['statusName'] = $model->getStatusName();
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
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['getSenderTime'] = $model->getSenderTime();
        $datas['getAcceptTime'] = $model->getAcceptTime();
        $datas['genreName'] = $model->getGenreName();
        $datas['statusName'] = $model->getStatusName();
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
}