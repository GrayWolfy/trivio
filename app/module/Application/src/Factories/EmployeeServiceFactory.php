<?php
declare(strict_types=1);

namespace Application\Factories;

use Application\Models\Employee\EmployeeTable;
use Application\Services\EmployeeService;
use Interop\Container\ContainerInterface;

class EmployeeServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new EmployeeService($container->get(EmployeeTable::class));
    }

}