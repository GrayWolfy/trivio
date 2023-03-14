<?php
declare(strict_types=1);

namespace Application\Services;

use Application\Forms\DepartmentForm;
use Application\Models\Department\Department;
use Application\Models\Department\DepartmentTable;
use Laminas\Db\ResultSet\ResultSetInterface;

class DepartmentService
{
    public function __construct(private DepartmentTable $departmentTable)
    {
    }

    public function getAllDepartments(): ResultSetInterface
    {
        return $this->departmentTable->fetchAll();
    }

    public function createDepartment(array $departmentData, DepartmentForm $form): bool
    {
        $department = new Department();
        $department->fill($departmentData);

        $form->setInputFilter($department->getInputFilter());
        $form->setData($departmentData);

        if ($form->isValid()) {
            $this->departmentTable->saveDepartment($department);
            return true;
        }

        return false;
    }

    public function getDepartmentById(int $id): ?Department
    {
        try {
            return $this->departmentTable->getDepartment($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateDepartment(array $department, int $id): bool
    {
        try {
            $existingDepartment = $this->departmentTable->getDepartment($id);
            $existingDepartment->fill($department);
            $this->departmentTable->saveDepartment($existingDepartment);

            return true;
        } catch (\Exception) {
            return false;
        }
    }

    public function deleteDepartmentById(int $id): bool
    {
        try {
            $this->departmentTable->deleteDepartment($id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
