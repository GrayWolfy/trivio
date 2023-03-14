<?php
declare(strict_types=1);

namespace Application\Models\Department;

use Application\Models\Employee\Employee;
use Application\Validators\DepartmentInputFilter;

class Department extends \ArrayObject
{
    protected $id;
    protected $name_ru;
    protected $name_en;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
        parent::__construct($data);
    }

    public function getId()
    {
        return $this->id;
    }

    public function addEmployee(Employee $employee)
    {
        $this->employees[] = $employee;
    }

    public function removeEmployee(Employee $employee)
    {
        $key = array_search($employee, $this->employees, true);
        if ($key !== false) {
            unset($this->employees[$key]);
        }
    }

    public function hydrate(array $data)
    {
        $this->id = $data['id'] ?? $this->id;
        $this->name_ru = $data['name_ru'] ?? $this->name_ru;
        $this->name_en = $data['name_en'] ?? $this->name_en;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name_ru' => $this->getNameRu(),
            'name_en' => $this->getNameEn(),
        ];
    }

    public function validate(array $data)
    {
        $inputFilter = new DepartmentInputFilter();
        $inputFilter->setData($data);

        if (!$inputFilter->isValid()) {
            $errors = $inputFilter->getMessages();
            throw new \Exception(json_encode($errors));
        }

        $this->hydrate($data);
    }

    /**
     * @return DepartmentInputFilter
     */
    public function getInputFilter(): DepartmentInputFilter
    {
        return new DepartmentInputFilter();
    }

    public function fill(array $array)
    {
        $this->id = $array['id'] ?? null;
        $this->name_ru = $array['name_ru'] ?? null;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNameRu()
    {
        return $this->name_ru;
    }

    /**
     * @param mixed $name_ru
     */
    public function setNameRu($name_ru): void
    {
        $this->name_ru = $name_ru;
    }

    /**
     * @return mixed
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * @param mixed $name_en
     */
    public function setNameEn($name_en): void
    {
        $this->name_en = $name_en;
    }

    public function exchangeArray(array|object $array): array
    {
        $this->id = isset($array['id']) ? $array['id'] : null;
        $this->name_ru = isset($array['name_ru']) ? $array['name_ru'] : null;
        $this->name_en = isset($array['name_en']) ? $array['name_en'] : null;

        return [
            'id' => $this->id,
            'name_ru' => $this->name_ru,
            'name_en' => $this->name_en,
        ];
    }
}
