<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Employee\Employee;
use Application\Models\Employee\EmployeeTable;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;

class EmployeeTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Employee());
        $tableGateway = new TableGateway('employee', $dbAdapter, null, $resultSetPrototype);
        return new EmployeeTable($tableGateway);
    }
}