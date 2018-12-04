<?php

namespace App\Controller;

use App\Entity\Reward;
use App\Repository\RewardRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RewardController extends AbstractController
{
    /**
     * @var RewardRepository
     */
    private $rewardRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * RewardController constructor.
     * @param RewardRepository $rewardRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        RewardRepository $rewardRepository,
        SerializerInterface $serializer
    )
    {
        $this->rewardRepository = $rewardRepository;
        $this->serializer = $serializer;
    }

    /**
     * Lists all rewards.
     *
     * @Route("/rewards", name="rewards", methods={"GET"})
     */
    public function index()
    {
        $rewards = $this->rewardRepository->findAll();

        $json = $this->serializer->serialize($rewards, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * Lists all snapshots for a given reward.
     *
     * @Route("/rewards/{id}/snapshots", name="snapshots", methods={"GET"})
     * @param Reward $reward
     * @return JsonResponse
     */
    public function shapshots(Reward $reward)
    {
        $snapshots = $reward->getQuantitySnapshots();

        $json = $this->serializer->serialize($snapshots, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
