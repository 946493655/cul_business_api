<?php
namespace App\Models\Company;

use App\Models\BaseModel;

class ComFuncModel extends BaseModel
{
    /**
     * 企业模块
     */

    protected $table = 'com_funcs';
    protected $fillable = [
        'id','name','cid','module_id','img','intro','small','sort','isshow','created_at','updated_at',
    ];
    //功能类型：1简介，2历程，3新闻，4资讯，5服务，6团队，7招聘，单页
    protected $types = [
        1=>'简介','历程','新闻','资讯','服务','团队','招聘',
        51=>'单页'
    ];

    public function small()
    {
        return $this->small ? explode('|',$this->small) : '';
    }

    /**
     * 得到对应模块名称
     */
    public function getModuleName()
    {
        $moduleModel = ComModuleModel::find($this->module_id);
        return $moduleModel ? $moduleModel->name : '';
    }

    /**
     * 模块类型
     */
    public function getModuleType()
    {
        $moduleModel = ComModuleModel::find($this->module_id);
        return $moduleModel ? $moduleModel->genre : '';
    }

    /**
     * 模块类型名称
     */
    public function getModuleTypeName()
    {
        $moduleModel = ComModuleModel::find($this->module_id);
        return $moduleModel ? $moduleModel->getGenreName() : '';
    }
}