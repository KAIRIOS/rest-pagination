<?php

/*
 * Ce fichier est la propriété de TéléDiag
 */

namespace RestPaginateur\Service\tests\units;

use atoum\atoum\test;
use Knp\Component\Pager\Pagination\PaginationInterface;
use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\Request;

class KnpPaginateur extends test
{
    private const PAGE = 2;
    private const PER_PAGE = 10;

    private $paginator;
    private $paginationFactory;

    public function beforeTestMethod($testMethod)
    {
        $this->paginator = new \mock\Knp\Component\Pager\PaginatorInterface();
        $this->calling($this->paginator)->paginate = $this->getKnpPagination();

        $this->getMockGenerator()->orphanize('__construct');
        $this->paginationFactory = new \mock\RestPaginateur\Factory\PaginationFactory();
        $this->calling($this->paginationFactory)->creer = $this->getPagination();
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance(
            $this->paginator,
            $this->paginationFactory
        );
    }

    public function testPaginer(): void
    {
        $this
        ->given(
            $request = $this->getRequest(self::PAGE, self::PER_PAGE),
            $target = [1, 2, 3],
            $tested = $this->getTestedInstance()
        )
        ->object($tested->paginer($request, $target))
            ->isInstanceOf(Pagination::class)
        ->mock($this->paginator)->call('paginate')->withArguments($target, self::PAGE, self::PER_PAGE, ['wrap-queries' => true])->once()
        ->mock($this->paginationFactory)->call('creer')->once()
        ;
    }

    private function getRequest(int $page, int $perPage): Request
    {
        $this->getMockGenerator()->orphanize('__construct');
        $mock = new \mock\Symfony\Component\HttpFoundation\Request();
        $this->calling($mock)->get = function(string $key, $default = null) use ($page, $perPage) {
            if ('page' === $key) {
                return $page;
            }
            if ('per_page' === $key) {
                return $perPage;
            }
        };

        return $mock;
    }

    private function getPagination(): Pagination
    {
        $this->getMockGenerator()->orphanize('__construct');
        return new \mock\RestPaginateur\Entity\Pagination();
    }

    private function getKnpPagination(): PaginationInterface
    {
        $this->getMockGenerator()->orphanize('__construct');
        $mock = new \mock\Knp\Component\Pager\Pagination\PaginationInterface();
        $this->calling($mock)->getItems = [];
        $this->calling($mock)->getTotalItemCount = 100;

        return $mock;
    }
}