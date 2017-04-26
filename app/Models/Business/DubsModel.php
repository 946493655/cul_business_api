<?php
namespace App\Models\Business;

class DubsModel extends BaseModel
{
    /**
     * 配音model
     */

    protected $table = 'bs_dubs';
    protected $fillable = [
        'id','name','genre','uid','link','money','words','intro','isshow','del','created_at','updated_at',
    ];

    //配音类型，按年龄分：1小孩男，2小孩女，3少年男，4少年女，5青年男，6青年女，7中年男，8中年女，9老年男，10老年女
    protected $genres = [
        1=>'小孩男','小孩女','少年男','少年女','青年男','青年女','中年男','中年女','老年男','老年女',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }
}