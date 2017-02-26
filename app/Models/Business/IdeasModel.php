<?php
namespace App\Models\Business;

class IdeasModel extends BaseModel
{
    /**
     * 这是用户表model
     */

    protected $table = 'bs_ideas';
    protected $fillable = [
        'id','name','genre','cate','intro','isdetail','detail','money','read','uid','sort','isshow','del','created_at','updated_at',
    ];

    protected $genres = [
        1=>'供应','需求',
    ];

    protected $isdetails = [
        1=>'不显示','显示',
    ];

    public function getCateName()
    {
       return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getIsDetailName()
    {
        return array_key_exists($this->isdetail,$this->isdetails) ? $this->isdetails[$this->isdetail] : '';
    }
}