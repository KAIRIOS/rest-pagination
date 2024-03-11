<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur\Service;

use Knp\Component\Pager\PaginatorInterface;
use RestPaginateur\Entity\Pagination;
use RestPaginateur\Factory\PaginationFactory;
use Symfony\Component\HttpFoundation\Request;

class KnpPaginateur implements PaginateurInterface
{
    private PaginatorInterface $paginator;

    private PaginationFactory $paginationFactory;

    public function __construct(
        PaginatorInterface $paginator,
        PaginationFactory $paginationFactory
    ) {
        $this->paginator = $paginator;
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function paginer(
        Request $request,
        $target
    ): Pagination {
        $page = $request->get('page', 1);
        $nombreParPage = $request->get('per_page', self::NOMBRE_PAR_PAGE);

        $pagination = $this->paginator->paginate(
            $target,
            $page,
            $nombreParPage,
            [
                'wrap-queries' => true,
            ]
        );

        return $this->paginationFactory->creer(
            $request,
            $pagination->getItems(),
            $pagination->getTotalItemCount(),
            $page,
            $nombreParPage
        );
    }
}
