<?php

namespace RestPaginateur;

use RestPaginateur\DependencyInjection\RestPaginateurExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class RestPaginateurBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new RestPaginateurExtension();
    }
}

