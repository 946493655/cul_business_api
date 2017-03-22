<?php
namespace App\Models\Business;

class GoodsModel extends BaseModel
{
    /**
     * goods 商品、货物，代表视频类产品
     */

    protected $table = 'bs_goods';
    protected $fillable = [
        'id','name','genre','cate','intro','thumb','linkType','link','uid','money','isshow','del','created_at','updated_at',
    ];
    //制作类型：1动画片段供应，2动画片段需求，3视频供应，4视频需求
    protected $genres = [
        1=>'动画供应','动画需求','视频供应','视频需求',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }
}