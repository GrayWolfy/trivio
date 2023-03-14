<?php

namespace Application\Controller;

use Application\Services\EmployeeDepartmentService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EmployeeDepartmentController extends AbstractActionController
{
    public function __construct(private EmployeeDepartmentService $service)
    {}

    public function indexAction()
    {
        return new ViewModel(['entries' => $this->service->getAllEmployeeDepartments()]);
    }

    public function addAction()
    {
        $result = $this->service->addEmployeeDepartment($this->getRequest()->getPost(), $this->getRequest()->isPost());

        if (empty($result)) {
            return $this->redirect()->toRoute('employee_department');
        }

        return $result;
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('employee_department', ['action' => 'add']);
        }

        try {
            $result = $this->service->editEmployeeDepartment($id, $this->getRequest()->getPost(), $this->getRequest()->isPost());
            if ($result !== true) {
                return $result;
            }
        } catch (\Exception) {
            return $this->redirect()->toRoute('employee_department', ['action' => 'index']);
        }

        return $this->redirect()->toRoute('employee_department', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('employee_department');
        }

        $this->service->deleteEmployeeDepartment($id);

        return $this->redirect()->toRoute('employee_department');
    }
}
