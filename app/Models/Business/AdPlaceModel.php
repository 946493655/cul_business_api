<?php
namespace App\Models\Business;

class AdPlaceModel extends BaseModel
{
    protected $table = 'bs_ad_places';
    protected $fillable = [
        'id','name','plat','intro','uid','width','height','money','number','created_at','updated_at',
    ];
    protected $plats = [
        1=>'网站前台','公司前台',
    ];

    public function getPlatName()
    {
        return array_key_exists($this->plat,$this->plats) ? $this->plats[$this->plat] : '';
    }
}