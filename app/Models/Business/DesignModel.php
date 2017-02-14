<?php
namespace App\Models\Business;

class DesignModel extends BaseModel
{
    protected $table = 'bs_designs';
    protected $fillable = [
        'id','name','genre','cate','uid','intro','detail','money','thumb','click','sort','isshow','del','created_at','updated_at',
    ];
    //1企业供应，2企业需求，3个人供应，4个人需求
    protected $genres = [
        1=>'个人供应','个人需求','企业供应','企业需求',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates1) ? $this->cates1[$this->cate] : '';
    }
}