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
            $request = $this->getRequest(),
            $target = [1, 2, 3],
            $nombreParPage = 10,
            $tested = $this->getTestedInstance()
        )
        ->object($tested->paginer($request, $target, $nombreParPage))
            ->isInstanceOf(Pagination::class)
        ->mock($this->paginator)->call('paginate')->once()
        ->mock($this->paginationFactory)->call('creer')->once()
        ;
    }

    private function getRequest(): Request
    {
        $this->getMockGenerator()->orphanize('__construct');
        $mock = new \mock\Symfony\Component\HttpFoundation\Request();
        $this->calling($mock)->get = 5;

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