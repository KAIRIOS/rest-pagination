<?php

namespace RestPaginateur;

use RestPaginateur\DependencyInjection\RestPaginateurExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class RestPaginateurBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new RestPaginateurExtension();
    }
}
