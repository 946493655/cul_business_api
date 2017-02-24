<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected $isshows = [
        1=>'不显示','显示',
    ];

    protected $dels = [
        '删除','不删除',
    ];

    //支持 DesignModel
    //类型：房产，效果图，平面，漫游
    protected $cates1 = [
        1=>'房产漫游','效果图','平面设计',
    ];

    //支持 IdeasModel、StoryBoardModel、GoodsModel、WorksModel
    //样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影，13个人短片，
    protected $cates2 = [
        1=>'电视剧','电影','微电影','广告','宣传片','专题片','汇报片','主题片','纪录片','晚会','淘宝视频','婚纱摄影','个人短片',
    ];

    //支持 OrderModel、OrdersFirmModel、OrdersProdustModel
    //视频格式：网络版640*480，标清720*576，小高清1280*720，高清1920*1080，
    protected $formats = [
        1=>'640*480','720*576','1280*720','1920*1080',
    ];
    protected $formatNames = [
        1=>'网络版','标清','小高清','高清',
    ];

    /**
     * 创建时间转换
     */
    public function createTime()
    {
        return $this->created_at ? date("Y年m月d日", $this->created_at) : '';
    }

    /**
     * 更新时间转换
     */
    public function updateTime()
    {
        return $this->updated_at ? date("Y年m月d日", $this->updated_at) : '未更新';
    }

    public function getIsshowName()
    {
        return $this->isshow==2 ? '前台显示' : '前台不显示';
    }

    /**
     * 对象转数组
     */
    public function objToArr($obj)
    {
        return json_decode(json_encode($obj),true);
    }
}