<?php


namespace ShopBundle\ViewModels\Product;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;
use ShopBundle\Entity\Products;
class ProductViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Product',
        );
    }
    public function generateViewModel($model)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setProduct($model);



        return $vm->toArray();
    }
}
