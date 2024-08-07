<?php
// src/AppBundle/Controller/WidgetController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends Controller
{
    /**
     * @Route("/widget.js", name="widget_js")
     */
    public function widgetJsAction()
    {
        $script = <<<EOT
(function() {
    var formContainer = document.getElementById('form-container');
    if (formContainer) {
        var iframe = document.createElement('iframe');
        iframe.src = 'http://localhost:8000/register';
        iframe.width = '100%';
        iframe.height = '600px';
        iframe.style.border = 'none';
        formContainer.appendChild(iframe);
    }
})();
EOT;

        $response = new Response($script);
        $response->headers->set('Content-Type', 'application/javascript');

        return $response;
    }
}