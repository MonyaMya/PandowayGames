<?php

namespace App\Controller;

use App\Entity\Dialog;
use App\Entity\Game;
use App\Entity\Scene;
use App\Form\DialogType;
use App\Form\SceneType;
use App\Repository\DialogRepository;
use App\Repository\SceneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dialog")
 */
class DialogController extends AbstractController
{
    /**
     * @Route("/", name="dialog_index", methods={"GET"})
     */
    public function index(DialogRepository $dialogRepository): Response
    {
        return $this->render('dialog/index.html.twig', [
            'dialogs' => $dialogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/game/{id}", name="dialog_new", methods={"GET","POST"})
     */
    public function new(Game $game, Request $request, SceneRepository $sceneRepository): Response
    {

        /* -- SCENE FORM --*/

        $scene = new Scene();
        $scene->setGame($game);
        $sceneForm = $this->createForm(SceneType::class, $scene);
        $sceneForm->handleRequest($request);

        /* -- DIALOG FORM --*/

        $dialog = new Dialog();
        $dialogForm = $this->createForm(DialogType::class, $dialog);
        $dialogForm->handleRequest($request);

        if ($dialogForm->isSubmitted() && $dialogForm->isValid() && $sceneForm->isSubmitted() && $sceneForm->isValid()) {
            $scenePosition = $sceneRepository->findNextPosition($scene->getGame());
            $scene->setPosition($scenePosition);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dialog);
            $entityManager->persist($scene);
            $entityManager->flush();
            $scene->setDialog($dialog->getId());
            $entityManager->flush();

            return $this->redirectToRoute('scene_index',['id' => $game->getId()]);
        }


        return $this->render('dialog/new.html.twig', [
            'dialog' => $dialog,
            'dialogForm' => $dialogForm->createView(),
            'scene' => $scene,
            'sceneForm' => $sceneForm->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="dialog_show", methods={"GET"})
     */
    public function show(Dialog $dialog): Response
    {
        return $this->render('dialog/show.html.twig', [
            'dialog' => $dialog,
        ]);
    }

    /**
     * @Route("/{id}", name="dialog_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dialog $dialog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dialog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dialog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dialog_index');
    }
}
