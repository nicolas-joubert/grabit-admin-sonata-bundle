<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Admin;

use NicolasJoubert\GrabitAdminSonataBundle\Form\TemplateConfigurationType;
use NicolasJoubert\GrabitBundle\Model\TemplateInterface;
use NicolasJoubert\GrabitBundle\Repository\SourceRepositoryInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @phpstan-template T of TemplateInterface
 *
 * @phpstan-extends AbstractAdmin<T>
 */
final class TemplateAdmin extends AbstractAdmin
{
    private SourceRepositoryInterface $sourceRepository;

    public function addServices(SourceRepositoryInterface $sourceRepository): void
    {
        $this->sourceRepository = $sourceRepository;
    }

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
            ->add('sources', FieldDescriptionInterface::TYPE_ONE_TO_MANY, [
                // @phpstan-ignore method.notFound
                'accessor' => fn (TemplateInterface $subject) => $this->sourceRepository->findByTemplate($subject->getCode()),
            ])
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
            ->add('sources', FieldDescriptionInterface::TYPE_ONE_TO_MANY, [
                // @phpstan-ignore method.notFound
                'accessor' => fn (TemplateInterface $subject) => $this->sourceRepository->findByTemplate($subject->getCode()),
                'associationAdmin' => 'test',
            ])
            ->add('configuration')
        ;
    }
}
