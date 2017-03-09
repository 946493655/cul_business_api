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