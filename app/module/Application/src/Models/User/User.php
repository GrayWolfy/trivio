<?php
declare(strict_types=1);

namespace Application\Models\User;

use Application\Validators\UserInputFilter;
use DateTime;
use Laminas\InputFilter\InputFilterInterface;

class User extends \ArrayObject
{
    public function __construct(
        array $data = [],
        protected $id = null,
        protected $full_name = null,
        protected $birth_date = null,
        protected $birth_place= null,
    )
    {
        $this->hydrate($data);
        parent::__construct($data);

    }

    public function hydrate(array $data)
    {
        $this->id = $data['id'] ?? $this->id;
        $this->full_name = $data['full_name'] ?? $this->full_name;
        $this->birth_date = $data['birth_date'] ?? $this->birth_date;
        $this->birth_place = $data['birth_place'] ?? $this->birth_place;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->full_name;
    }

    public function setName($name): void
    {
        $this->full_name = $name;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate(DateTime $birthDate): void
    {
        $this->birth_date = $birthDate;
    }

    public function getBirthPlace()
    {
        return $this->birth_place;
    }

    public function setBirthPlace($birthPlace): void
    {
        $this->birth_place = $birthPlace;
    }

    public function getInputFilter(): InputFilterInterface
    {
       return (new UserInputFilter())->getInputFilter();
    }

    public function exchangeArray($array): array
    {
        $this->id = $array['id'] ?? null;
        $this->full_name = $array['full_name'] ?? null;

        if (isset($array['birth_date'])) {
            $this->birth_date = new DateTime($array['birth_date']);
        } else {
            $this->birth_date = null;
        }

        $this->birth_place = $array['birth_place'] ?? null;

        return $this->getArrayCopy();
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'birth_date' => $this->birth_date,
            'birth_place' => $this->birth_place,
        ];
    }
}