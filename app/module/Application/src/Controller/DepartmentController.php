<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Forms\DepartmentForm;
use Application\Services\DepartmentService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class DepartmentController extends AbstractActionController
{

    public function __construct(readonly DepartmentService $service)
    {}

    public function indexAction()
    {
        return new ViewModel(['departments' => $this->service->getAllDepartments()]);
    }

    public function addAction()
    {
        $form = new DepartmentForm();

        if ($this->getRequest()->isPost()) {
            $department = $this->service->createDepartment($this->params()->fromPost(), $form);

            if ($department) {
                return $this->redirect()->toRoute('department');
            }
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $department = $this->service->getDepartmentById($id);

        if (!$department) {
            return $this->redirect()->toRoute('department', ['action' => 'index']);
        }

        $form = new DepartmentForm();
        $form->bindEntity($department);

        if ($this->getRequest()->isPost() && $form->isValid()) {
            $this->service->updateDepartment($this->params()->fromPost(), $id);
            return $this->redirect()->toRoute('department');
        }

        return new ViewModel([
            'id' => $id,
            'form' => $form,
        ]);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id === 0) {
            return $this->redirect()->toRoute('department');
        }

        $department = $this->service->getDepartmentById($id);

        if (empty($department)) {
            return $this->redirect()->toRoute('department');
        }

        $this->service->deleteDepartmentById($id);

        return $this->redirect()->toRoute('department');
    }
}