<?php

namespace App\Controller;

use App\Entity\Clue;
use App\Entity\Dialog;
use App\Entity\Game;
use App\Entity\Scene;
use App\Form\ClueType;
use App\Form\DialogType;
use App\Form\SceneType;
use App\Repository\ClueRepository;
use App\Repository\SceneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clue")
 */
class ClueController extends AbstractController
{


    /**
     * @Route("/new/game/{id}", name="clue_new", methods={"GET","POST"})
     */
    public function new(Game $game, Request $request, SceneRepository $sceneRepository): Response
    {

        /* -- SCENE FORM --*/

        $scene = new Scene();
        $scene->setGame($game);
        $sceneForm = $this->createForm(SceneType::class, $scene);
        $sceneForm->handleRequest($request);

        /* -- CLUE FORM --*/

        $clue = new Clue();
        $clueForm = $this->createForm(ClueType::class, $clue);
        $clueForm->handleRequest($request);

        if ($clueForm->isSubmitted() && $clueForm->isValid() && $sceneForm->isSubmitted() && $sceneForm->isValid()) {
            $scenePosition = $sceneRepository->findNextPosition($scene->getGame());
            $scene->setPosition($scenePosition);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clue);
            $entityManager->persist($scene);
            $entityManager->flush();
            $scene->setClue($clue->getId());
            $entityManager->flush();

            return $this->redirectToRoute('scene_index',['id' => $game->getId()]);
        }


        return $this->render('clue/new.html.twig', [
            'clue' => $clue,
            'clueForm' => $clueForm->createView(),
            'scene' => $scene,
            'sceneForm' => $sceneForm->createView(),
        ]);
    }



    /**
     * @Route("/", name="clue_index", methods={"GET"})
     */
    public function index(ClueRepository $clueRepository): Response
    {
        return $this->render('clue/index.html.twig', [
            'clues' => $clueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="clue_show", methods={"GET"})
     */
    public function show(Clue $clue): Response
    {
        return $this->render('clue/show.html.twig', [
            'clue' => $clue,
        ]);
    }

    /**
     * @Route("/{id}", name="clue_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Clue $clue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($clue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('clue_index');
    }
}
