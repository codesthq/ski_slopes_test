<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OpeningDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Monday', OpeningHoursType::class)
            ->add('Tuesday', OpeningHoursType::class)
            ->add('Wednesday', OpeningHoursType::class)
            ->add('Thursday', OpeningHoursType::class)
            ->add('Friday', OpeningHoursType::class)
            ->add('Saturday', OpeningHoursType::class)
            ->add('Sunday', OpeningHoursType::class)
        ;
    }
}