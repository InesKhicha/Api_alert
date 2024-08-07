<?php
// src/AppBundle/Controller/RegistrationController.php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\CodeValide;
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

            if (isset($response['success']) && $response['success']) {
                $em = $this->getDoctrine()->getManager();
                $client = $em->getRepository('AppBundle:Client')->findOneBy(['apiKey' => $this->getParameter('sms_api_key')]);
                $user->setClient($client);
                $em->persist($user);
                $em->flush();

                $codeValide = new CodeValide();
                $codeValide->setCode($validationCode);
                $codeValide->setExpired(false);
                $codeValide->setCreatedAt(new \DateTime());
                $codeValide->setUser($user);
                $em->persist($codeValide);
                $em->flush();

                return $this->redirectToRoute('validate_code', ['userId' => $user->getId()]);
            } else {
                $this->addFlash('error', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer.');
                $this->get('logger')->error('SMS sending failed', ['response' => $response]);
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/validate-code/{userId}", name="validate_code")
     */
    public function validateCodeAction(Request $request, $userId)
    {
        $submittedCode = $request->request->get('validation_code');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $codeValide = $em->getRepository('AppBundle:CodeValide')->findOneBy(['user' => $user, 'expired' => false]);

        if ($request->isMethod('POST')) {
            $currentDateTime = new \DateTime();
            $codeCreationTime = $codeValide->getCreatedAt();
            $interval = $currentDateTime->diff($codeCreationTime);
            $minutes = $interval->i;
            $seconds = $interval->s;

            if ($minutes > 3 || ($minutes == 3 && $seconds > 0)) {
                $codeValide->setExpired(true);
                $em->flush();
                $this->addFlash('error', 'Le code de validation a expiré.');
            } elseif ($submittedCode == $codeValide->getCode()) {
                $codeValide->setExpired(true);
                $em->flush();

                $this->addFlash('success', 'Inscription réussie !');
                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash('error', 'Code de validation incorrect.');
            }
        }

        return $this->render('registration/validate_code.html.twig', [
            'userId' => $userId,
        ]);
    }
}