<?php

namespace App\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;

class StringToTimeTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp(0);

        if ($value) {
            $timeArr = explode(':', $value);
            $dateTime->setTime($timeArr[0], $timeArr[1]);
        }

        return $dateTime;
    }

    public function reverseTransform(mixed $value)
    {
        return $value->format('H:i');
    }
}