<?php

declare(strict_types=1);

namespace Application;

use Laminas\I18n\Translator\TranslatorInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $translator = $serviceManager->get(TranslatorInterface::class);
        $session = new Container('language');
        $locale = $session->locale ?? 'en_US';
        $translator->setLocale($locale);
    }
}
