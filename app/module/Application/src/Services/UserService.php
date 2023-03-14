<?php

declare(strict_types=1);

namespace Application\Services;

use Application\Forms\UserForm;
use Application\Models\BirthPlace\BirthPlaceTable;
use Application\Models\User\User;
use Application\Models\User\UserTable;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Stdlib\ParametersInterface;

class UserService
{
    private $userTable;
    private $birthPlaceTable;

    public function __construct(UserTable $userTable, BirthPlaceTable $birthPlaceTable)
    {
        $this->userTable = $userTable;
        $this->birthPlaceTable = $birthPlaceTable;
    }

    public function getAllUsers(): ResultSetInterface
    {
        return $this->userTable->fetchAll();
    }

    public function createUser(bool $isPost, $post): array|true
    {
        $form = new UserForm($this->birthPlaceTable);
        $form->get('submit')->setValue('Add');

        if (!$isPost) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($post);

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->userTable->saveUser($user);

        return true;
    }

    public function updateUser(User $user, bool $isPost, ParametersInterface $post): array|true
    {
        $form = new UserForm($this->birthPlaceTable);
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        if (!$isPost) {
            return ['id' => $user->getId(), 'form' => $form];
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($post);

        if (! $form->isValid()) {
            return ['id' => $user->getId(), 'form' => $form];
        }

        $this->userTable->saveUser($user);

        return true;
    }

    public function deleteUserById(int $id): void
    {
        $this->userTable->getUser($id);
        $this->userTable->deleteUser($id);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userTable->getUser($id);
    }
}
