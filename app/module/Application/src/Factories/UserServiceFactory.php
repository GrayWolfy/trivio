<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\BirthPlace\BirthPlaceTable;
use Application\Models\User\UserTable;
use Application\Services\UserService;
use Interop\Container\ContainerInterface;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UserService(
            $container->get(UserTable::class),
            $container->get(BirthPlaceTable::class),
        );
    }
}