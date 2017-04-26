<?php
namespace App\Models\Search;

class SearchsModel extends BaseModel
{
    /**
     * 业务模糊检索
     */

    protected $table = 'searchs';
    protected $fillable = [
        'id','genre','fromid','words','created_at','updated_at',
    ];

    /**
     * 业务检索：
     * 视频动画（产品），故事（脚本），设备（租赁），人员（演员等），配音，设计，投放（视频），花絮
     */
    protected $genres = [
        1=>'视频','故事','设备','人员','配音','设计','投放','花絮',
    ];
}