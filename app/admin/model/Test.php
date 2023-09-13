<?php

namespace app\admin\model;

use think\Model;

/**
 * Test
 */
class Test extends Model
{
    // 表名
    protected $name = 'test';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'city_text',
    ];


    public function getCityAttr($value): array
    {
        if ($value === '' || $value === null) return [];
        if (!is_array($value)) {
            return explode(',', $value);
        }
        return $value;
    }

    public function setCityAttr($value): string
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

    public function getCityTextAttr($value, $row): string
    {
        if ($row['city'] === '' || $row['city'] === null) return '';
        $cityNames = \think\facade\Db::name('area')->whereIn('id', $row['city'])->column('name');
        return $cityNames ? implode(',', $cityNames) : '';
    }

    public function admin(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(\app\admin\model\Admin::class, 'admin_id', 'id');
    }
}