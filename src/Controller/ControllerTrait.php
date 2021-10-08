<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur\Controller;

use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

trait ControllerTrait
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function getContext(array $context = []): array
    {
        return $context;
    }

    /**
     * Retourne la réponse paginé au format json.
     */
    public function jsonPagine(
        Pagination $pagination,
        array $context = []
    ): JsonResponse {
        $reponse = new JsonResponse($this->serializer->normalize($pagination->getElements(), null, $this->getContext($context)));

        if (1 < $pagination->getTotalPage()) {
            // Si il y a plusieurs pages alors on retourne une 206
            $reponse->setStatusCode(Response::HTTP_PARTIAL_CONTENT);

            // On retourne les liens de pagination dans le header. ex:
            // Link: <http://url?page=1> rel="first",<http://url?page=4> rel="prev",<http://url?page=6> rel="next",<http://url?page=10> rel="last",
            $reponse->headers->set('Link', implode(', ', $pagination->getLinks()));
        }

        // On retourne les ranges de la collection. ex:
        // Content-Range: 41-50/95
        $reponse->headers->set('Content-Range', $pagination->getFirstIndex().'-'.$pagination->getLastIndex().'/'.$pagination->getTotalElements());

        return $reponse;
    }
}
