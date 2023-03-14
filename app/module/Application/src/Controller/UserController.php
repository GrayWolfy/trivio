<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Services\UserService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    public function __construct(readonly UserService $service)
    {
    }

    public function indexAction()
    {
        return new ViewModel(['users' => $this->service->getAllUsers()]);
    }

    public function addAction()
    {
        $result = $this->service->createUser($this->getRequest()->isPost(), $this->getRequest()->getPost());

        if (is_array($result)) {
            return $result;
        }

        return $this->redirect()->toRoute('user');
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if ($id === 0) {
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

        try {
            $user = $this->service->getUserById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('user');
        }

        $result = $this->service->updateUser($user, $this->getRequest()->isPost(), $this->getRequest()->getPost());
        if (is_array($result)) {
            return $result;
        }

        return $this->redirect()->toRoute('user');
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if ($id === 0) {
            return $this->redirect()->toRoute('user');
        }

        try {
            $this->service->deleteUserById($id);
        } catch (\Exception) {
            return $this->redirect()->toRoute('user');
        }


        return $this->redirect()->toRoute('user');
    }
}
