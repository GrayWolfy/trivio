<?php
declare(strict_types=1);

namespace Application\Validators;

use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\Date;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class UserInputFilter implements InputFilterAwareInterface
{
    protected InputFilterInterface $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter): void
    {
        throw new \Exception('This class does not allow injection of an alternate input filter');
    }

    public function getInputFilter(): InputFilterInterface
    {
        if (! isset($this->inputFilter)) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'id',
                'required' => true,
                'filters' => [
                    ['name' => 'ToInt'],
                ],
            ]);

            $inputFilter->add([
                'name' => 'full_name',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ]);
//            здесь ловится ошибка в классе ламинаса, там некорректное условие
//            если его пофиксить то все будет работать ошибка ловится в Date.php DateStep.php, но вендор не коммитится

//            $inputFilter->add([
//                'name' => 'birth_date',
//                'required' => true,
//                'validators' => [
//                    [
//                        'name' => Date::class,
//                        'options' => [
//                            'format' => 'd.m.Y',
//                        ],
//                    ],
//                ],
//            ]);

            $inputFilter->add([
                'name' => 'birth_place',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                    [
                        'name' => NotEmpty::class,
                        'options' => [
                            'type' => NotEmpty::ALL,
                        ],
                    ],
                ],
            ]);

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}