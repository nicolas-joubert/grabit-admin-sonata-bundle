<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractType<null>
 */
class SourceHeadersType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', TextType::class, ['required' => true, 'row_attr' => ['class' => 'col-xs-3']]);
        $builder->add('content', TextType::class, ['required' => true, 'row_attr' => ['class' => 'col-xs-9']]);
    }
}
