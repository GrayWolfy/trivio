<?php
declare(strict_types=1);

namespace Application\Forms;

use Application\Models\Department\Department;
use Laminas\Form\Form;
use Laminas\Form\Element;

class DepartmentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('department');
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'name' => 'name_ru',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Name_Ru',
            ],
        ]);

        $this->add([
            'name' => 'name_en',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Name_En',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Save',
                'id' => 'submitbutton',
            ],
        ]);
    }

    public function bindEntity(Department $entity)
    {
        $this->bind($entity);
        $this->getInputFilter()->setData($entity->getArrayCopy());

        // Set the values of the form fields to the corresponding attribute values of the model
        $this->get('id')->setValue($entity->getId());
        $this->get('name_ru')->setValue($entity->getNameRu());
        $this->get('name_en')->setValue($entity->getNameEn());
    }
}
