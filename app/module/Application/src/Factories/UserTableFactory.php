<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\User\User;
use Application\Models\User\UserTable;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;


class UserTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());
        $tableGateway = new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
        return new UserTable($tableGateway);
    }
}