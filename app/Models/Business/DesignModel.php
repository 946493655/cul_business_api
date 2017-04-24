<?php
namespace App\Models\Business;

class DesignModel extends BaseModel
{
    protected $table = 'bs_designs';
    protected $fillable = [
        'id','name','genre','cate','uid','intro','thumb','file','money','thumb','click','sort','isshow','del','created_at','updated_at',
    ];
    //1企业供应，2企业需求，3个人供应，4个人需求
    protected $genres = [
        '/',1=>'个人供应','个人需求','企业供应','企业需求',
    ];

    /**
     * file：类型(1站内/2站外)，链接，分享码
     */

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates1) ? $this->cates1[$this->cate] : '';
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