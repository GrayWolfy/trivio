<?php
declare(strict_types=1);

namespace Application\Models\BirthPlace;


class BirthPlace extends \ArrayObject
{
    protected $id;
    protected $nameRu;
    protected $nameEn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNameRu(): ?string
    {
        return $this->nameRu;
    }

    public function setNameRu(string $nameRu): void
    {
        $this->nameRu = $nameRu;
    }

    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }

    public function setNameEn(string $nameEn): void
    {
        $this->nameEn = $nameEn;
    }

    public function exchangeArray($array): array
    {
        $this->id = $array['id'] ?? null;
        $this->nameRu = $array['name_ru'] ?? null;
        $this->nameEn = $array['name_en'] ?? null;

        return $this->getArrayCopy();
    }

    public function getArrayCopy(): array
    {
        return [
            'id' => $this->id,
            'name_ru' => $this->nameRu,
            'name_en' => $this->nameEn,
        ];
    }
}
