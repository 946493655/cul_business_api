<?php
namespace App\Models\Business;

class DeliverysModel extends BaseModel
{
    /**
     * 视频投放媒介
     */

    protected $table = 'bs_deliverys';
    protected $fillable = [
        'id','name','genre','uid','thumb','money','fromtime','totime','intro','isshow','del','created_at','updated_at',
    ];

    //媒介类型：广告商，电视台，各大网站
    protected $genres = [
        1=>'广告商','电视台','各类网站',
    ];
}