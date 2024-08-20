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
use AppBundle\Entity\FileContent;
use AppBundle\Form\FileContentType;
use AppBundle\Entity\Groupe;

class FormulaireController extends Controller
{
    /**
     * @Route("/creer-formulaire", name="creer_formulaire")
     */
    public function creerFormulaireAction(Request $request)
    {
        $formulaire = new Formulaire();

        // Récupérer le client via l'API key (simulation avec un paramètre query string 'api_key')
       
        $smsUser = $this->getDoctrine()
                       ->getRepository('AppBundle:SmsUser')
                       ->findOneBy(['apiKey' => $this->getParameter('sms_api_key')]);

                       if (!$smsUser) {
                        throw $this->createNotFoundException('SmsUser non trouvé.');
                    }
                
                    $userId = $smsUser->getId(); // Récupérer l'ID de l'utilisateur SmsUser
                
                    $id = 1; // Remplacer par l'ID du groupe que vous souhaitez récupérer
                
                    $groupeRepository = $this->getDoctrine()->getRepository(Groupe::class);
                
                    // Appeler la méthode pour trouver le groupe
                    $groupe = $groupeRepository->findOneBy([
                        'id' => $id,
                        'user' => $smsUser // Utiliser l'objet SmsUser directement
                    ]);
                
                    if (!$groupe) {
                        // Gérer le cas où le groupe n'est pas trouvé
                        throw $this->createNotFoundException('Groupe not found.');
                    }
        $form = $this->createForm(FormulaireType::class, $formulaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if lastname and firstname are set to default values
            if ($formulaire->getLastname() === 'Nom') {
                // Only set to 'Nom' if button has been clicked
                $formulaire->setLastname('Nom');
            } else {
                // Here we set it to null if not clicked
                $formulaire->setLastname(null);
            }
        
            if ($formulaire->getFirstname() === 'Prénom') {
                // Only set to 'Prénom' if button has been clicked
                $formulaire->setFirstname('Prénom');
            } else {
                // Here we set it to null if not clicked
                $formulaire->setFirstname(null);
            }
            $codeFormulaire = bin2hex(random_bytes(10));
            $formulaire->setCodeFormulaire($codeFormulaire);
            $formulaire->setGroupe($groupe);

            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();

            return $this->redirectToRoute('mes_formulaires');
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

        $fileContent = new FileContent();
        $form = $this->createForm(FileContentType::class, $fileContent, ['formulaire' => $formulaire]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $validationCode = mt_rand(100000, 999999);
            $phoneNumber = $fileContent->getPhone();
            $message = "Votre code de validation est : $validationCode";

            $smsService = $this->get('app.sms_service');
            $response = $smsService->sendSms($phoneNumber, $message);

            if (isset($response['success']) && $response['success']) {
                // Store form data in session
            // À l'intérieur de la méthode afficherFormulaireAction
            $session = $request->getSession();

            // Sérialisation des données avant encodage
            $dataToEncode = serialize([
                'phone' => $fileContent->getPhone(),
                'lastname' => $fileContent->getLastname(),
                'firstname' => $fileContent->getFirstname(),
                'custom1' => $fileContent->getCustom1(),
                'custom2' => $fileContent->getCustom2(),
                'custom3' => $fileContent->getCustom3(),
                'custom4' => $fileContent->getCustom4(),
                'grp' => $fileContent->getGrp()
            ]);

            // Encodage en base64
            $encodedData = base64_encode($dataToEncode);

            $session->set('form_data', $encodedData);

                $codeValide = new CodeValide();
                $codeValide->setCode($validationCode);
                $codeValide->setExpired(false);
                $codeValide->setCreatedAt(new \DateTime());
                $em->persist($codeValide);
                $em->flush();

                return $this->redirectToRoute('validate_code', ['codeId' => $codeValide->getId()]);
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
     * @Route("/validate-code/{codeId}", name="validate_code")
     */
    public function validateCodeAction(Request $request, $codeId)
    {
        $submittedCode = $request->request->get('validation_code');
        $em = $this->getDoctrine()->getManager();
        $codeValide = $em->getRepository('AppBundle:CodeValide')->find($codeId);

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

                // Retrieve form data from session
                // À l'intérieur de la méthode validateCodeAction
                $session = $request->getSession();

                $encodedData = $session->get('form_data');
                if ($encodedData) {
                    // Décodage et désérialisation des données
                    $decodedData = base64_decode($encodedData);
                    $formData = unserialize($decodedData);
                    
                    if ($formData) {
                        $fileContent = new FileContent();
                        $fileContent->setPhone($formData['phone']);
                        $fileContent->setLastname($formData['lastname']);
                        $fileContent->setFirstname($formData['firstname']);
                        $fileContent->setCustom1($formData['custom1']);
                        $fileContent->setCustom2($formData['custom2']);
                        $fileContent->setCustom3($formData['custom3']);
                        $fileContent->setCustom4($formData['custom4']);
                        $fileContent->setGrp($formData['grp']);

                        $em->persist($fileContent);
                        $em->flush();

                        $this->addFlash('success', 'Inscription réussie !');
                        return $this->redirectToRoute('homepage');
                    }
                }
            } else {
                $this->addFlash('error', 'Code de validation incorrect.');
            }
        }

        return $this->render('formulaire/validate_code.html.twig', [
            'codeId' => $codeId,
        ]);
    }

   /**
     * @Route("/mes-formulaires", name="mes_formulaires")
     */
    public function mesFormulairesAction(Request $request)
    {
        $smsUser = $this->getDoctrine()
        ->getRepository('AppBundle:SmsUser')
        ->findOneBy(['apiKey' => $this->getParameter('sms_api_key')]);

        if (!$smsUser) {
         throw $this->createNotFoundException('SmsUser non trouvé.');
     }
 
     $userId = $smsUser->getId(); // Récupérer l'ID de l'utilisateur SmsUser
 
     $id = 1; // Remplacer par l'ID du groupe que vous souhaitez récupérer
 
     $groupeRepository = $this->getDoctrine()->getRepository(Groupe::class);
 
     // Appeler la méthode pour trouver le groupe
     $groupe = $groupeRepository->findOneBy([
         'id' => $id,
         'user' => $smsUser // Utiliser l'objet SmsUser directement
     ]);
 
     if (!$groupe) {
         // Gérer le cas où le groupe n'est pas trouvé
         throw $this->createNotFoundException('Groupe not found.');
     }
        $formulaires = $this->getDoctrine()
                            ->getRepository(Formulaire::class)
                            ->findBy(['groupe' => $groupe]);

        return $this->render('formulaire/mes_formulaires.html.twig', [
            'formulaires' => $formulaires,
        ]);
    }

    
    /**
 * @Route("/supprimer-formulaire/{id}", name="supprimer_formulaire")
 */
public function supprimerFormulaireAction(Request $request, $id)
{
    $em = $this->getDoctrine()->getManager();
    $formulaire = $em->getRepository(Formulaire::class)->find($id);

    if (!$formulaire) {
        throw $this->createNotFoundException('Formulaire non trouvé');
    }

    
    // Suppression du formulaire
    $em->remove($formulaire);
    $em->flush();

    $this->addFlash('success', 'Le formulaire a été supprimé avec succès.');

    return $this->redirectToRoute('mes_formulaires');
}
}