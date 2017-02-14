<?php
namespace App\Models\Business;

class ProVideoModel extends BaseModel
{
    /**
     * 动画/效果定制
     */

    protected $table = 'bs_pro_videos';
    protected $fillable = [
        'id','name','genre','cate','uid','intro','thumb','linkType','link','isshow','created_at','updated_at',
    ];
    //uid只对效果定制有效
    protected $genres = [
        1=>'动画定制','效果定制',
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