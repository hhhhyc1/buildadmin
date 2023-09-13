<?php

namespace app\admin\controller\examples\table\cell;

use app\common\controller\Backend;

/**
 * 预设渲染方案
 */
class Pre extends Backend
{
    /**
     * Pre模型对象
     * @var object
     * @phpstan-var \app\admin\model\examples\table\cell\Pre
     */
    protected object $model;

    protected string|array $defaultSortField = 'weigh,desc';

    protected array|string $preExcludeFields = ['id', 'create_time'];

    protected string|array $quickSearchField = ['id'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\examples\table\cell\Pre;
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}