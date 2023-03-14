<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Department\DepartmentTable;
use Application\Services\DepartmentService;
use Interop\Container\ContainerInterface;

class DepartmentServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new DepartmentService($container->get(DepartmentTable::class));
    }
}