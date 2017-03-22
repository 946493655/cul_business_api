<?php
namespace App\Models;

class MenusModel extends BaseModel
{
    protected $table = 'bs_menus';
    protected $fillable = [
        'id','name','type','intro','namespace','controller_prefix','platUrl','url','action','style_class','pid','isshow','sort','created_at','updated_at',
    ];
    //菜单类型：会员后台member，个人后台person，企业后台company
    protected $types = [
        1=>'会员后台member',2=>'个人后台person',3=>'企业后台company',
    ];

    public function getTypeName()
    {
        return array_key_exists($this->type,$this->types) ? $this->types[$this->type] : '';
    }

    /**
     * 获取子菜单
     */
    public function getChild()
    {
        return MenusModel::where('pid',$this->id)
            ->where('isshow',2)
            ->orderBy('sort','desc')
            ->orderBy('id','asc')
            ->get();
    }

    /**
     * 获取完整url
     */
    public function getUrl()
    {
        if ($this->type==1) {
            $url = '/member/'.$this->url;
        } elseif ($this->type==2) {
            $url = '/person/'.$this->url;
        } elseif ($this->type==3) {
            $url = '/copany/'.$this->url;
        }
        return $url;
    }

    /**
     * 获取父名称
     */
    public function getParentName()
    {
        if ($this->pid==0) { return '顶级菜单'; }
        $parent = MenusModel::find($this->pid);
        return $parent ? $parent->name : '';
    }

    /**
     * 控制器名称
     */
    public function getController()
    {
        return $this->controller_prefix.'Controller';
    }
}