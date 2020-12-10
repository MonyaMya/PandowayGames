<?php

namespace App\Controller;

use App\Entity\BreakScene;
use App\Form\BreakSceneType;
use App\Repository\BreakSceneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/break/scene")
 */
class BreakSceneController extends AbstractController
{
    /**
     * @Route("/", name="break_scene_index", methods={"GET"})
     */
    public function index(BreakSceneRepository $breakSceneRepository): Response
    {
        return $this->render('break_scene/index.html.twig', [
            'break_scenes' => $breakSceneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="break_scene_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $breakScene = new BreakScene();
        $form = $this->createForm(BreakSceneType::class, $breakScene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($breakScene);
            $entityManager->flush();

            return $this->redirectToRoute('break_scene_index');
        }

        return $this->render('break_scene/new.html.twig', [
            'break_scene' => $breakScene,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="break_scene_show", methods={"GET"})
     */
    public function show(BreakScene $breakScene): Response
    {
        return $this->render('break_scene/show.html.twig', [
            'break_scene' => $breakScene,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="break_scene_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BreakScene $breakScene): Response
    {
        $form = $this->createForm(BreakSceneType::class, $breakScene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('break_scene_index');
        }

        return $this->render('break_scene/edit.html.twig', [
            'break_scene' => $breakScene,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="break_scene_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BreakScene $breakScene): Response
    {
        if ($this->isCsrfTokenValid('delete'.$breakScene->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($breakScene);
            $entityManager->flush();
        }

        return $this->redirectToRoute('break_scene_index');
    }
}
