<?php
namespace App\Models\Business;

class EntertainModel extends BaseModel
{
    protected $table = 'bs_entertains';
    protected $fillable = [
        'id','title','genre','intro','uid','uname','sort','isshow','del','created_at','updated_at',
    ];
    protected $genres = [
        1=>'企业供应','企业需求',
    ];

//    /**
//     * 娱乐公司的所有图片
//     */
//    public function getPics()
//    {
//        $entertainid = $this->id ? $this->id : 0;
//        return EntertainPicModel::where('entertain_id',$entertainid)->get();
//    }
}