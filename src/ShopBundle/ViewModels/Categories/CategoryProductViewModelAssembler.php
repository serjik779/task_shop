<?php
//src/ViewModels/Categories/CategoryProductViewModelAssembler.php
namespace ShopBundle\ViewModels\Categories;


use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class CategoryProductViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'ProdCat'=> array(),
            'Category'=> array(),

        );
    }
    public function generateViewModel($model1, $model2)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setCategory($model1);
        $vm->setProdCat($model2);


        return $vm->toArray();
    }
}