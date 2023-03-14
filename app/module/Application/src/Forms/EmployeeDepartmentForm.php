<?php
namespace Application\Forms;

use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Laminas\Form\Form;
use Laminas\Form\Element;

class EmployeeDepartmentForm extends Form
{
    protected $employeeTable;
    protected $departmentTable;

    public function __construct(EmployeeTable $employeeTable, DepartmentTable $departmentTable)
    {
        $this->employeeTable = $employeeTable;
        $this->departmentTable = $departmentTable;

        parent::__construct('employee_department');

        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'name' => 'employee_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Employee',
                'empty_option' => 'Please select an employee',
                'value_options' => $this->getEmployeesOptions(),
            ],
        ]);

        $this->add([
            'name' => 'department_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Department',
                'empty_option' => 'Please select a department',
                'value_options' => $this->getDepartmentsOptions(),
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Submit',
                'id' => 'submitbutton',
            ],
        ]);
    }

    protected function getEmployeesOptions(): array
    {
        $options = [];
        foreach ($this->employeeTable->fetchAll() as $employee) {
            $options[$employee->getId()] = $employee->getName();
        }
        return $options;
    }

    protected function getDepartmentsOptions(): array
    {
        $options = [];
        foreach ($this->departmentTable->fetchAll() as $department) {
            $options[$department->getId()] = $department->getNameRu() . ' / ' . $department->getNameEn();
        }
        return $options;
    }
}
