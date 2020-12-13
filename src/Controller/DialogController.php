<?php

namespace App\Controller;

use App\Entity\Dialog;
use App\Form\DialogType;
use App\Repository\DialogRepository;
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
     * @Route("/{id}", name="dialog_show", methods={"GET"})
     */
    public function show(Dialog $dialog): Response
    {
        return $this->render('dialog/show.html.twig', [
            'dialog' => $dialog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dialog_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dialog $dialog): Response
    {
        $form = $this->createForm(DialogType::class, $dialog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dialog_index');
        }

        return $this->render('dialog/edit.html.twig', [
            'dialog' => $dialog,
            'form' => $form->createView(),
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
