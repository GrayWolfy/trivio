<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Application\Models\EmployeeDepartment\EmployeeDepartment;
use Application\Models\EmployeeDepartment\EmployeeDepartmentTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

class EmployeeDepartmentTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new EmployeeDepartment(
            $container->get(EmployeeTable::class),
            $container->get(DepartmentTable::class),
        ));
        $tableGateway = new TableGateway('employee_department', $dbAdapter, null, $resultSetPrototype);
        return new EmployeeDepartmentTable(
            $tableGateway,
            $container->get(DepartmentTable::class),
            $container->get(EmployeeTable::class),
        );
    }
}