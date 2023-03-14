<?php
declare(strict_types=1);

namespace Application\Models\User;

use Laminas\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find user with id $id");
        }
        return $row;
    }

    public function saveUser(User $user)
    {
        $data = [
            'full_name' => $user->getName(),
            'birth_date' => $user->getBirthDate()->format('Y-m-d'),
            'birth_place_id' => $user->getBirthPlace()
        ];

        $id = (int) $user->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            $user->setId($this->tableGateway->getLastInsertValue());
            return;
        }

        if (! $this->getUser($id)) {
            throw new \Exception("User with id $id does not exist");
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}