<?php
namespace App\Models\Business;

class EntertainModel extends BaseModel
{
    protected $table = 'bs_entertains';
    protected $fillable = [
        'id','title','genre','intro','staff','uid','uname','sort','isshow','del','created_at','updated_at',
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

    public function getStaffName()
    {
        if ($staffIds=$this->getStaffs()) {
            $staffModels = StaffModel::whereIn('id',$staffIds)->get();
            foreach ($staffModels as $staffModel) { $staffNames[] = $staffModel->name; }
        }
        return isset($staffNames) ? implode(',',$staffNames) : '';
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