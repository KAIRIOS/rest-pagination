<?php

/*
 * Ce fichier est la propriété de TéléDiag
 */

namespace RestPaginateur\Factory\tests\units;

use atoum\atoum\test;
use RestPaginateur\Entity\Pagination;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactory extends test
{
    private $router;

    public function beforeTestMethod($testMethod)
    {
        $this->router = new \mock\Symfony\Component\Routing\RouterInterface();
        $this->calling($this->router)->generate = function ($route, $parametre) {
            return $route.'?'.implode('&', $parametre);
        };
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance(
            $this->router
        );
    }

    public function testCreer(): void
    {
        $this
        ->given(
            $request = $this->getRequest(),
            $elements = [51, 52, 53],
            $totalElements = 53,
            $page = 5,
            $elementsParPage = 10,
            $tested = $this->getTestedInstance()
        )
        ->object($pagination = $tested->creer($request, $elements, $totalElements, $page, $elementsParPage))
            ->isInstanceOf(Pagination::class)
        ;
    }

    private function getRequest(): Request
    {
        $this->getMockGenerator()->orphanize('__construct');
        $mock = new \mock\Symfony\Component\HttpFoundation\Request();
        $this->calling($mock)->get = 5;

        return $mock;
    }
}