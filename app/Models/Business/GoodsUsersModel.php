<?php
namespace App\Models\Business;

class GoodsUsersModel extends BaseModel
{
    /**
     * 片源定制值用户竞价表
     */

    protected $table = 'bs_goods_users';
    protected $fillable = [
        'id','gid','uid','intro','money','period','del','created_at','updated_at',
    ];
}