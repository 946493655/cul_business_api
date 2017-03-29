<?php
namespace App\Http\Controllers\Business;

use App\Models\Business\GoodsHuaxuModel;

class GoodsHuaxuController extends BaseController
{
    /**
     * 视频制作花絮
     */

    public function index()
    {
        $gid = $_POST['gid'];
        $uid = $_POST['uid'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit']) ? $_POST['limit'] : $this->limit;
        $page = (isset($_POST['page'])&&$_POST['page']) ? $_POST['page'] : 1;
        $start = $limit * ($page - 1);

//        if (!$uid) {
//            $rstArr = [
//                'error' =>  [
//                    'code'  =>  -1,
//                    'msg'   =>  '参数有误！',
//                ],
//            ];
//            echo json_encode($rstArr);exit;
//        }
        if ($uid && $gid) {
            $query = GoodsHuaxuModel::where('del',$del)
                ->where('uid',$uid)
                ->where('gid',$gid);
        } else if ($uid && !$gid) {
            $query = GoodsHuaxuModel::where('del',$del)
                ->where('uid',$uid);
        } else if (!$uid && $gid) {
            $query = GoodsHuaxuModel::where('del',$del)
                ->where('gid',$gid);
        } else {
            $query = GoodsHuaxuModel::where('del',$del);
        }
        $models = $query->where('gid',$gid)
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





    /**
     * 获取 model
     */
    public function getModel()
    {
        $model = [
            'linkTypes'     =>  $this->selfModel['linkTypes'],
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
        $data['linkTypeName'] = $model->getLinkTypeName();
        return $data;
    }
}