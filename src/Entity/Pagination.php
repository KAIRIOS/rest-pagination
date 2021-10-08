<?php

/*
 * Ce fichier est la propriété de Kairios
 */

namespace RestPaginateur\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class Pagination
{
    /** @var RouterInterface */
    private $router;

    /** @var Request */
    private $request;

    /** @var array */
    private $elements;

    /** @var int */
    private $totalElements;

    /** @var int */
    private $page;

    /** @var int */
    private $elementsParPage;

    public function __construct(
        RouterInterface $router,
        Request $request,
        array $elements,
        int $totalElements,
        int $page,
        int $elementsParPage
    ) {
        $this->router = $router;
        $this->request = $request;
        $this->elements = $elements;
        $this->totalElements = $totalElements;
        $this->page = $page;
        $this->elementsParPage = $elementsParPage;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function getTotalElements(): int
    {
        return $this->totalElements;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getElementsParPage(): int
    {
        return $this->elementsParPage;
    }

    public function getTotalPage(): int
    {
        if (0 < $this->getTotalElements()) {
            return ceil($this->getTotalElements() / $this->getElementsParPage());
        }

        return 0;
    }

    public function getFirstIndex(): int
    {
        return ($this->getPage() - 1) * $this->getElementsParPage() + 1;
    }

    public function getLastIndex(): int
    {
        return $this->getFirstIndex() + \count($this->elements) - 1;
    }

    public function getLinks(): array
    {
        $links = [];
        if ($this->getPage() > 1) {
            $links[] = $this->getLinkPage('first', 1);
            $links[] = $this->getLinkPage('prev', $this->getPage() - 1);
        }
        if ($this->getPage() < $this->getTotalPage()) {
            $links[] = $this->getLinkPage('next', $this->getPage() + 1);
            $links[] = $this->getLinkPage('last', $this->getTotalPage());
        }

        return $links;
    }

    private function getLinkPage(
        string $rel,
        int $page
    ): string {
        $parametres = $this->request->query->all();
        $parametres = array_merge($parametres, $this->request->attributes->get('_route_params'));

        $parametres['page'] = $page;

        $url = $this->router->generate($this->request->get('_route'), $parametres, RouterInterface::NETWORK_PATH);

        $link = '<'.$url.'>; rel="'.$rel.'"';

        return $link;
    }
}
