<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GrabitAdminSonataBundle extends Bundle
{
    #[\Override]
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
