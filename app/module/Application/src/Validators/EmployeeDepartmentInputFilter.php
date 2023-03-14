<?php
namespace Application\Validators;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;

class EmployeeDepartmentInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'employee_id',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Validator\NotEmpty::IS_EMPTY => 'Please select an employee',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'department_id',
            'required' => true,
            'filters' => [
                ['name' => 'Int'],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Validator\NotEmpty::IS_EMPTY => 'Please select a department',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
