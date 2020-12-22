<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Scene;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\SceneRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/game")
 */
class GameController extends AbstractController
{

    /**
     * @Route("/", name="game_index", methods={"GET"})
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }


    /**
     * @Route("/mygames", name="mygames", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function myGames(?UserInterface $user, GameRepository $gameRepository): Response
    {
        $author = $user->getEmail();
        $games = $this->getDoctrine()->getRepository(Game::class)
            ->findBy(['author'=> $author]);
        return $this->render('game/mygames.html.twig', [
            'mygames' => $games,
        ]);
    }

    /**
     * @Route("/mygames/move/{id}/{targetSceneId}", name="move", methods={"GET"})
     * @param Scene $scene
     * @param SceneRepository $sceneRepository
     * @param $entityManager
     * @return JsonResponse|null
     */
    public function move (Scene $scene, int $targetSceneId, SceneRepository $sceneRepository, EntityManagerInterface $entityManager): ?JsonResponse
    {

        $targetScene = $sceneRepository->findOneBy(["id" => $targetSceneId]);

        $startPosition = $scene->getPosition();


        if ($startPosition < $targetScene->getPosition() - 1) {
            $endPosition = $targetScene->getPosition() - 1;
        } else {
            $endPosition = $targetScene->getPosition();
        }

        $moveScenes = $sceneRepository->findBetweenPositions($startPosition, $endPosition);
        foreach ($moveScenes as $moveScene) {

            if ($startPosition < $endPosition) {
                $moveScene->setPosition($moveScene->getPosition() - 1);
            } else {
                $moveScene->setPosition($moveScene->getPosition() + 1);
            }

            $entityManager->persist($moveScene);
        }

        $scene->setPosition($endPosition);


        $entityManager->persist($scene);
        $entityManager->flush();

        return new JsonResponse(json_encode("ok"));
    }

    /**
     * @Route("/new", name="game_new", methods={"GET","POST"})
     */
    public function new(?UserInterface $user, Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $author = $user->getEmail();
        $game->setAuthor($author);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="game_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_index');
    }
}
