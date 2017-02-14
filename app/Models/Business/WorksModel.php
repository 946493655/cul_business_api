<?php
namespace App\Models\Business;

class WorksModel extends BaseModel
{
    /**
     * 影视作品（包含电视剧、电影、广告等等）
     */

    protected $table = 'bs_works';
    protected $fillable = [
        'id','name','uid','cid','cate','intro','detail','thumb','linkType','link','sort','isshow','del','created_at','updated_at',
    ];

    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }

//    public function staff()
//    {
//        $worksid = $this->id ? $this->id : 0;
//        $staffWorks = StaffWorksModel::where('worksid',$worksid)->get();
//        if (count($staffWorks)) {
//            foreach ($staffWorks as $staffWork) {
//                $staffids[] = $staffWork->staffid;
//            }
//        }
//        return isset($staffids) ? StaffModel::whereIn('id',$staffids)->get() : [];
//    }
//
//    /**
//     * 得到该片演员
//     */
//    public function getActors()
//    {
//        $staffWorks = StaffWorksModel::where('works_id',$this->id)->get();
//        $staffIds = array();
//        if (count($staffWorks)) {
//            foreach ($staffWorks as $staffWork) {
//                $staffIds[] = $staffWork->id;
//            }
//        }
//        $staffModels = StaffModel::whereIn('id',$staffIds)->get();
//        return $staffModels ? $staffModels : [];
//    }
}