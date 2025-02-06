<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Admin;

use NicolasJoubert\GrabitBundle\Model\ExtractedDataInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @phpstan-template T of ExtractedDataInterface
 *
 * @phpstan-extends AbstractAdmin<T>
 */
final class ExtractedDataAdmin extends AbstractAdmin
{
    #[\Override]
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    #[\Override]
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_BY] = 'id';
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
    }

    #[\Override]
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('uniqueContentId', null, ['show_filter' => true])
            ->add('source')
            ->add('publishedAt')
            ->add('createdAt')
        ;
    }

    #[\Override]
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('uniqueContentId')
            ->add('source')
            ->add('content.title')
            ->add('publishedAt')
            ->add('createdAt')
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
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('uniqueContentId')
            ->add('content', null, ['template' => '@GrabitAdminSonata/Admin/ExtractedData/show_content.html.twig'])
            ->add('publishedAt')
            ->add('createdAt')
        ;
    }
}
