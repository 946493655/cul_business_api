<?php
namespace App\Models\Business;

class GoodsCusUsersModel extends BaseModel
{
    /**
     * 片源定制值用户竞价表
     */

    protected $table = 'bs_goodsCus_users';
    protected $fillable = [
        'id','cus_id','uid','intro','money','period','del','created_at','updated_at',
    ];
}