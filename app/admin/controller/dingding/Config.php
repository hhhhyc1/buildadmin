<?php

namespace app\admin\controller\dingding;

use Throwable;
use think\facade\Db;
use app\common\controller\Backend;

/**
 * 钉钉配置管理
 *
 */
class Config extends Backend
{
    /**
     * Config模型对象
     * @var object
     * @phpstan-var \app\admin\model\dingding\Config
     */
    protected object $model;

    protected string|array $quickSearchField = ['id', 'name'];

    protected string|array $defaultSortField = 'id,desc';

    protected string|array $preExcludeFields = ['createtime', 'updatetime'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\dingding\Config;
    }

    public function add(): void
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!$data) {
                $this->error(__('Parameter %s can not be empty', ['']));
            }

            $data   = $this->excludeFields($data);
            $result = false;
            Db::startTrans();
            try {
                if (isset($data['default_switch']) && $data['default_switch'] == '1') {
                    $this->model->where('default_switch', '1')->save(['default_switch' => '0']);
                }

                if (isset($data['security']) && ($data['security'] == 'none' || $data['security'] == 'ip')) {
                    $data['security_value'] = null;
                }

                $result = $this->model->save($data);
                Db::commit();
            } catch (Throwable $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($result !== false) {
                $this->success(__('Added successfully'));
            } else {
                $this->error(__('No rows were added'));
            }
        }

        $this->error(__('Parameter error'));
    }

    public function edit($id = null): void
    {
        $row = $this->model->find($id);
        if (!$row) {
            $this->error(__('Record not found'));
        }

        $dataLimitAdminIds = $this->getDataLimitAdminIds();
        if ($dataLimitAdminIds && !in_array($row[$this->dataLimitField], $dataLimitAdminIds)) {
            $this->error(__('You have no permission'));
        }

        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!$data) {
                $this->error(__('Parameter %s can not be empty', ['']));
            }

            if (isset($data['default_switch']) && $data['default_switch'] != $row['default_switch'] && $data['default_switch'] == '1') {
                $this->model->where('default_switch', '1')->save(['default_switch' => '0']);
            }

            if (isset($data['security']) && ($data['security'] == 'none' || $data['security'] == 'ip')) {
                $data['security_value'] = null;
            }

            $data   = $this->excludeFields($data);
            $result = false;
            Db::startTrans();
            try {
                $result = $row->save($data);
                Db::commit();
            } catch (Throwable $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($result !== false) {
                $this->success(__('Update successful'));
            } else {
                $this->error(__('No rows updated'));
            }
        }

        $this->success('', [
            'row' => $row
        ]);
    }
}
