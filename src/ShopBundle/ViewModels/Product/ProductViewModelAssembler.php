<?php


namespace ShopBundle\ViewModels\Product;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;
use ShopBundle\Entity\Products;
class ProductViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Products'=> array(),
            'Categories' => array(),
        );
    }
    public function generateViewModel($model1, $model2)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setProduct($model1);
        $vm->setCategory($model2);


        return $vm->toArray();
    }
}
