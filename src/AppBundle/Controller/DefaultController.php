<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LinkAccessPswdProtected;
use AppBundle\Entity\ShorterUrl;
use AppBundle\Entity\StatsUrl;
use AppBundle\Form\PasswordVerificationType;
use AppBundle\Form\ShorterUrlType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("", name="homepage")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) {

        // Entity Manager
        $entityManager = $this->getDoctrine()->getManager();

        // Url
        $urlShorter = new ShorterUrl();

        // Formulaire Url
        $formUrl = $this->createForm(ShorterUrlType::class, $urlShorter,
            array('validation_groups' => array("Guest")));
        $formUrl->handleRequest($request);

        if ($formUrl->isSubmitted() && $formUrl->isValid()) {

            // Sauvegarde dans la base de données de l'Url
            $entityManager->persist($urlShorter);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash('success', $this->get('translator')->trans('Message.HomePage.Success.Url.Add',
                array("%Code%" => $request->getUriForPath("/fr/").$urlShorter->getCode())));

            // Redirection sur la page Home
            return $this->redirectToRoute('homepage');
        }

        // Récupération des statistiques
        $lastCreated = $entityManager->getRepository('AppBundle:ShorterUrl')->getLastCreatedLink();
        $lastVisited = $entityManager->getRepository('AppBundle:ShorterUrl')->getLastVisitedLink();
        $moreVisited = $entityManager->getRepository('AppBundle:ShorterUrl')->getMoreVisitedLink();

        // Appel de la vue
        return $this->render('AppBundle:default:index.html.twig', array("formUrl" => $formUrl->createView(),
            'lastCreated' => $lastCreated, 'lastVisited' => $lastVisited, 'moreVisited' => $moreVisited));
    }

    /**
     * @Route("/{Code}", name="redirectPage", requirements={"Code": "[A-Z0-9]{6}"})
     * @Method({"GET", "POST"})
     */
    public function redirectAction(Request $request) {

        // Entity Manager
        $entityManager = $this->getDoctrine()->getManager();

        // Récupération du code
        $code = $request->get('Code');

        // Récupération de l'url avec le code
        /** @var ShorterUrl $urlShorter */
        $urlShorter = $entityManager->getRepository('AppBundle:ShorterUrl')->findOneBy(array('code' => $code));

        // Vérification
        if (!$urlShorter) {
            $this->addFlash('error', $this->get('translator')->trans('Message.HomePage.Error.Url.Redirect',
                array("%Code%" => $code)));

            // Redirection sur la page Home
            return $this->redirectToRoute('homepage');

        } else {
            if (!$urlShorter->getPassword()){
                // Ajout d'une statistique
                $statsUrl = new StatsUrl($urlShorter, $request->getClientIp());

                // Sauvegarde de la statistique
                $entityManager->persist($statsUrl);
                $entityManager->flush();

                // Redirection sur le lien de l'url
                return $this->redirect($urlShorter->getUrl());
            }else {
                //Si URL a un mot de passe
                // Formulaire Url

                $verifMdp = new LinkAccessPswdProtected();

                $formPswd = $this->createForm(PasswordVerificationType::class, $verifMdp);
                $formPswd->handleRequest($request);

                if ($formPswd->isSubmitted() && $formPswd->isValid())
                {
                    /** @var LinkAccessPswdProtected $data */
                    $data = $formPswd->getData();

                    // Vérifier si les mdp sont identique
                    // SI OK alors redirection, sinon ERREUR
                    if ($data->getPassword() === $urlShorter->getPassword())
                    {
                        return $this->redirect($urlShorter->getUrl());
                    }else{
                        $this->addFlash('error', $this->get('translator')->trans('Message.FormPSWD.Error'));
                    }
                }

                // SI aucun formulaire n'est envoyé alors on renvoie la page de saisie.
                return $this->render('AppBundle:default:formPSWD.html.twig',
                    array("formPswd" => $formPswd->createView()));
            }
        }
    }
}
