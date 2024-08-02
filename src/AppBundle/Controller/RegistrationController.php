<?php
// src/AppBundle/Controller/RegistrationController.php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $validationCode = mt_rand(100000, 999999);
            $phoneNumber = $user->getPhoneNumber();
            $message = "Votre code de validation est : $validationCode";
    
            $smsService = $this->get('app.sms_service');
            $response = $smsService->sendSms($phoneNumber, $message);
    
            // Vérifiez si l'envoi du SMS a réussi
            if (isset($response['success']) && $response['success']) {
                // Stockez le code de validation dans la session
                $this->get('session')->set('validation_code', $validationCode);
                $this->get('session')->set('pending_user', $user);
    
                return $this->redirectToRoute('validate_code');
            } else {
                $this->addFlash('error', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer.');
                // Log l'erreur
                $this->get('logger')->error('SMS sending failed', ['response' => $response]);
            }
        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/validate-code", name="validate_code")
     */
    public function validateCodeAction(Request $request)
    {
        $submittedCode = $request->request->get('validation_code');
        $storedCode = $this->get('session')->get('validation_code');
        $user = $this->get('session')->get('pending_user');

        if ($request->isMethod('POST')) {
            if ($submittedCode == $storedCode) {
                // Le code est valide, enregistrez l'utilisateur
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->remove('validation_code');
                $this->get('session')->remove('pending_user');

                $this->addFlash('success', 'Inscription réussie !');
                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash('error', 'Code de validation incorrect.');
            }
        }

        return $this->render('registration/validate_code.html.twig');
    }
}