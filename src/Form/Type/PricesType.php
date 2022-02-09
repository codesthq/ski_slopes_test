<?php

namespace App\Form\Type;

use App\Form\DataTransformer\IntToFloatTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('1_hour', MoneyType::class)
            ->add('3_hours', MoneyType::class)
            ->add('6_hours', MoneyType::class)
        ;

        $builder->get('1_hour')->addModelTransformer(new IntToFloatTransformer());
        $builder->get('3_hours')->addModelTransformer(new IntToFloatTransformer());
        $builder->get('6_hours')->addModelTransformer(new IntToFloatTransformer());
    }
}