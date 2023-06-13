<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class AuthenticationListener implements EventSubscriberInterface
{
    private $security;
    private $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

    // Obtener la ruta actual
    $currentRoute = $request->attributes->get('_route');

    // Definir las rutas permitidas sin autenticación
    $allowedRoutes = ['app_login', 'app_index','app_contacto','app_register'];

    // Verificar si el usuario no está autenticado y está accediendo a una ruta protegida
    if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY') && !in_array($currentRoute, $allowedRoutes)) {
        // Redirigir al formulario de inicio de sesión
        $url = $this->urlGenerator->generate('app_login');
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
