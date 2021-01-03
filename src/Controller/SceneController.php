<?php

namespace App\Controller;

use App\Entity\Clue;
use App\Entity\Dialog;
use App\Entity\Game;
use App\Entity\Scene;
use App\Form\ClueType;
use App\Form\DialogType;
use App\Form\SceneType;
use App\Repository\SceneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scene")
 */
class SceneController extends AbstractController
{
    /**
     * @Route("/game/{id}", name="scene_index", methods={"GET"})
     */
    public function index(Game $game, SceneRepository $sceneRepository): Response
    {
        return $this->render('scene/index.html.twig', [
            'scenes' => $sceneRepository->findBy(['game'=>$game], ['position' => 'ASC']),
            'game' => $game,
        ]);
    }

    /**
     * @Route("/new/game/{id}", name="scene_new", methods={"GET","POST"})
     */
    public function new(Game $game, Request $request, SceneRepository $sceneRepository): Response
    {

        $scene = new Scene();
        $scene->setGame($game);
        $sceneForm = $this->createForm(SceneType::class, $scene);
        $sceneForm->handleRequest($request);

        if ($sceneForm->isSubmitted() && $sceneForm->isValid()) {
            $scenePosition = $sceneRepository->findNextPosition($scene->getGame());
            $scene->setPosition($scenePosition);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scene);
            $entityManager->flush();

            return $this->redirectToRoute('scene_index',['id' => $game->getId()]);
        }


        return $this->render('scene/new.html.twig', [
            'scene' => $scene,
            'sceneForm' => $sceneForm->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="scene_show", methods={"GET"})
     */
    public function show(Scene $scene): Response
    {
        return $this->render('scene/show.html.twig', [
            'scene' => $scene,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="scene_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Scene $scene): Response
    {

        $sceneForm = $this->createForm(SceneType::class, $scene);
        $sceneForm->handleRequest($request);

        if ($sceneForm->isSubmitted() && $sceneForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scene_index');
        }

        return $this->render('scene/edit.html.twig', [
            'scene' => $scene,
            'sceneForm' => $sceneForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scene_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Scene $scene): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scene->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scene);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scene_index');
    }
}
