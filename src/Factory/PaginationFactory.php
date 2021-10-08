<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur\Factory;

use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class PaginationFactory
{
    /** @var RouterInterface */
    private $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    public function creer(
        Request $request,
        array $elements,
        int $totalElements,
        int $page,
        int $elementsParPage
    ): Pagination {
        return new Pagination(
            $this->router,
            $request,
            $elements,
            $totalElements,
            $page,
            $elementsParPage
        );
    }
}
