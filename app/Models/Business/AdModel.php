<?php
namespace App\Models\Business;

class AdModel extends BaseModel
{
    protected $table = 'bs_ads';
    protected $fillable = [
        'id','name','adplace_id','intro','img','link','fromTime','toTime','uid','isauth','isshow','isuse','created_at','updated_at',
    ];
    protected $isauths = [
        1=>'未审核','未通过审核','通过审核',
    ];
    //前台是否显示isshow：1不显示，2显示，默认2
    protected $isshows = [
        1=>'不显示','显示',
    ];
    //控制开关isuse：0关闭，1开启，默认1
    protected $isuses = [
        1=>'使用','不使用',
    ];

    public function isshow()
    {
        return $this->isshow ? '显示' : '不显示';
    }

    public function isuse()
    {
        return $this->isuse ? '使用' : '不使用';
    }

    /**
     * 审核状态
     */
    public function isauth()
    {
        if ($this->uid) {
            $isauth = array_key_exists($this->isauth,$this->isauths) ? $this->isauths[$this->isauth] : '';
        } else {
            $isauth = '/';
        }
        return $isauth;
    }

    /**
     * 关联广告位
     */
    public function adplace()
    {
        $adplaceModel = AdPlaceModel::find($this->adplace_id);
        return $adplaceModel ? $adplaceModel : '';
    }

    /**
     * 广告位名称
     */
    public function getAdplaceName()
    {
        return $this->adplace() ? $this->adplace()->name : '';
    }

    /**
     * 有效开始时间
     */
    public function fromTime()
    {
        return date('Y年m月d日 H:i:s',$this->fromTime);
    }

    /**
     * 有效结束时间
     */
    public function toTime()
    {
        return date('Y年m月d日 H:i:s',$this->toTime);
    }

    /**
     * 广告有效期
     */
    public function period()
    {
        if ($this->fromTime > time()) {
            $periodName = '未开始';
        } elseif ($this->fromTime < time() && $this->toTime > time()) {
            $periodName = '进行中';
        } elseif ($this->toTime < time()) {
            $periodName = '已过期';
        }
        return isset($periodName) ? $periodName : '';
    }

//    /**
//     * 所有广告位
//     */
//    public function adplaces()
//    {
//        return AdPlaceModel::all();
//    }

//    /**
//     * 指定用户的所有广告位
//     */
//    public function userAdplaces($uid=0)
//    {
//        return AdPlaceModel::where('plat',2)->whereIn('uid',[0,$uid])->get();
//    }

//    /**
//     * 申请使用的企业
//     */
//    public function getUName()
//    {
//        if ($this->uid) {
//            $uname = $this->getCompanyName($this->uid) ? $this->getCompanyName($this->uid) : $this->getUserName($this->uid);
//        } else {
//            $uname = '本站';
//        }
//        return $uname;
//    }
}