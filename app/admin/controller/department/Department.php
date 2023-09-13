<?php

namespace app\admin\controller\department;

use app\common\controller\Backend;
use ba\Tree;

/**
 * 部门
 *
 */
class Department extends Backend
{
    /**
     * Department模型对象
     * @var object
     * @phpstan-param \app\admin\model\department\Department
     */
    protected object $model;

    protected ?Tree $tree = null;

    protected string $keyword;

    protected string|array $quickSearchField = 'name';

    protected string|array $defaultSortField = 'weigh,desc';

    protected string|array $preExcludeFields = ['createtime', 'updatetime'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model   = new \app\admin\model\department\Department;
        $this->tree    = Tree::instance();
        $this->keyword = $this->request->request('quickSearch', '');
    }

    public function index(): void
    {
        if ($this->request->param('select')) {
            $this->select();
        }

        $this->success('', [
            'list'   => $this->getDepartment(),
            'remark' => get_route_remark(),
        ]);
    }

    public function edit($id = null): void
    {
        $row = $this->model->find($id);
        if (!$row) {
            $this->error(__('Record not found'));
        }

        if ($this->request->isPost()) {
            parent::edit($id);
        }

        $this->success('', [
            'row' => $row
        ]);
    }


    public function select(): void
    {
        $isTree = $this->request->param('isTree');
        $data   = $this->getDepartment([['status', '=', '1']]);

        if ($isTree && !$this->keyword) {
            $data = $this->tree->assembleTree($this->tree->getTreeArray($data, 'name'));
        }
        $this->success('', [
            'options' => $data
        ]);
    }

    protected function getDepartment($where = []): array
    {
        if ($this->keyword) {
            $keyword = explode(' ', $this->keyword);
            foreach ($keyword as $item) {
                $where[] = [$this->quickSearchField, 'like', '%' . $item . '%'];
            }
        }
        $data = $this->model->where($where)->order('weigh desc,id asc')->select()->toArray();
        return $this->tree->assembleChild($data);
    }


}