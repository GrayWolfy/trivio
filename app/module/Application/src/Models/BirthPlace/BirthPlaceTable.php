<?php
declare(strict_types=1);

namespace Application\Models\BirthPlace;

use Laminas\Db\TableGateway\TableGatewayInterface;

class BirthPlaceTable
{
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet->toArray();
    }
}
