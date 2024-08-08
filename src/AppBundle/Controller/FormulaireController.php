<?php
// src/AppBundle/Controller/FormulaireController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Formulaire;
use AppBundle\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\CodeValide;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class FormulaireController extends Controller
{
    /**
     * @Route("/creer-formulaire", name="creer_formulaire")
     */
    public function creerFormulaireAction(Request $request)
    {
        $formulaire = new Formulaire();

        // Récupérer le client via l'API key (simulation avec un paramètre query string 'api_key')
        $apiKey = $request->query->get('apiKey');
        $client = $this->getDoctrine()
                       ->getRepository('AppBundle:Client')
                       ->findOneBy(['apiKey' => $this->getParameter('sms_api_key')]);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé.');
        }

        $form = $this->createForm(FormulaireType::class, $formulaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Générer un code unique pour le formulaire
            $codeFormulaire = bin2hex(random_bytes(10));
            $formulaire->setCodeFormulaire($codeFormulaire);
            $formulaire->setClient($client);

            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();

            return $this->redirectToRoute('afficher_formulaire', ['code' => $codeFormulaire]);
        }

        return $this->render('formulaire/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

 /**
     * @Route("/formulaire/{code}", name="afficher_formulaire")
     */
    public function afficherFormulaireAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();
        $formulaire = $em->getRepository('AppBundle:Formulaire')->findOneBy(['codeFormulaire' => $code]);

        if (!$formulaire) {
            throw $this->createNotFoundException('Formulaire non trouvé');
        }

        $user = new User();
        $user->setFormulaire($formulaire);

        $form = $this->createForm(UserType::class, $user, ['formulaire' => $formulaire]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $validationCode = mt_rand(100000, 999999);
            $phoneNumber = $user->getTel();
            $message = "Votre code de validation est : $validationCode";

            $smsService = $this->get('app.sms_service');
            $response = $smsService->sendSms($phoneNumber, $message);

            if (isset($response['success']) && $response['success']) {
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

        return $this->render('formulaire/afficher.html.twig', [
            'formulaire' => $formulaire,
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

        return $this->render('formulaire/validate_code.html.twig', [
            'userId' => $userId,
        ]);
    }
}