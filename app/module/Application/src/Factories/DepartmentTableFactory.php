<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Department\Department;
use Application\Models\Department\DepartmentTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

class DepartmentTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Department());
        $tableGateway = new TableGateway('department', $dbAdapter, null, $resultSetPrototype);
        return new DepartmentTable($tableGateway);
    }
}
