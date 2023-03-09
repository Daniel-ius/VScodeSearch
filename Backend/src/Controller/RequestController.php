<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Searches;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RequestController extends AbstractController
{
    private HttpClientInterface $httpClient;
    private $searchResults;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route(path: "/search", name: "search", methods: ["POST"])]
    public function search(Request $request, CacheInterface $cache,EntityManagerInterface $entityManager): JsonResponse
    {

        $query = $request->request->get("query");
        $language = $request->request->get("language");

        if (!$query || !$language) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => "Query and language are required"
                ],
                400
            );
        }
        $searchKey = sprintf('%s-%s', $query, $language);
        try {
            $this->searchResults = $cache->get($searchKey, function (ItemInterface $item) use ($query, $language) {
                $url = sprintf(
                    'https://api.github.com/search/code?q=%s+in:file+language:%s+repo:microsoft/vscode',
                    urlencode($query),
                    urlencode($language)
                );
                $response = $this->httpClient->request('GET', $url, [
                    'headers' => [
                        'Accept' => 'application/vnd.github.v3+json'
                    ]
                ]);

                $data = json_decode($response->getContent(), true);

                return $data['items'];
            });
        } catch (InvalidArgumentException $e) {

        }
        $search = new Searches();
        $search->setQuery($query." ".$language);
        $search->setIp($request->getClientIp());
        $search->setTimeStamp(new \DateTime());

        $entityManager->persist($search);
        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'results' => $this->searchResults
        ]);
    }

}