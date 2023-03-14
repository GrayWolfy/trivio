<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Forms\EmployeeForm;
use Application\Services\EmployeeService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EmployeeController extends AbstractActionController
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function indexAction()
    {
        $employees = $this->employeeService->getAllEmployees();
        return new ViewModel(['employees' => $employees]);
    }

    public function addAction()
    {
        $form = new EmployeeForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $this->employeeService->createEmployee($data);
            return $this->redirect()->toRoute('employee');
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employee', ['action' => 'add']);
        }

        $employee = $this->employeeService->getEmployeeById($id);

        if (!$employee) {
            return $this->redirect()->toRoute('employee', ['action' => 'index']);
        }

        $form = new EmployeeForm();
        $form->bind($employee);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $this->employeeService->updateEmployee($employee, $data);
            return $this->redirect()->toRoute('employee', ['action' => 'index']);
        }

        return new ViewModel(['id' => $id, 'form' => $form]);
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employee');
        }

        $this->employeeService->deleteEmployeeById($id);
        return $this->redirect()->toRoute('employee');
    }
}
