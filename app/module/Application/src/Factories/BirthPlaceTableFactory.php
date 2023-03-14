<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\BirthPlace\BirthPlace;
use Application\Models\BirthPlace\BirthPlaceTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
class BirthPlaceTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('DbAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new BirthPlace());
        $tableGateway = new TableGateway('birth_place', $dbAdapter, null, $resultSetPrototype);
        return new BirthPlaceTable($tableGateway);
    }
}