<?php
namespace App\Models\Business;

class GoodsCusModel extends BaseModel
{
    /**
     * 客户作品定制表
     */

    protected $table = 'bs_goodsCus';
    protected $fillable = [
        'id','name','intro','uid','money1','supply','money2','isshow','del','created_at','updated_at',
    ];

    /**
     * 确定状态
     */
    public function getStatusName()
    {
        if (!$this->supply || !$this->money2) {
            $statusName = '未定';
        } else {
            $statusName = '交易中';
        }
        return $statusName;
    }

//    /**
//     * 定制信息
//     */
//    public function getGoodCustoms()
//    {
//        return GoodsCusUserModel::where('cus_id',$this->id)->get();
//    }
}