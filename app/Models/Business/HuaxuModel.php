<?php
namespace App\Models\Business;

class HuaxuModel extends BaseModel
{
    /**
     * 用户企业花絮表
     */

    protected $table = 'bs_huaxu';
    protected $fillable = [
        'id','genre','fromid','uid','name','intro','thumb','linkType','link','del','created_at','updated_at',
    ];

    //花絮类型：1样片花絮，2故事脚本花絮，3租赁花絮，4娱乐花絮，5设计花絮
    protected $genres = [
        1=>'样片花絮','故事脚本','租赁花絮','娱乐花絮','设计花絮',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }
}