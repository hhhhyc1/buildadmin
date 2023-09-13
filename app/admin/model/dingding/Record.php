<?php

namespace app\admin\model\dingding;

use think\Model;
use think\model\relation\BelongsTo;

/**
 * Record
 */
class Record extends Model
{
    // 表名
    protected $name = 'dingding_record';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    public function getContentAttr($value, $row): string
    {
        return !$value ? '' : htmlspecialchars_decode($value);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }

    public function config(): BelongsTo
    {
        return $this->belongsTo(Config::class, 'config_id', 'id');
    }
}
