<?php

/*
 * Ce fichier est la propriété de TéléDiag
 */

namespace RestPaginateur\Entity\tests\units;

use atoum\atoum\test;

class Pagination extends test
{
    private $router;
    private $request;

    public function beforeTestMethod($testMethod)
    {
        $this->router = new \mock\Symfony\Component\Routing\RouterInterface();
        $this->calling($this->router)->generate = function ($route, $parametre) {
            return $route.'?'.implode('&', $parametre);
        };

        $this->getMockGenerator()->orphanize('__construct');
        $query = new \mock\Symfony\Component\HttpFoundation\ParameterBag();
        $this->calling($query)->all = function () {
            return [];
        };

        $this->getMockGenerator()->orphanize('__construct');
        $attributes = new \mock\Symfony\Component\HttpFoundation\ParameterBag();
        $this->calling($attributes)->get = function () {
            return [];
        };
        $this->getMockGenerator()->orphanize('__construct');
        $this->request = new \mock\Symfony\Component\HttpFoundation\Request();
        $this->request->query = $query;
        $this->request->attributes = $attributes;
        $this->calling($this->request)->get = function ($route) {
            return $route;
        };
    }

    public function testPagination(
        string $assert,
        array $elements,
        int $totalElements,
        int $page,
        int $elementsParPage,
        int $totalPage,
        int $firstIndex,
        int $lastIndex,
        array $links
    ) {
        $tested = $this->getTestedInstance($elements, $totalElements, $page, $elementsParPage);

        $this
        ->assert($assert)
        ->integer($tested->getTotalPage())->isEqualTo($totalPage)
        ->integer($tested->getFirstIndex())->isEqualTo($firstIndex)
        ->integer($tested->getLastIndex())->isEqualTo($lastIndex)
        ->array($tested->getLinks())->isEqualTo($links)
        ;
    }

    protected function testPaginationDataProvider()
    {
        $elements10 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $elements5 = [0, 1, 2, 3, 4];

        return [
            // $assert, $elements, $totalElements, $page, $elementsParPage, $totalPage, $firstIndex, $lastIndex, $links
            ['total 105 - page 1 - elements par page 10', $elements10, 105, 1, 10, 11, 1, 10, [
                '<_route?2>; rel="next"',
                '<_route?11>; rel="last"',
            ]],
            ['total 105 - page 2 - elements par page 10', $elements10, 105, 2, 10, 11, 11, 20, [
                '<_route?1>; rel="first"',
                '<_route?1>; rel="prev"',
                '<_route?3>; rel="next"',
                '<_route?11>; rel="last"',
            ]],
            ['total 105 - page 11 - elements par page 10', $elements5, 105, 11, 10, 11, 101, 105, [
                '<_route?1>; rel="first"',
                '<_route?10>; rel="prev"',
            ]],
        ];
    }

    private function getTestedInstance(
        array $elements,
        int $totalElements,
        int $page,
        int $elementsParPage
    ) {
        return $this->newTestedInstance(
            $this->router,
            $this->request,
            $elements,
            $totalElements,
            $page,
            $elementsParPage
        );
    }
}