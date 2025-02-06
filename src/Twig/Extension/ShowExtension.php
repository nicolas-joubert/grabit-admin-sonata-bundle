<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Twig\Extension;

use NicolasJoubert\GrabitAdminSonataBundle\Twig\Runtime\ShowExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ShowExtension extends AbstractExtension
{
    #[\Override]
    public function getFilters(): array
    {
        return [
            new TwigFilter('print_r', [ShowExtensionRuntime::class, 'printR']),
        ];
    }
}
