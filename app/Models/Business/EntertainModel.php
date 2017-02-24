<?php
namespace App\Models\Business;

class EntertainModel extends BaseModel
{
    protected $table = 'bs_entertains';
    protected $fillable = [
        'id','title','genre','intro','staff','work','uid','uname','sort','isshow','del','created_at','updated_at',
    ];
    protected $genres = [
        1=>'企业供应','企业需求',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] :'';
    }

    public function getStaffs()
    {
        return $this->staff ? explode(',',$this->staff) : [];
    }

    //获取演员集合
    public function getStaffStr()
    {
        if ($staffIds=$this->getStaffs()) {
            $staffModels = StaffModel::whereIn('id',$staffIds)->where('type',1)->get();
            foreach ($staffModels as $staffModel) {
                $staffArr[] = $staffModel->name;
            }
        }
        return isset($staffArr) ? implode(',',$staffArr) : '';
    }

    public function getWorks()
    {
        return $this->work ? explode(',',$this->work) : [];
    }

    public function getWorksStr()
    {
        if ($workIds=$this->getWorks()) {
            $workModels = GoodsModel::whereIn('id',$workIds)
                ->where('genre',4)
                ->where('uid',$this->uid)
                ->get();
            foreach ($workModels as $workModel) {
                $workArr[] = $workModel->name;
            }
        }
        return isset($workArr) ? implode(',',$workArr) : '';
    }

//    /**
//     * 娱乐公司的所有图片
//     */
//    public function getPics()
//    {
//        $entertainid = $this->id ? $this->id : 0;
//        return EntertainPicModel::where('entertain_id',$entertainid)->get();
//    }
}