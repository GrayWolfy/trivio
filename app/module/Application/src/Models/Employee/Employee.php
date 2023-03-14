<?php
declare(strict_types=1);

namespace Application\Models\Employee;

class Employee extends \ArrayObject
{
    protected $id;
    protected $full_name;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->full_name;
    }

    public function setName($name)
    {
        $this->full_name = $name;
    }

    public function exchangeArray(array|object $array): array
    {
        $this->id = $array['id'] ?? null;
        $this->full_name = $array['full_name'] ?? null;

        return $this->getArrayCopy();
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
        ];
    }

}