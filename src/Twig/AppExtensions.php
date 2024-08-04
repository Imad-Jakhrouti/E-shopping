<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension
{
    public function getFilters(): array{
        return [
            new TwigFilter('formatPrice', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($price){
        return number_format($price, 0, '', ' '). 'DH' ;
    }
}