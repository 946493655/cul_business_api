<?php
namespace App\Models\Business;

class GoodsHuaxuModel extends BaseModel
{
    /**
     * 片源定制值用户竞价表
     */

    protected $table = 'bs_goods_huaxu';
    protected $fillable = [
        'id','gid','uid','name','thumb','linkType','link','del','created_at','updated_at',
    ];
}