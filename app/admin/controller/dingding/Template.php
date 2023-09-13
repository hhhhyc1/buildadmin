<?php

namespace app\admin\controller\dingding;

use app\common\controller\Backend;
use modules\dingding\DingDing as dingdingLib;

/**
 * 钉钉模板管理
 *
 */
class Template extends Backend
{
    /**
     * Template模型对象
     * @var object
     * @phpstan-var \app\admin\model\dingding\Template
     */
    protected object $model;

    protected string|array $quickSearchField = ['id'];

    protected string|array $defaultSortField = 'id,desc';

    protected string|array $preExcludeFields = ['createtime', 'updatetime'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\dingding\Template;
    }

    public function add(): void
    {
        $this->request->filter('trim,htmlspecialchars');
        parent::add();
    }

    public function edit(): void
    {
        $this->request->filter('trim,htmlspecialchars');
        parent::edit();
    }

    /**
     * 查看
     */
    public function index(): void
    {
        // 设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);

        // 如果是select则转发到select方法,若select未重写,其实还是继续执行index
        if ($this->request->param('select')) {
            $this->select();
        }

        list($where, $alias, $limit, $order) = $this->queryBuilder();
        $res = $this->model
            ->withJoin($this->withJoinTable, $this->withJoinType)
            ->alias($alias)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        $this->success('', [
            'list'   => $res->items(),
            'total'  => $res->total(),
            'remark' => get_route_remark(),
        ]);
    }

    public function testSend($flag)
    {
        $msg = dingdingLib::send($flag);

        if ($msg === 'success') {
            $this->success($msg);
        }

        $this->error($msg);
    }
}
