<?php
namespace App\Models\Business;

class AreaModel extends BaseModel
{
    protected $table = 'bs_citys';
    protected $fillable = [
        'id','parentid','cityname','nocode','zipcode','weathercode','created_at','updated_at',
    ];

    /**
     * 上级地区的名称
     */
    public function parent()
    {
        return $this->parentid ? AreaModel::find($this->parentid)->cityname : '0级';
    }

    /**
     * 通过 id 获取城市父子字符串，子id->父id往上找
     */
    public static function getAreaStr($area_id)
    {
        $areaModel = AreaModel::find($area_id);
        $areaStr = $areaModel?$areaModel->cityname:'';
        if ($areaModel && $areaModel->parentid!=0) {
            $areaModel2 = AreaModel::find($areaModel->parentid);
            if ($areaModel2) {
                $areaStr = $areaModel2->cityname.','.$areaStr;
            }
        }
        if ($areaModel && isset($areaModel2) && $areaModel2->parentid!=0) {
            $areaModel3 = AreaModel::find($areaModel2->parentid);
            if ($areaModel3) {
                $areaStr = $areaModel3->cityname.','.$areaStr;
            }
        }
        return $areaStr;
    }

//    /**
//     * 发布方名称：bs_order，bs_order_pro，bs_order_firm
//     */
//    public function getSellName()
//    {
//        $userModel = $this->getUser($this->seller);
//        return $userModel ? $userModel['username'] : '';
//    }
//
//    /**
//     * 申请方名称：bs_order，bs_order_pro，bs_order_firm
//     */
//    public function getBuyName()
//    {
//        $userModel = $this->getUser($this->buyer);
//        return $userModel ? $userModel['username'] : '';
//    }
}