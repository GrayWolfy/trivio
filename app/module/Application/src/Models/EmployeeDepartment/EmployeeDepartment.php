<?php
namespace Application\Models\EmployeeDepartment;

use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Application\Validators\EmployeeDepartmentInputFilter;

class EmployeeDepartment extends \ArrayObject
{
    private $id;
    public $employee_id;
    public $department_id;

    public function __construct(protected EmployeeTable $employeeTable, protected DepartmentTable $departmentTable, $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * @return mixed
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    public function exchangeArray($array): array
    {
        $this->id            = !empty($array['id']) ? $array['id'] : null;
        $this->employee_id   = !empty($array['employee_id']) ? $array['employee_id'] : null;
        $this->department_id = !empty($array['department_id']) ? $array['department_id'] : null;

        return $this->getArrayCopy();
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'department_id' => $this->department_id,
        ];
    }
    public function getInputFilter()
    {
        return new EmployeeDepartmentInputFilter();
    }

    public function getEmployee()
    {
        return $this->employeeTable->getEmployee($this->employee_id);
    }

    public function getDepartment()
    {
        return $this->departmentTable->getDepartment($this->department_id);
    }
}
