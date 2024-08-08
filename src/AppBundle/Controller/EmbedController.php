<?php
// src/AppBundle/Controller/EmbedController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmbedController extends Controller
{
    /**
     * @Route("/forms/{id}.js", name="form_embed_js")
     */
    public function embedJsAction($id)
    {
        $script = <<<EOT
(function() {
    var formContainer = document.getElementById('form-{$id}');
    if (formContainer) {
        var iframe = document.createElement('iframe');
        iframe.src = 'http://your-domain.com/form-template/{$id}';
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