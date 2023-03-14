<?php
declare(strict_types=1);

namespace Application\Models\Department;

use Laminas\Db\TableGateway\TableGatewayInterface;

class DepartmentTable
{
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getDepartment($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find department with id $id");
        }
        return $row;
    }

    public function saveDepartment(Department $department)
    {
        $data = [
            'name_ru' => $department->getNameRu()
        ];
        $id = (int)$department->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            $department->setId($this->tableGateway->getLastInsertValue());
        } else {
            if (!$this->getDepartment($id)) {
                throw new \Exception("Department with id $id does not exist");
            }

            $this->tableGateway->update($data, ['id' => $id]);
        }
    }

    public function deleteDepartment($id)
    {
        $this->tableGateway->delete(['id' => (int)$id]);
    }
}