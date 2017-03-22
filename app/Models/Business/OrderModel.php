<?php
namespace App\Models\Business;

class OrderModel extends BaseModel
{
    /**
     * 用户意见model
     */
    protected $table = 'bs_orders';
    protected $fillable = [
        'id','name','serial','genre','fromid','seller','sellerName','uid','uname','money','weal','status','remarks','isshow','del','created_at','updated_at',
    ];

    protected $genres = [
        //1故事供应，2故事需求，3视频供应，4视频需求，5演员供应，6演员需求，7租赁供应，8租赁需求
        1=>'故事供应','故事需求','视频供应','视频需求','演员供应','演员需求','租赁供应','租赁需求',
    ];

    //订单状态：1待付首款至平台，2已付款，3办理中，4看样品，5待修改，6付尾款至平台,7交成品，8收款，9失败，10成功
    protected $statuss = [
        1=>'新订单','协商中','拒绝','确认','订单免费','订单收费','办理订单','确认收到','订单成功','订单失败'
    ];

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getStatusName()
    {
        return array_key_exists($this->status,$this->statuss) ? $this->statuss[$this->status] : '';
    }

//    public function getStatusBtn()
//    {
//        if (in_array($this->genre,[1,2,3,4])) {
//            $status = array_key_exists($this->status+1,$this->status1s)?$this->status1s[$this->status+1]:'';
//        } elseif (in_array($this->genre,[5,6])) {
//            $status = array_key_exists($this->status+1,$this->status2s)?$this->status2s[$this->status+1]:'';
//        } elseif (in_array($this->genre,[7,8,9,10,11,12])) {
//            $status = array_key_exists($this->status+1,$this->status3s)?$this->status3s[$this->status+1]:'';
//        }
//        return isset($status) ? $status : '';
//    }

//    /**
//     * 订单来源的数据
//     */
//    public function getModel()
//    {
//        if (in_array($this->genre,[1,2])) { $model = IdeasModel::find($this->fromid); }
//        elseif (in_array($this->genre,[3,4])) { $model = StoryBoardModel::find($this->fromid); }
//        elseif (in_array($this->genre,[5,6])) { $model = GoodsModel::find($this->fromid); }
//        return isset($model) ? $model : '';
//    }

    //以下是支付类方法

//    /**
//     * 获取对应支付信息
//     */
//    public function getPay()
//    {
//        $payModel = PayModel::where('genre',1)
//            ->where('order_id',$this->id)
//            ->first();
//        return $payModel ? $payModel : '';
//    }
//
//    /**
//     * 获取对应支付信息，视频专用
//     */
//    public function getPays()
//    {
//        $payModel = PayModel::where('genre',1)
//            ->where('order_id',$this->id)
//            ->orderBy('id','asc')
//            ->get();
//        return $payModel ? $payModel : [];
//    }
//
//    /**
//     * 获取对应支付金额
//     */
//    public function getMoney($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? $pay->money() : 0;
//        } else {
//            return $this->getPay() ? $this->getPay()->money() : 0;
//        }
//    }
//
//    /**
//     * 得到付款时间1
//     */
//    public function getCreateTime($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? date('Y年m月d日 H:i',$pay->created_at) : '';
//        } else {
//            return $this->getPay() ? date('Y年m月d日 H:i',$this->getPay()->created_at) : '';
//        }
//    }
//
//    /**
//     * 得到付款来源表类型
//     */
//    public function getPayGenreName($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? $pay->getGenreName() : '';
//        } else {
//            return $this->getPay() ? $this->getPay()->getGenreName() : '';
//        }
//    }
//
//    /**
//     * 得到付款的延时赔付
//     */
//    public function getPayFine($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? $pay->getFineName() : '';
//        } else {
//            return $this->getPay() ? $this->getPay()->getFineName() : '';
//        }
//    }
//
//    /**
//     * 得到付款的支付宝确认状态码
//     */
//    public function getPayStatus($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? $pay->ispay : 0;
//        } else {
//            return $this->getPay() ? $this->getPay()->ispay : 0;
//        }
//    }
//
//    /**
//     * 得到付款的支付宝确认状态值
//     */
//    public function getPayName($i=null)
//    {
//        if (in_array($this->genre,[5,6])) {
//            $pay = $this->getPays();
//            return (isset($pay[$i])&&$pay[$i]) ? $pay->getPayName() : '';
//        } else {
//            return $this->getPay() ? $this->getPay()->getPayName() : '';
//        }
//    }
}