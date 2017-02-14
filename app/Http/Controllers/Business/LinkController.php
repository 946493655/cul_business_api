<?php
namespace App\Http\Controllers\Business;

use App\Models\LinkModel;

class LinkController extends BaseController
{
    /**
     * 链接
     */

    public function index()
    {
        $cid = $_POST['cid'];
        $type = $_POST['type'];
        $isshow = (isset($_POST['isshow'])&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        if (!$type) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = LinkModel::where('type_id', $type)
            ->where('cid', $cid)
            ->whereIn('isshow', $isshowArr)
            ->orderBy('sort', 'asc')
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
            $datas[$k]['typeName'] = $model->getTypeName();
            $datas[$k]['isshowName'] = $model->getIsshowName();
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
}