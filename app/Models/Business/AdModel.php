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
    //控制开关isuse：0关闭，1开启，默认1
    protected $isuses = [
        1=>'使用','不使用',
    ];

    /**
     * 广告位
     */
    public function getAdplaceName()
    {
        $adplaceModel = AdPlaceModel::find($this->adplace_id);
        return $adplaceModel ? $adplaceModel->name : '';
    }

    /**
     * 审核状态
     */
    public function getIsauthName()
    {
        if ($this->uid) {
            $isauth = array_key_exists($this->isauth,$this->isauths) ? $this->isauths[$this->isauth] : '';
        } else {
            $isauth = '/';
        }
        return $isauth;
    }

    /**
     * 使用状态
     */
    public function getIsuseName()
    {
        return array_key_exists($this->isuse,$this->isuses) ? $this->isuses[$this->isuse] : '';
    }

    /**
     * 有效开始时间
     */
    public function getFromTimeName()
    {
        return date('Y年m月d日 H:i:s',$this->fromTime);
    }

    /**
     * 有效结束时间
     */
    public function getToTimeName()
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
}