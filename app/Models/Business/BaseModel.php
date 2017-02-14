<?php
namespace App\Models\Business;

use App\Models\BaseModel as Model;

class BaseModel extends Model
{
    /**
     * 业务基础 model
     */

    protected $linkTypes = [
        1=>'flash代码','html代码','通用代码','其他视频网址',
    ];

    public function getLinkTypeName()
    {
        return array_key_exists($this->linkType,$this->linkTypes) ? $this->linkTypes[$this->linkType] : '';
    }
}