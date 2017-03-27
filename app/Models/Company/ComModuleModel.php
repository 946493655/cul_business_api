<?php
namespace App\Models\Company;

use App\Models\BaseModel;

class ComModuleModel extends BaseModel
{
    /**
     * 企业模块
     */

    protected $table = 'com_modules';
    protected $fillable = [
        'id','name','cid','genre','intro','sort','isshow','created_at','updated_at',
    ];
    //功能类型：1公司简介，2历程，3新闻，4咨询，5服务，6团队，7招聘，8合作伙伴，9联系，51其他单页
    protected $genres = [
        1=>'公司简介','公司历程','公司新闻','公司资讯','服务内容','团队介绍','招聘管理','合作伙伴','联系方式(座机/手机/邮箱/具体地址/地图坐标)',
        //51以上为新的单页模块，51之前是预留的模块
        51=>'新的模块'
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }
}