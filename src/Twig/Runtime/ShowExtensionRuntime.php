<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ShowExtensionRuntime implements RuntimeExtensionInterface
{
    public function printR(mixed $value): string
    {
        return print_r($value, true);
    }
}
