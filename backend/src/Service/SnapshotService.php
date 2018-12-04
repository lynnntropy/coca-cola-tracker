<?php
/**
 * Created by PhpStorm.
 * User: omega
 * Date: 2018-12-03
 * Time: 8:32 PM
 */

namespace App\Service;


use App\Entity\QuantitySnapshot;
use App\Entity\Reward;
use App\Repository\RewardRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;

/**
 * This service is responsible for using the (public) Coca-Cola API
 * endpoint to update the database with the latest prize data.
 *
 * @package App\Service
 */
class SnapshotService
{
    private const COCA_COLA_API_ENDPOINT = 'https://api.tastly.net/v3/campaigns/133971?final=true';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RewardRepository
     */
    private $rewardRepository;

    /**
     * SnapshotService constructor.
     * @param EntityManagerInterface $entityManager
     * @param RewardRepository $rewardRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RewardRepository $rewardRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->rewardRepository = $rewardRepository;
    }

    /**
     * The method that actually takes the snapshot (pulls new data from the API).
     */
    public function takeSnapshot()
    {
        $client = new Client();

        $response = $client->request('GET', self::COCA_COLA_API_ENDPOINT, [
            'headers' => [
                'Accept-Language' => 'SRB'
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        foreach ($responseData[0]['rewards'] as $rewardData) {

            $reward = $this->rewardRepository->find($rewardData['id']);

            if ($reward === null) {
                $reward = new Reward();
                $reward->setId($rewardData['id']);
                $reward->setName($rewardData['name']);
                $reward->setImageUrl($rewardData['image_url']);
            }

            $reward->setLastKnownQuantity($rewardData['quantity']);

            $snapshot = new QuantitySnapshot();
            $snapshot->setQuantity($rewardData['quantity']);
            $this->entityManager->persist($snapshot);

            $reward->addQuantitySnapshot($snapshot);

            $this->entityManager->persist($reward);

        }

        $this->entityManager->flush();
    }
}