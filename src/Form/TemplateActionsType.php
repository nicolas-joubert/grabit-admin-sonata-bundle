<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Form;

use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template-extends AbstractType<null>
 */
class TemplateActionsType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', ChoiceType::class, [
            'required' => false,
            'translation_domain' => 'GrabitSonataAdminBundleChoices',
            'choices' => [
                'template.type.auto' => null,
                'template.type.text' => 'text',
                'template.type.link' => 'link',
                'template.type.image' => 'image',
                'template.type.timestamp' => 'timestamp',
                'template.type.current_url' => 'current_url',
            ],
        ]);
        $builder->add('filter', TextType::class, ['required' => false]);
        $builder->add('extract', TextType::class, ['required' => false]);
        $builder->add('content', TextType::class, ['required' => false]);
        $builder->add('json', TextType::class, ['required' => false]);
        $builder->add('clean', TextType::class, ['required' => false]);
        if (isset($options['with_concat']) && $options['with_concat']) {
            $builder->add('concat', CollectionType::class, [
                'required' => false,
                'entry_type' => TemplateActionsType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => ['with_concat' => false],
            ]);
        }
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'with_concat' => true,
        ]);
    }
}
