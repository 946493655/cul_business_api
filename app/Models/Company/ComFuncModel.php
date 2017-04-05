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
        'id','name','cid','module_id','thumb','intro','small','sort','isshow','created_at','updated_at',
    ];

    /**
     * small备用字段：备用字段：
     *      如果是 5 服务，为小字，多组用|隔开；
     *      如果是 7 公司成员/招聘，为数字；
     *      如果是 8 合作伙伴，为链接；
     *      如果是 9 联系方式，为具体方式;
     *      如果是其他方式，可以先空着不填
     */
    public function getSmallArr()
    {
        $moduleType = $this->getModuleType();
        if (in_array($moduleType,[6,7,8])) {
            return $this->small;
        } else if (in_array($moduleType,[5,9])) {
            return $this->small ? array_filter(explode('|',$this->small)) : [];
        } else {
            return $this->small;
        }
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

    /**
     * 得到对应模块介绍
     */
    public function getModuleIntro()
    {
        $moduleModel = ComModuleModel::find($this->module_id);
        return $moduleModel ? $moduleModel->intro : '';
    }
}