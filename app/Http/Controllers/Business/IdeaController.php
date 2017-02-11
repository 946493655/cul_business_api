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
        $del = (isset($_POST['del'])&&$_POST['del']) ? $_POST['del'] : 0;
        $isshow = (isset($_POST['isshow'])&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

        $delArr = $del ? [$del] : [0,1,2];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = IdeasModel::whereIn('del',$delArr)
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
        static $number = 1;
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['number'] = $number ++;;
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
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'cates' =>  $this->selfModel['cates1'],
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