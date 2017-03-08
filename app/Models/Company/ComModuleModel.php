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
    //功能类型：1公司(简介[1]、历程[2]、新闻[3]、咨询[4])，2服务，3团队，4招聘，5合作伙伴，6联系，21其他单页
    protected $genres = [
        1=>'公司信息(简介/历程/新闻/资讯)','服务内容','团队介绍','招聘管理','合作伙伴','联系方式(座机/手机/邮箱/具体地址/地图坐标)',
        //51以上为新的单页模块，51之前是预留的模块
        51=>'新的模块'
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }
}