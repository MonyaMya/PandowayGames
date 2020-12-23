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
     * @Route("/mygames/move/{id}/{targetScene}", name="move", methods={"POST"})
     * @param Scene $scene : the scene that has been dragged and dropped
     * @param Scene $targetScene : the scene after the dragged scene once it has been dropped
     *                             when we moved to the right, the dragged scene position is the targetScene position-1 and target scene doesn't move
     *                             but when we move to the left, the dragged scene take the targetScene position and the target scene is shifted
     * @param SceneRepository $sceneRepository
     * @param $entityManager
     * @return JsonResponse|null
     */
    public function move (Scene $scene, ?Scene $targetScene, SceneRepository $sceneRepository, EntityManagerInterface $entityManager): ?JsonResponse
    {
        $startPosition = $scene->getPosition();

        //use the final position by default
        $finalScene = $sceneRepository->findOneBy([],['position'=>'DESC']);
        $endPosition = $finalScene->getPosition() + 1;
        //in cas a target position scene is given
        if ($targetScene!=null) {
            $endPosition = $targetScene->getPosition();
        }
        //in cas we move right, we do not take the position of the target but the position just on the left
        if ($startPosition < $endPosition) {
            $endPosition--;
        }

        $movingScenes = $sceneRepository->findBetweenPositions($startPosition, $endPosition);
        foreach ($movingScenes as $movingScene) {
            if ($startPosition < $endPosition) {
                //if the scene is dragged to the right, every other scenes on the way are moved left
                $movingScene->setPosition($movingScene->getPosition() - 1);
            } else {
                //if the scene is dragged to the left, every other scenes on the way are moved right
                $movingScene->setPosition($movingScene->getPosition() + 1);
            }

            $entityManager->persist($movingScene);
        }

        //put the moved scene as its end position
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
