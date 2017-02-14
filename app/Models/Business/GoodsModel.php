<?php
namespace App\Models\Business;

class GoodsModel extends BaseModel
{
    /**
     * goods 商品、货物，代表视频类产品
     */

    protected $table = 'bs_goods';
    protected $fillable = [
        'id','name','genre','cate','intro','title','thumb','link','uid','uname','click','recommend','newest','sort','isshow','del','created_at','updated_at',
    ];
    //片源类型：1个人需求，2设计师供应，3企业需求，4企业供应
    protected $genres = [
        1=>'个人需求','设计师供应','企业需求','企业供应',
    ];
    protected $recommends = [
        1=>'不推荐','推荐',
    ];
    protected $isshows = [
        1=>'不显示','显示',
    ];
    protected $newests = [
        1=>'非最新','最新',
    ];

    public function getGenreName()
    {
        return $this->genre ? $this->genres[$this->genre] : '';
    }

    public function getTitleName()
    {
        return $this->title ? $this->title : $this->name;
    }

    public function getRecommendName()
    {
        return array_key_exists($this->recommend,$this->recommends) ? $this->recommends[$this->recommend] : '';
    }

    public function getIsshowName()
    {
        return array_key_exists($this->isshow,$this->isshows) ? $this->isshows[$this->isshow] : '';
    }

    /**
     *  样片类别
     */
    public function getCateName()
    {
        return $this->cate ? $this->cates2[$this->cate] : '';
    }

//    /**
//     * 视频发布方信息
//     */
//    public function getUserInfo()
//    {
//        $companyMian = ComMainModel::where('uid',$this->uid)->first();
//        return $companyMian ? $companyMian : '';
//    }
//
//    /**
//     * 点击用户或关注用户
//     */
//    public function getClicks($uid)
//    {
//        $gid = $this->id ? $this->id : 0;
//        $clickModels = GoodsClickModel::where(array('gid'=>$gid, 'uid'=>$uid))->get();
//        return count($clickModels) ? count($clickModels) : 0;
//    }
//
//    /**
//     * 喜欢的用户
//     */
//    public function getLikes($uid)
//    {
//        $gid = $this->id ? $this->id : 0;
//        $likeModels = GoodsLikeModel::where(array('gid'=>$gid, 'uid'=>$uid))->get();
//        return count($likeModels) ? count($likeModels) : 0;
//    }
//
//    /**
//     * 根据类别cate，获取样片
//     */
//    public function getGoodsByCate($cate=1,$limit=5)
//    {
//        return GoodsModel::where('isshow',1)
//            ->where('isshow2',1)
//            ->where('cate',$cate)
//            ->where('del',0)
//            ->orderBy('sort','desc')
//            ->orderBy('id','desc')
//            ->paginate($limit);
//    }
}