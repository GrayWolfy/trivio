<?php
declare(strict_types=1);

namespace Application\Models\Employee;

use Laminas\Db\TableGateway\TableGatewayInterface;

class EmployeeTable
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

    public function getEmployee($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find employee with id $id");
        }
        return $row;
    }

    public function saveEmployee(Employee $employee)
    {
        $data = [
            'full_name' => $employee->getName()
        ];

        $id = (int) $employee->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            $employee->setId((int)$this->tableGateway->getLastInsertValue());
            return;
        }

        if (! $this->getEmployee($id)) {
            throw new \Exception("Employee with id $id does not exist");
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteEmployee($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}