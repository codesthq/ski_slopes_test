<?php

namespace App\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;

class IntToFloatTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        return (number_format(floatval($value / 10), 2));
    }

    public function reverseTransform(mixed $value)
    {
        return intval($value * 10);
    }
}