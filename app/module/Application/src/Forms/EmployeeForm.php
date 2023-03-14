<?php

declare(strict_types=1);

namespace Application\Forms;

use Application\Models\Employee\Employee;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Element;

class EmployeeForm extends Form implements InputFilterProviderInterface
{
    public function __construct(string $name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'full_name',
            'type' => 'text',
            'options' => [
                'label' => 'Full Name',
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

    public function exchangeArray(Employee $employee)
    {
        $this->setData([
            'id' => $employee->getId(),
            'name' => $employee->getName(),
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'full_name' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
        ];
    }
}
