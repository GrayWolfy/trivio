<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Application\Models\EmployeeDepartment\EmployeeDepartmentTable;
use Application\Services\EmployeeDepartmentService;
use Interop\Container\ContainerInterface;


class EmployeeDepartmentServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new EmployeeDepartmentService(
            $container->get(EmployeeDepartmentTable::class),
            $container->get(DepartmentTable::class),
            $container->get(EmployeeTable::class),
        );
    }
}