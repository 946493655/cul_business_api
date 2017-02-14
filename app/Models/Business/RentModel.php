<?php
namespace App\Models\Business;

class RentModel extends BaseModel
{
    protected $table = 'bs_rents';
    protected $fillable = [
        'id','name','genre','type','thumb','intro','uid','area','money','sort','del','created_at','updated_at',
    ];
    //类型：1供应，2需求
    protected $genres = [
        1=>'供应','需求',
    ];
    //设备类型：1摄像机，2摇臂，3转接器，4镜头，5轨道车，6脚轮，7脚架，8话筒，9调音台，10监视器，11灯光，12反光板，13柔光板，14采集卡，15硬盘，
    protected $types = [
        1=>'摄像机','摇臂','转接器','镜头','轨道车','脚轮','脚架','话筒','调音台','监视器','灯光','反光板','柔光板','采集卡','硬盘',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getTypeName()
    {
       return array_key_exists($this->type,$this->types) ? $this->types[$this->type] : '';
    }

    /**
     * 有效期
     */
    public function period()
    {
        $statusName = '';
        if ($this->fromtime>time() && $this->totime<time()) {
            $statusName = '有效期内';
        } elseif ($this->fromtime < time()) {
            $statusName = '已过期';
        } elseif ($this->totime > time()) {
            $statusName = '未开始';
        }
        return $statusName;
    }
}