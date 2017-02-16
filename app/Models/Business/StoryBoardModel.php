<?php
namespace App\Models\Business;

class StoryBoardModel extends BaseModel
{
    /**
     * 分镜模型
     */
    protected $table = 'bs_storyboards';
    protected $fillable = [
        'id','name','genre','cate','thumb','detail','intro','uid','uname','money','isnew','ishot','sort','isshow','del','created_at','updated_at',
    ];
    protected $genres = [
        1=>'企业供应','企业需求','个人供应','个人需求',
    ];
    protected $isnews = [
        1=>'不是','是'
    ];
    protected $ishots = [
        1=>'不是','是'
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }

    /**
     * 是否为最新记录
     */
    public function getIsnewName()
    {
        return $this->isnew==2 ? '最新' : '非最新';
    }

    /**
     * 是否为最热记录
     */
    public function getIshotName()
    {
        return $this->ishot==2 ? '最热' : '非最热';
    }

//    public function getLike()
//    {
//        $likeModels = StoryBoardLikeModel::where('sbid',$this->id)->get();
//        return $likeModels ? count($likeModels) : 0;
//    }

//    /**
//     * 细节查看权限
//     */
//    public function getShow()
//    {
//        if ($this->genre==1) {
//            //供应分镜
//            $orderModel = OrderModel::where('buyer',$this->uid)
//                ->where('status','>',11)
//                ->where('isshow',1)
//                ->where('del',0)
//                ->first();
//        } elseif ($this->genre==2) {
//            //需求分镜
//            $orderModel = OrderModel::where('seller',$this->uid)
//                ->where('status','>',11)
//                ->where('isshow',1)
//                ->where('del',0)
//                ->first();
//        }
//        return (isset($orderModel)&&$orderModel) ? 1 : 0;
//    }
}