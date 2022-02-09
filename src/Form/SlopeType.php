<?php

namespace App\Form;

use App\Entity\Slope;
use App\Form\Type\OpeningDaysType;
use App\Form\Type\PriceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SlopeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class, ['required' => false])
            ->add('lat', NumberType::class, ['required' => false])
            ->add('lng', NumberType::class, ['required' => false])
            ->add('prices', PriceType::class, ['required' => false])
            ->add('homepage', TextType::class, ['required' => false])
            ->add('opening_hours', OpeningDaysType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slope::class,
        ]);
    }
}
