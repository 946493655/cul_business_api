<?php
namespace App\Models\Business;

class IdeasModel extends BaseModel
{
    /**
     * 这是用户表model
     */

    protected $table = 'bs_ideas';
    protected $fillable = [
        'id','name','cate','thumb','intro','content','uid','sort','isshow','del','created_at','updated_at',
    ];

    public function getCateName()
    {
       return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }
}