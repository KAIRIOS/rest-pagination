<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur;

use Doctrine\ORM\QueryBuilder;
use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\Request;

interface PaginateurInterface
{
    public const NOMBRE_PAR_PAGE = 20;

    /**
     * Retourne la pagination.
     */
    public function paginer(
        Request $request,
        QueryBuilder $queryBuilder,
        int $nombreParPage = self::NOMBRE_PAR_PAGE
    ): Pagination;
}
