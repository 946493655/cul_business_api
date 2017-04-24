<?php
namespace App\Models\Business;

class IdeasModel extends BaseModel
{
    /**
     * 这是用户表model
     */

    protected $table = 'bs_ideas';
    protected $fillable = [
        'id','name','genre','cate','intro','file','money','read','uid','sort','isshow','del','created_at','updated_at',
    ];

    protected $genres = [
        1=>'供应','需求',
    ];

    protected $isdetails = [
        1=>'不显示','显示',
    ];

    public function getCateName()
    {
       return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getFileArr()
    {
        return $this->file ? explode(',',$this->file) : [];
    }

    /**
     * 文件类型
     */
    public function getFileType()
    {
        $arr = $this->getFileArr();
        if (!$arr) { return 0; }
        if ($arr[0]==1) {
            return '站内上传的文件';
        } else {
            return '站外分享的文件';
        }
    }

    /**
     * 文件链接
     */
    public function getFileLink()
    {
        if ($arr = $this->getFileArr()) {
            return $arr[2];
        } else {
            return '';
        }
    }

    /**
     * 文件分享码
     */
    public function getFileCode()
    {
        if ($arr = $this->getFileArr()) {
            return $arr[3];
        } else {
            return '';
        }
    }
}