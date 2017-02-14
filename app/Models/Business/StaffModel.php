<?php
namespace App\Models\Business;

class StaffModel extends BaseModel
{
    protected $table = 'bs_staffs';
    protected $fillable = [
        'id','name','et_id','uid','genre','type','thumb','sex','realname','origin','education','school','hobby',
        'area','height','sort','isshow','del','created_at','updated_at',
    ];
    protected $genres = [
        1=>'供应','需求',
    ];
    //1=>演员，导演，摄影师，灯光师，化妆师，21=>剪辑师，特效师，合成师，配音，背景音
    protected $types = [
        1=>'演员','导演','摄影师','灯光师','化妆师',
        //中间预留给前期，21开始为后期
        21=>'剪辑师','特效师','合成师','配音','背景音',
    ];
    protected $educations = [
        1=>'小学及以下','初中','高中','大学','研究生','博士','其他',
    ];
    protected $hobbys = [
        1=>'旅游','象棋','运动','看书','K歌','上网','交友','听歌','看电影','钓鱼','画画',
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getTypeName()
    {
        return array_key_exists($this->type,$this->types) ? $this->types[$this->type] : '';
    }

    public function getSexName()
    {
        return $this->sex==1 ? '男' : '女';
    }

    public function getEduName()
    {
        return array_key_exists($this->education,$this->educations) ? $this->educations[$this->education] : '';
    }

    public function getHobby()
    {
        $hobby = $this->hobby ? $this->hobby : '';
        return $hobby ? explode(',',$hobby) : [];
    }

    public function getHobbyName()
    {
        if ($hobbys = $this->getHobby()) {
            foreach ($hobbys as $hobby) {
                $hobbyName = $this->hobbys[$hobby];
                $hobbyArr[] = $hobbyName;
            }
        }
        return isset($hobbyArr) ? implode('，',$hobbyArr) : '';  //此处是中文的逗号
    }

    /**
     * 得到娱乐信息
     */
    public function entertain()
    {
        $entertainModel = EntertainModel::find($this->et_id);
        return $entertainModel ? $entertainModel : '';
    }

    /**
     * 得到娱乐标题
     */
    public function getEntertainTitle()
    {
        return $this->entertain() ? $this->entertain()->title : '';
    }
}