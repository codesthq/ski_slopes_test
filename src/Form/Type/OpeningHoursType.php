<?php

namespace App\Form\Type;

use App\Form\DataTransformer\StringToTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DataTransformerChain;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class OpeningHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', TimeType::class, ['widget' => 'single_text'])
            ->add('to', TimeType::class, ['widget' => 'single_text'])
        ;

        $builder->get('from')->addModelTransformer(new StringToTimeTransformer());
        $builder->get('to')->addModelTransformer(new StringToTimeTransformer());
    }
}