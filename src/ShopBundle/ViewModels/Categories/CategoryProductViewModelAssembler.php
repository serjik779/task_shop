<?php
//src/ViewModels/Categories/CategoryProductViewModelAssembler.php
namespace ShopBundle\ViewModels\Categories;


use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class CategoryProductViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Product'=> array(),

        );
    }
    public function generateViewModel($model)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setProduct($model);


        return $vm->toArray();
    }
}