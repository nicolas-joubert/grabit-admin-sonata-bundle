<?php

declare(strict_types=1);

namespace NicolasJoubert\GrabitAdminSonataBundle\Admin;

use NicolasJoubert\GrabitAdminSonataBundle\Form\SourceHeadersType;
use NicolasJoubert\GrabitBundle\Grabber\Template;
use NicolasJoubert\GrabitBundle\Model\Enum\SourceProxy;
use NicolasJoubert\GrabitBundle\Model\Enum\SourceResultFormat;
use NicolasJoubert\GrabitBundle\Model\SourceInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * @phpstan-template T of SourceInterface
 *
 * @phpstan-extends AbstractAdmin<T>
 */
final class SourceAdmin extends AbstractAdmin
{
    private Template $template;

    public function addServices(Template $template): void
    {
        $this->template = $template;
    }

    #[\Override]
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add(
                'grab',
                $this->getRouterIdParameter().'/grab',
                ['_controller' => 'grabit_sonata_admin.controller.admin.source_controller::grab']
            )
        ;
    }

    #[\Override]
    protected function configureActionButtons(array $buttonList, string $action, ?object $object = null): array
    {
        $buttonList['grab'] = ['template' => '@GrabitAdminSonata/Admin/Source/grab_button.html.twig'];

        return $buttonList;
    }

    #[\Override]
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('label', null, ['show_filter' => true])
            ->add('template', null, [
                'field_type' => ChoiceType::class,
                'field_options' => array_merge(
                    $this->getTemplateChoicesConfiguration(),
                    ['multiple' => false]
                ),
            ])
            ->add('proxy')
            ->add('enabled')
        ;
    }

    #[\Override]
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('label')
            ->add('urls', null, ['template' => '@GrabitAdminSonata/Admin/Source/list_urls.html.twig'])
            ->add(
                'template',
                FieldDescriptionInterface::TYPE_CHOICE,
                $this->getTemplateChoicesConfiguration(false)
            )
            ->add('proxy', null, ['template' => '@GrabitAdminSonata/Admin/list_trans.html.twig'])
            ->add('enabled')
            ->add('feeds')
            ->add('extractedDataCount')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'grab' => [
                        'template' => '@GrabitAdminSonata/Admin/Source/list__action_grab.html.twig',
                    ],
                ],
            ])
        ;
    }

    #[\Override]
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('label')
            ->add('urls', CollectionType::class, [
                'entry_type' => UrlType::class,
                'entry_options' => [
                    'default_protocol' => 'https',
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('headers', CollectionType::class, [
                'entry_type' => SourceHeadersType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('template', ChoiceFieldMaskType::class, array_merge(
                $this->getTemplateChoicesConfiguration(),
                ['placeholder' => ''],
            ))
            ->add('resultFormat', EnumType::class, ['class' => SourceResultFormat::class])
            ->add('proxy', EnumType::class, ['class' => SourceProxy::class])
            ->add('stopOnLastUniqueContentId')
            ->add('enabled')
            ->add('maxNumberError')
            ->add('feeds', null, ['by_reference' => false])
        ;
    }

    #[\Override]
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('label')
            ->add('urls', null, ['template' => '@GrabitAdminSonata/Admin/Source/show_urls.html.twig'])
            ->add('headers')
            ->add(
                'template',
                FieldDescriptionInterface::TYPE_CHOICE,
                $this->getTemplateChoicesConfiguration(false)
            )
            ->add('resultFormat')
            ->add('proxy', null, ['template' => '@GrabitAdminSonata/Admin/show_trans.html.twig'])
            ->add('stopOnLastUniqueContentId')
            ->add('enabled')
            ->add('maxNumberError')
            ->add('countError')
            ->add('lastError', null, ['template' => '@GrabitAdminSonata/Admin/Source/show_lastError.html.twig'])
            ->add('feeds')
            ->add('extractedDatas')
        ;
    }

    #[\Override]
    protected function configureBatchActions(array $actions): array
    {
        if ($this->hasRoute('edit') && $this->hasAccess('edit')) {
            $actions['enable'] = [
                'ask_confirmation' => false,
                'controller' => 'grabit_sonata_admin.controller.admin.source_controller::batchEnable',
            ];
        }

        return $actions;
    }

    /**
     * @return array{'choices': array<string, string>, 'choice_translation_domain': string}
     */
    private function getTemplateChoicesConfiguration(bool $flip = true): array
    {
        $choices = $this->template->getTemplateChoices();

        return [
            'choices' => $flip ? array_flip($choices) : $choices,
            'choice_translation_domain' => 'GrabitSonataAdminBundleChoices',
        ];
    }
}
