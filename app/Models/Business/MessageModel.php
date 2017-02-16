<?php
namespace App\Models\Business;

class MessageModel extends BaseModel
{
    protected $table = 'bs_message';
    protected $fillable = [
        'id','title','genre','intro','sender','senderTime','accept','acceptTime','status','del','created_at','updated_at',
    ];

    protected $genres = [
        1=>'个人消息','企业消息',
    ];
    //1未发送，2已发送未接收，3已接收未读，4已读
    protected $statuss = [
        1=>'未发送','已发送未接收','已接收未读','已读',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function senderTime()
    {
        return $this->senderTime ? date('Y年m月d日 H:i',$this->senderTime) : '未发送';
    }

    public function acceptTime()
    {
        return $this->acceptTime ? date('Y年m月d日 H:i',$this->acceptTime) : '未接收';
    }

    public function getStatusName()
    {
        return array_key_exists($this->status,$this->statuss) ? $this->statuss[$this->status] : '';
    }
}