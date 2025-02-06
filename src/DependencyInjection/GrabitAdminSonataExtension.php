<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class GrabitAdminSonataExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array<mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/../config'));
        $loader->load('services.yaml');

        /** @var array<string> $bundles */
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['GrabitFrontFeedBundle'])) {
            $container->removeDefinition('grabit_sonata_admin.admin.configuration.feed');
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('sonata_admin', [
            'title' => 'Grabit Admin',
            'title_logo' => 'bundles/grabitadminsonata/assets/logo.jpg',
            'show_mosaic_button' => false,
        ]);
    }
}
