<?php

namespace app\admin\model;

use think\Model;

/**
 * Menudesign
 */
class Menudesign extends Model
{
    // 表名
    protected $name = 'menudesign';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    protected static function onBeforeInsert($model)
    {
        $pk         = $model->getPk();
        $model->$pk = \app\common\library\SnowFlake::generateParticle();
    }

    public function getIdAttr($value): string
    {
        return (string)$value;
    }
}