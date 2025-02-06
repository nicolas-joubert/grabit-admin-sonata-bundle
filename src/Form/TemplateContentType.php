<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractType<null>
 */
class TemplateContentType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('unique', TemplateActionsType::class, ['attr' => ['class' => 'col-sm-offset-1']]);
        $builder->add('title', TemplateActionsType::class, ['attr' => ['class' => 'col-sm-offset-1']]);
        $builder->add('description', TemplateActionsType::class, ['attr' => ['class' => 'col-sm-offset-1']]);
        $builder->add('link', TemplateActionsType::class, ['attr' => ['class' => 'col-sm-offset-1']]);
        $builder->add('publicationDate', TemplateActionsType::class, ['required' => false, 'attr' => ['class' => 'col-sm-offset-1']]);
        $builder->add('image', TemplateActionsType::class, ['required' => false, 'attr' => ['class' => 'col-sm-offset-1']]);
    }
}
