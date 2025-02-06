<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractType<null>
 */
class TemplateConfigurationType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('container', TextType::class, ['required' => true]);
        $builder->add('contents', TemplateContentType::class, ['attr' => ['class' => 'col-sm-offset-1']]);
    }
}
