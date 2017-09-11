<?php


namespace ShopBundle\ViewModels\Product;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class ProductViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Product',
        );
    }

    public function generateViewModel($categoryiterms)
    {
        $vm = $this->vmService->createViewModel();
        $vm->setProduct($categoryiterms);

        return $vm->toArray();
    }
}
