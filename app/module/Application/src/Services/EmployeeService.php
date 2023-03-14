<?php

declare(strict_types=1);

namespace Application\Services;

use Application\Models\Employee\Employee;
use Application\Models\Employee\EmployeeTable;
use Laminas\Db\ResultSet\ResultSetInterface;

class EmployeeService
{
    public function __construct(private EmployeeTable $employeeTable)
    {}

    public function getAllEmployees(): ResultSetInterface
    {
        return $this->employeeTable->fetchAll();
    }

    public function createEmployee(array $data): void
    {
        $employee = new Employee();
        $employee->exchangeArray($data);

        $this->employeeTable->saveEmployee($employee);
    }

    public function getEmployeeById(int $id): ?Employee
    {
        try {
            return $this->employeeTable->getEmployee($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateEmployee(Employee $employee, array $data): void
    {
        $employee->exchangeArray($data);

        $this->employeeTable->saveEmployee($employee);
    }

    public function deleteEmployeeById(int $id): void
    {
        try {
            $this->employeeTable->deleteEmployee($id);
        } catch (\Exception $e) {
            // Handle the exception, e.g. log an error
        }
    }
}
