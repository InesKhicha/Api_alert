<?php
// src/AppBundle/Controller/FormulaireController.php
namespace AppBundle\Controller;
use AppBundle\Entity\Groupe;
use AppBundle\Entity\CodeValide;
use AppBundle\Entity\Formulaire;
use AppBundle\Entity\FileContent;
use AppBundle\Form\FormulaireType;
use AppBundle\Form\FileContentType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

    $userId = $smsUser->getId();
    $id = 1; // Remplacer par l'ID du groupe que vous souhaitez récupérer

    $groupeRepository = $this->getDoctrine()->getRepository(Groupe::class);
    $groupe = $groupeRepository->findOneBy([
        'id' => $id,
        'user' => $smsUser 
    ]);

    if (!$groupe) {
        throw $this->createNotFoundException('Groupe non trouvé.');
    }

    $form = $this->createForm(FormulaireType::class, $formulaire);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $errors = [];

        // Normalisation et validation des champs
        $normalizedFields = [];
        $phoneVariations = ['phone', 'tel', 'tél', 'telephon', 'télephon', 'tèlephon', 'tèlèphon', 'teléphon', 'telèphon'];
        $existingFields = ['nom' => 'lastname', 'prénom' => 'firstname', 'firstname' => 'firstname', 'lastname' => 'lastname'];

        // Normalisation des noms de champs
        foreach (['phone', 'lastname', 'firstname', 'custom1', 'custom2', 'custom3', 'custom4'] as $field) {
            $value = $formulaire->{'get'.ucfirst($field)}();
            if ($value) {
                $normalizedValue = $this->normalizeString($value);
                if (in_array($normalizedValue, $phoneVariations)) {
                    $errors[] = "Utilisez 'Téléphone' qui existe déjà à la place de ses variantes.";
                }

                if (isset($normalizedFields[$normalizedValue])) {
                    $errors[] = "Duplication du champ : ". $value;
                }

                if (isset($existingFields[$normalizedValue]) && $existingFields[$normalizedValue] !== $field) {
                    $errors[] = "La valeur '$value' correspond déjà à un autre champ existant.";
                } else {
                    $normalizedFields[$normalizedValue] = $field;
                }
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        } else {
            // Gestion spécifique des champs 'Nom' et 'Prénom'
            if ($formulaire->getLastname() === 'Nom') {
                $formulaire->setLastname('Nom');
            } else {
                $formulaire->setLastname(null);
            }

            if ($formulaire->getFirstname() === 'Prénom') {
                $formulaire->setFirstname('Prénom');
            } else {
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
    }

    return $this->render('formulaire/creer.html.twig', [
        'form' => $form->createView(),
    ]);
}

private function normalizeString($str)
{
    return strtolower(preg_replace('/[\x{0300}-\x{036f}]/u', '', \Normalizer::normalize($str, \Normalizer::FORM_D)));
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
    
    $groupe = $formulaire->getGroupe();
    $fileContent = new FileContent();
    $form = $this->createForm(FileContentType::class, $fileContent, ['formulaire' => $formulaire]);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $countryCode = $form->get('country_code')->getData();
        $phoneNumber = $form->get('phone')->getData();
        $action = $request->request->get('action');

        if (strpos($phoneNumber, '0') === 0) {
            $formattedPhoneNumber = substr($phoneNumber, 1);
        } else {
            $formattedPhoneNumber = $phoneNumber;
        }
        
        $fullPhoneNumber = $countryCode . $formattedPhoneNumber;
        $fileContent->setPhone($fullPhoneNumber);

        // Check if the user is already registered or not
        $existingUser = $em->getRepository('AppBundle:FileContent')->findOneBy([
            'phone' => $fileContent->getPhone(),
            'grp' => $groupe
        ]);

        if ($action === 'inscription' && $existingUser) {
            // User is already registered
            $this->addFlash('danger', 'ATTENTION : Vous êtes déjà inscrit.');
        } elseif ($action === 'desinscription' && !$existingUser) {
            // User is not registered
            $this->addFlash('danger', 'ATTENTION : Vous n\'êtes pas inscrit !!');
        } else {
            // Check if the phone number exists in the last 5 minutes
            $fiveMinutesAgo = new \DateTime('-5 minutes');
            $recentEntries = $em->getRepository('AppBundle:CodeValide')->findBy([
                'phone' => $fileContent->getPhone(),
                'expired' => false
            ], ['createdAt' => 'DESC']);

            $recentEntryFound = false;

            foreach ($recentEntries as $entry) {
                if ($entry->getCreatedAt() > $fiveMinutesAgo) {
                    $formData = unserialize($entry->getFormData());
                    if (isset($formData['grp']) && $formData['grp'] == $groupe->getId()) {
                        $recentEntryFound = true;
                        break;
                    }
                }
            }

            if ($recentEntryFound) {
                
                $this->addFlash('danger', 'Vous avez déjà effectué cette opération. Retournez à votre page précédente et entrez votre code.');
            } else {
                // Proceed with the existing logic to handle the form submission
                $codesToRemove = $em->getRepository('AppBundle:CodeValide')->createQueryBuilder('c')
                    ->where('c.expired = true OR c.createdAt < :fiveMinutesAgo')
                    ->setParameter('fiveMinutesAgo', $fiveMinutesAgo)
                    ->getQuery()
                    ->getResult();

                foreach ($codesToRemove as $code) {
                    $em->remove($code);
                }
                $em->flush();

                // Générer le code de validation
                $validationCode = mt_rand(100000, 999999);
                $phoneNumber = $fileContent->getPhone();
                $message = "Votre code de validation est : $validationCode";
                $smsService = $this->get('app.sms_service');
                //L'API de Compte SMS partner Perso
                $apiKey = '8601b59cbba3cace735177b50292b80978b5c9bf';
                $response = $smsService->sendSms($apiKey, $phoneNumber, $message);
                if (isset($response['success']) && $response['success']) {
                    $codeValide = new CodeValide();
                    $codeValide->setCode($validationCode);
                    $codeValide->setExpired(false);
                    $codeValide->setCreatedAt(new \DateTime());
                    $codeValide->setPhone($fileContent->getPhone());

                    $dataToEncode = serialize([
                        'phone' => $fileContent->getPhone(),
                        'lastname' => $fileContent->getLastname(),
                        'firstname' => $fileContent->getFirstname(),
                        'custom1' => $fileContent->getCustom1(),
                        'custom2' => $fileContent->getCustom2(),
                        'custom3' => $fileContent->getCustom3(),
                        'custom4' => $fileContent->getCustom4(),
                        'grp' => $groupe->getId(),
                        'action' => $action
                    ]);

                    $codeValide->setFormData($dataToEncode);
                    $em->persist($codeValide);
                    $em->flush();

                    return $this->redirectToRoute('validate_code', ['codeId' => $codeValide->getId()]);
                } else {
                    $this->addFlash('error', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer.');
                    $this->get('logger')->error('SMS sending failed', ['response' => $response]);
                }
            }
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

    // Récupération du code de validation à partir de l'ID
    $codeValide = $em->getRepository('AppBundle:CodeValide')->find($codeId);

    if ($codeValide) {
        // Vérification du temps écoulé depuis la création du code
        $currentDateTime = new \DateTime();
        $codeCreationTime = $codeValide->getCreatedAt();
        $interval = $currentDateTime->diff($codeCreationTime);
        $minutes = $interval->i;
        $seconds = $interval->s;

        // Vérification si le code a expiré (plus de 5 minutes)
        if ($minutes > 5 || ($minutes == 5 && $seconds > 0)) {
            $codeValide->setExpired(true);
            $em->flush();
            $this->addFlash('danger', 'Le code de validation a expiré.');
            return $this->render('formulaire/validate_code.html.twig', [
                'codeId' => $codeId,
                'showResendButton' => true, // Afficher le bouton pour renvoyer le code
            ]);
        }

        // Si le formulaire a été soumis
        if ($request->isMethod('POST')) {
            if ($submittedCode == $codeValide->getCode()) {
                // Marquer le code comme expiré une fois utilisé
                $codeValide->setExpired(true);
                $em->flush();

                // Récupération des données liées au code
                $fileContent = new FileContent();
                $formData = unserialize($codeValide->getFormData());
                
                if ($formData) {
                    $fileContent->setPhone($formData['phone']);
                    $fileContent->setLastname($formData['lastname']);
                    $fileContent->setFirstname($formData['firstname']);
                    $fileContent->setCustom1($formData['custom1']);
                    $fileContent->setCustom2($formData['custom2']);
                    $fileContent->setCustom3($formData['custom3']);
                    $fileContent->setCustom4($formData['custom4']);
                    $idgrp = $formData['grp'];
                    $action = $formData['action'];
                    $groupe = $em->getRepository('AppBundle:Groupe')->find($idgrp);
                    $fileContent->setGrp($groupe);
                }

                // Gestion des différentes actions (inscription ou désinscription)
                if ($action === 'inscription') {
                    // Vérifier si l'utilisateur est déjà inscrit
                    $existingUser = $em->getRepository('AppBundle:FileContent')->findOneBy([
                        'phone' => $fileContent->getPhone(),
                        'grp' => $fileContent->getGrp()
                    ]);

                    if ($existingUser) {
                        // L'utilisateur est déjà inscrit
                        $this->addFlash('danger', 'ATTENTION : Vous êtes déjà inscrit.');
                    } else {
                        // Ajouter le nouvel utilisateur
                        $em->persist($fileContent);
                        $em->flush();

                        return $this->redirectToRoute('homepage');
                    }
                } elseif ($action === 'desinscription') {
                    // Vérifier si l'utilisateur est inscrit
                    $fileContentRM = $em->getRepository('AppBundle:FileContent')->findOneBy([
                        'phone' => $fileContent->getPhone(),
                        'grp' => $fileContent->getGrp()
                    ]);

                    if ($fileContentRM) {
                        // Supprimer l'utilisateur
                        $em->remove($fileContentRM);
                        $em->flush();

                        return $this->redirectToRoute('desinscription_success');
                    } else {
                        // L'utilisateur n'est pas inscrit
                        $this->addFlash('danger', 'ATTENTION : Vous n\'êtes pas inscrit !!');
                    }
                } else {
                    $this->addFlash('danger', 'Aucune action valide trouvée.');
                }
            } else {
                $this->addFlash('danger', 'Code de validation incorrect ou expiré.');
            }
        }

        // Afficher le formulaire pour entrer le code de validation
        return $this->render('formulaire/validate_code.html.twig', [
            'codeId' => $codeId,
            'minutes' => $minutes,
            'seconds' => $seconds,
        ]);
    } else {
        $this->addFlash('danger', 'Code non reçu, veuillez réessayer.');
        return $this->render('formulaire/validate_code.html.twig', [
            'codeId' => $codeId,
        ]);
    }
}

/**
 * @Route("/desinscription-success", name="desinscription_success")
 */
public function desinscriptionSuccessAction()
{
    return $this->render('formulaire/desinscription_success.html.twig');
}
    // Ajouter une route pour renvoyer le code
/**
 * @Route("/resend-code/{codeId}", name="resend_code")
 */
public function resendCodeAction($codeId)
{
    $em = $this->getDoctrine()->getManager();
    $codeValide = $em->getRepository('AppBundle:CodeValide')->find($codeId);

    if ($codeValide) {
        $newValidationCode = mt_rand(100000, 999999);
        $phoneNumber = $codeValide->getPhone();
        $message = "Votre nouveau code de validation est : $newValidationCode";

        $smsService = $this->get('app.sms_service');
        //L'API de Compte SMS partner Perso
        $apiKey = '8601b59cbba3cace735177b50292b80978b5c9bf';
        $response = $smsService->sendSms($apiKey, $phoneNumber, $message);

        if (isset($response['success']) && $response['success']) {
            $codeValide->setCode($newValidationCode);
            $codeValide->setCreatedAt(new \DateTime());
            $codeValide->setExpired(false);
            $em->flush();

            $this->addFlash('success', 'Un nouveau code de validation a été envoyé.');
        } else {
            $this->addFlash('danger', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer.');
        }
    } else {
        $this->addFlash('danger', 'Impossible de renvoyer le code.');
    }

    return $this->redirectToRoute('validate_code', ['codeId' => $codeId]);
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
        return new JsonResponse(['status' => 'error', 'message' => 'Formulaire non trouvé'], 404);
    }
   
    $em->remove($formulaire);
    $em->flush();

    return new JsonResponse(['status' => 'success', 'message' => 'Le formulaire a été supprimé avec succès.']);
}


}