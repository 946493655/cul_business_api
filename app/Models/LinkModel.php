<?php
namespace App\Models;

class LinkModel extends BaseModel
{
    protected $table = 'bs_links';
    protected $fillable = [
        'id','name','cid','title','type_id','thumb','intro','link','display_way','isshow','pid','sort','created_at','updated_at',
    ];

    protected $types = [
        1=>'header头链接','navigate菜单导航栏链接','footer脚部链接',
    ];
    protected $isshows = [
       1=>'不显示','显示',
    ];

    public function getTypeName()
    {
        return $this->type_id ? $this->types[$this->type_id] : '';
    }

    public function getIsshowName()
    {
        return $this->isshow ? $this->isshows[$this->isshow] : '';
    }

//    /**
//     * 顶部链接：type_id==1
//     */
//    public static function headers()
//    {
//        return LinkModel::where('cid', 0)
//                ->where('type_id', 1)
//                ->where('isshow', 1)
//                ->orderBy('sort','desc')
//                ->get();
//    }
//
//    /**
//     * 头部链接：type_id==2
//     */
//    public static function navigates()
//    {
//        return LinkModel::where('cid', 0)
//                ->where('type_id', 2)
//                ->where('isshow', 1)
//                ->orderBy('sort','desc')
//                ->paginate(10);
//    }
//
//    /**
//     * 底部链接：type_id==3
//     */
//    public static function footers()
//    {
//        return LinkModel::where('cid', 0)
//                ->where('type_id', 3)
//                ->where('isshow', 1)
//                ->orderBy('sort','desc')
//                ->paginate(10);
//    }
}