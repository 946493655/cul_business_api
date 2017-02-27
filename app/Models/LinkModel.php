<?php
namespace App\Models;

class LinkModel extends BaseModel
{
    protected $table = 'bs_links';
    protected $fillable = [
        'id','name','cid','title','type','thumb','intro','link','display_way','isshow','pid','sort','created_at','updated_at',
    ];

    protected $types = [
        1=>'header头链接','navigate菜单导航栏链接','footer脚部链接',
    ];

    //链接类型display_way：1文字链接、2图片链接
    protected $ways = [
        1=>'文字链接','图片链接'
    ];

    public function getTypeName()
    {
        return array_key_exists($this->type,$this->types) ? $this->types[$this->type] : '';
    }

    public function getWayName()
    {
        return array_key_exists($this->display_way,$this->ways) ? $this->ways[$this->display_way] : '';
    }
}