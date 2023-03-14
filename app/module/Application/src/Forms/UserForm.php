<?php
declare(strict_types=1);

namespace Application\Forms;

use Application\Models\BirthPlace\BirthPlaceTable;
use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\InArray;

class UserForm extends Form implements InputFilterProviderInterface
{
    protected $birthPlaceTable;

    public function __construct(BirthPlaceTable $birthPlaceTable, $name = null, $options = [])    {
        $this->birthPlaceTable = $birthPlaceTable;

        parent::__construct($name, $options);

        // Add elements to the form
        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'id',
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'full_name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'required' => true,
            ],
        ]);

        $this->add([
            'type' => Element\DateTime::class,
            'name' => 'birth_date',
            'options' => [
                'label' => 'Birth Date',
                'format' => 'd.m.Y', // set the date format
            ],
            'attributes' => [
                'required' => true,
                'autocomplete' => 'off',
            ],
        ]);

        $this->add([
            'name' => 'birth_place',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Birth Place',
                'value_options' => $this->getBirthPlaceValueOptions(),
            ],
        ]);

        // Add submit button
        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    /**
     * Define input filters for validation.
     */
    /**
     * Define input filters for validation.
     */
    public function getInputFilterSpecification(): array
    {
        return [
            [
                'name' => 'id',
                'required' => false,
            ],
            [
                'name' => 'full_name',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 3,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            [
                'name' => 'birth_date',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Date',
                        'options' => [
                            'format' => 'd.m.Y',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'birth_place',
                'required' => true,
                'validators' => [
                    [
                        'name' => InArray::class,
                        'options' => [
                            'haystack' => array_keys($this->getBirthPlaceValueOptions()),
                        ],
                    ],
                ],
            ],
        ];
    }


    protected function getBirthPlaceValueOptions(): array
    {
        $options = [];
        foreach ($this->birthPlaceTable->fetchAll() as $place) {
            $options[$place['id']] = $place['name_ru'] . ' / ' . $place['name_en'];
        }
        return $options;
    }
}
