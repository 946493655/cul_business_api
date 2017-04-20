<?php
namespace App\Models\Business;

class OrderModel extends BaseModel
{
    /**
     * 用户意见model
     */
    protected $table = 'bs_orders';
    protected $fillable = [
        'id','name','serial','genre','fromid','uid','uname','seller','sellerName',
        'money','weal','status','reason','ucLevel','userComment','scLevel','sellerComment',
        'isshow','del','created_at','updated_at',
    ];

    /**
     * 更新时间updated_at：状态更新的时间集合
     * statusTime2、statusTime3、statusTime4、statusTime5、statusTime6、statusTime7、statusTime8、statusTime9、
     * statusTime10、statusTime11、statusTime12、statusTime13、statusTime14、statusTime15、statusTime16、
     */

    /**
     * 订单来源类型genre：
     * 1故事供应，2故事需求，3动画供应，4动画需求，5视频供应，6视频需求，
     * 7人员供应，8人员需求，9租赁供应，10租赁需求，11设计供应，12设计需求，
     */
    protected $genres = [
        1=>'故事供应','故事需求','动画供应','动画需求','视频供应','视频需求',
        '人员供应','人员需求','租赁供应','租赁需求','设计供应','设计需求',
    ];

    /**
     * 订单状态：
     * 1新订单，2协商中，3放弃订单，4确认订单，5提交资料/首款，6确认提交（资料意见/首款备份至平台），
     * 7开始办理（期限内），8完成半成品，9校验半成品（成功继续|失败退回），10验货成功，
     * 11支付尾款（期限内至平台）,12交付成品，13确定成品，14商家收款（扣除平台佣金-交易成功），15客户评价，16商家评价
     */
    protected $statuss = [
        1=>'新订单','协商中','放弃订单','确认订单','提交资料与首款','确认提交',
        '开始办理','完成半成品','校验半成品','验货成功',
        '支付尾款','交付成品','确定成品','商家收款','客户评价','商家评价',
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