<?php

namespace App\Controller;

use App\Entity\Clue;
use App\Entity\Dialog;
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
     * @Route("/", name="scene_index", methods={"GET"})
     */
    public function index(SceneRepository $sceneRepository): Response
    {
        return $this->render('scene/index.html.twig', [
            'scenes' => $sceneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="scene_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        /* -- CLUE FORM --*/

        $clue = new Clue();
        $clueForm = $this->createForm(ClueType::class, $clue);
        $clueForm->handleRequest($request);

        if ($clueForm->isSubmitted() && $clueForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clue);
            $entityManager->flush();

            return $this->redirectToRoute('clue_index');
        }

        /* -- DIALOG FORM --*/

        $dialog = new Dialog();
        $dialogForm = $this->createForm(DialogType::class, $dialog);
        $dialogForm->handleRequest($request);

        if ($dialogForm->isSubmitted() && $dialogForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dialog);
            $entityManager->flush();

            return $this->redirectToRoute('dialog_index');
        }

        /* -- SCENE FORM --*/

        $scene = new Scene();
        $sceneForm = $this->createForm(SceneType::class, $scene);
        $sceneForm->handleRequest($request);

        if ($sceneForm->isSubmitted() && $sceneForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scene);
            $entityManager->flush();

            return $this->redirectToRoute('scene_index');
        }

        return $this->render('scene/new.html.twig', [
            'dialog' => $dialog,
            'dialogForm' => $dialogForm->createView(),
            'clue' => $clue,
            'clueForm' => $clueForm->createView(),
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
