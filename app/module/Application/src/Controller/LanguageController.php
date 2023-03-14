<?php
declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\I18n\Translator;
use Laminas\Session\Container;

class LanguageController extends AbstractActionController
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function indexAction()
    {
        $locale = $this->params()->fromQuery('lang', 'en_US');
        $this->translator->setLocale($locale);
        $session = new Container('language');
        $session->locale = $locale;
        return $this->redirect();
    }
}
