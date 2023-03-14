<?php

namespace Application\Models\EmployeeDepartment;

use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class EmployeeDepartmentTable
{
    public function __construct(
        protected TableGatewayInterface $tableGateway,
        protected DepartmentTable $departmentTable,
        protected EmployeeTable $employeeTable,
    )
    {}

    public function getAllEmployeeDepartments()
    {
        $resultSet = $this->tableGateway->select();
        $entries = [];
        foreach ($resultSet as $row) {
            $entries[] = $row;
        }

        return $entries;
    }

    public function getEmployeeDepartmentById($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find employee_department with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveEmployeeDepartment(EmployeeDepartment $employeeDepartment)
    {
        $data = [
            'employee_id' => $employeeDepartment->employee_id,
            'department_id' => $employeeDepartment->department_id,
        ];

        // check if an EmployeeDepartment with the same employee_id and department_id already exists
        $existingEntry = $this->tableGateway->select([
            'employee_id' => $employeeDepartment->employee_id,
            'department_id' => $employeeDepartment->department_id,
        ])->current();

        if ($existingEntry) {
            // EmployeeDepartment already exists, return it
            return $existingEntry;
        }

        $id = (int)$employeeDepartment->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getEmployeeDepartmentById($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new RuntimeException(sprintf(
                    'Cannot update employee_department with identifier %d; does not exist',
                    $id
                ));
            }
        }

        return $this->getEmployeeDepartmentById($id);
    }


    public function deleteEmployeeDepartment($id)
    {
        $this->tableGateway->delete(['id' => (int)$id]);
    }
}
