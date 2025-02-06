<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Admin;

use NicolasJoubert\GrabitFrontFeedBundle\Model\FeedInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @phpstan-template T of FeedInterface
 *
 * @phpstan-extends AbstractAdmin<T>
 */
final class FeedAdmin extends AbstractAdmin
{
    #[\Override]
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('title', null, ['show_filter' => true])
            ->add('slug')
        ;
    }

    #[\Override]
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('title')
            ->add('slug', null, ['template' => '@GrabitAdminSonata/Admin/Feed/list_slug_to_link.html.twig'])
            ->add('description')
            ->add('itemsPerPage')
            ->add('sources')
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
            ->add('title')
            ->add('slug')
            ->add('description')
            ->add('itemsPerPage')
            ->add('sources', null, ['by_reference' => false])
        ;
    }

    #[\Override]
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('title')
            ->add('slug', null, ['template' => '@GrabitAdminSonata/Admin/Feed/show_slug_to_link.html.twig'])
            ->add('description')
            ->add('itemsPerPage')
            ->add('sources')
        ;
    }
}
