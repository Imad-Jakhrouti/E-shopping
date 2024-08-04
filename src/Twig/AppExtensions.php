<?php
namespace App\Twig;

use App\Class\Cart;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface {
    private $categoryRepository ;

    public function __construct(CategoryRepository $categoryRepository ) {
        $this->categoryRepository = $categoryRepository;
    }
    public function getFilters(): array{
        return [
            new TwigFilter('formatPrice', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($price){
        return number_format($price, 0, '', ' '). 'DH' ;
    }

    public function getGlobals(): array
    {
        return [
            'allCategory' => $this->categoryRepository->findAll(),
        ];
    }
}