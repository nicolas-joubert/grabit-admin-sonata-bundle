<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Admin;

use NicolasJoubert\GrabitAdminSonataBundle\Form\TemplateConfigurationType;
use NicolasJoubert\GrabitBundle\Model\TemplateInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @phpstan-template T of TemplateInterface
 *
 * @phpstan-extends AbstractAdmin<T>
 */
final class TemplateAdmin extends AbstractAdmin
{
    #[\Override]
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('code')
            ->add('label', null, ['show_filter' => true])
        ;
    }

    #[\Override]
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('code')
            ->add('label')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    #[\Override]
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('code')
            ->add('label')
            ->add('configuration', TemplateConfigurationType::class, [
                'attr' => ['class' => 'col-sm-offset-1'],
            ])
        ;
    }

    #[\Override]
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code')
            ->add('label')
            ->add('configuration')
        ;
    }
}
