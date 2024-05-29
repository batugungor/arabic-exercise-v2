<?php

namespace App\Form;

use App\Entity\VariationTypes;
use App\Entity\Word;
use App\Entity\WordVariation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordVariationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('variation')
            ->add('word', EntityType::class, [
                'class' => Word::class,
                'choice_label' => 'word',
                'disabled' => true
            ])
            ->add('variationType', EntityType::class, [
                'class' => VariationTypes::class,
                'choice_label' => 'name',
            ])
            ->add('commentary')
            ->add('save', SubmitType::class, ['label' => 'Save'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WordVariation::class,
        ]);
    }
}
