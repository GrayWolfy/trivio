<?php
declare(strict_types=1);

namespace Application\Services;

use Application\Forms\EmployeeDepartmentForm;
use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Application\Models\EmployeeDepartment\EmployeeDepartment;
use Application\Models\EmployeeDepartment\EmployeeDepartmentTable;

class EmployeeDepartmentService
{
    public function __construct(
        private EmployeeDepartmentTable $table,
        private DepartmentTable         $departmentTable,
        private EmployeeTable           $employeeTable,
    )
    {
    }

    public function getAllEmployeeDepartments()
    {
        $employeeDepartments = $this->table->getAllEmployeeDepartments();

        $entries = [];
        foreach ($employeeDepartments as $employeeDepartment) {
            $entry = [
                'id' => $employeeDepartment->getId(),
                'employee' => $employeeDepartment->getEmployee()->getName(),
                'department' => $employeeDepartment->getDepartment()->getNameRu(),
            ];
            $entries[] = $entry;
        }

        return $entries;
    }

    public function addEmployeeDepartment($postData, bool $isPost)
    {
        $form = new EmployeeDepartmentForm($this->employeeTable, $this->departmentTable);
        $form->get('submit')->setValue('Add');
        $employeeDepartment = new EmployeeDepartment($this->employeeTable, $this->departmentTable);

        if (!$isPost || !$this->isValidForm($form, $postData, $employeeDepartment)) {
            return ['form' => $form];
        }


        $employeeDepartment->exchangeArray($form->getData());
        $this->table->saveEmployeeDepartment($employeeDepartment);

        return [];
    }

    public function editEmployeeDepartment($id, $postData, $isPost)
    {
        $employeeDepartment = $this->table->getEmployeeDepartmentById($id);

        $form = new EmployeeDepartmentForm($this->employeeTable, $this->departmentTable);
        $form->bind($employeeDepartment);
        $form->get('submit')->setAttribute('value', 'Edit');

        if (!$isPost) {
            return ['id' => $id, 'form' => $form, 'employeeDepartment' => $employeeDepartment];
        }

        if (!$this->isValidForm($form, $postData, $employeeDepartment)) {
            return ['id' => $id, 'form' => $form, 'employeeDepartment' => $employeeDepartment];
        }

        $this->table->saveEmployeeDepartment($employeeDepartment);

        return true;
    }

    public function deleteEmployeeDepartment($id)
    {
        $employeeDepartment = $this->table->getEmployeeDepartmentById($id);
        $this->table->deleteEmployeeDepartment($employeeDepartment->getId());
        return true;
    }

    private function isValidForm($form, $postData, EmployeeDepartment $employeeDepartment)
    {
        $form->setInputFilter($employeeDepartment->getInputFilter());
        $form->setData($postData);
        return $form->isValid();
    }
}
