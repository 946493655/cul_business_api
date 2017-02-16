<?php
namespace App\Models\Business;

class GoodsModel extends BaseModel
{
    /**
     * goods 商品、货物，代表视频类产品
     */

    protected $table = 'bs_goods';
    protected $fillable = [
        'id','name','genre','cate','intro','title','thumb','linkType','link','uid','uname','click','recommend','newest','sort','isshow','del','created_at','updated_at',
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

    /**
     *  样片类别
     */
    public function getCateName()
    {
        return $this->cate ? $this->cates2[$this->cate] : '';
    }
}