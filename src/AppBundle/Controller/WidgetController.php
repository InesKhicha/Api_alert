<?php
// src/AppBundle/Controller/WidgetController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends Controller
{
    /**
     * @Route("/widget/{formCode}.js", name="widget_js")
     */
    public function widgetJsAction($formCode)
    {
        $formulaire = $this->getDoctrine()->getRepository('AppBundle:Formulaire')->findOneBy(['codeFormulaire' => $formCode]);

        if (!$formulaire) {
            throw $this->createNotFoundException('Formulaire non trouvé.');
        }

        $script = <<<EOT
(function() {
    var formCode = '{$formulaire->getCodeFormulaire()}';
    var formContainer = document.getElementById('form-container');
    if (formContainer) {
        var iframe = document.createElement('iframe');
        iframe.src = 'http://localhost:8000/formulaire/' + formCode;
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