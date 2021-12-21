<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur\Service;

use Doctrine\ORM\QueryBuilder;
use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\Request;

interface PaginateurInterface
{
    public const NOMBRE_PAR_PAGE = 20;

    /**
     * Retourne la pagination.
     * @param QueryBuilder|array $target
     */
    public function paginer(
        Request $request,
        $target
    ): Pagination;
}
