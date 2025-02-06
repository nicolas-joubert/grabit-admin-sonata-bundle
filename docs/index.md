# Documentation

## Installation

Open a command console, enter your project directory and install it using composer:

```bash
composer require nicolas-joubert/grabit-admin-sonata-bundle
```

Remember to add the following line to `config/bundles.php` (not required if Symfony Flex is used)

```php
// config/bundles.php

return [
    // ...
    Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
    Sonata\Form\Bridge\Symfony\SonataFormBundle::class => ['all' => true],
    Sonata\Exporter\Bridge\Symfony\SonataExporterBundle::class => ['all' => true],
    Symfony\UX\StimulusBundle\StimulusBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Sonata\Twig\Bridge\Symfony\SonataTwigBundle::class => ['all' => true],
    Sonata\Doctrine\Bridge\Symfony\SonataDoctrineBundle::class => ['all' => true],
    Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
    Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
    Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle::class => ['all' => true],
    NicolasJoubert\GrabitAdminSonataBundle\GrabitAdminSonataBundle::class => ['all' => true],
];
```

## Configuration

### SonataAdmin Configuration

Please follow [Configure guide](https://docs.sonata-project.org/projects/SonataAdminBundle/en/4.x/getting_started/installation/#configure-the-installed-bundles)

Finally, go to admin pages `/admin`.
