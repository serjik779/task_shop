<?php
//src/ShopBundle/ViewModels/Categories/CategoriesViewModelAssembler.php

namespace ShopBundle\ViewModels\Product;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class CategoriesViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Category'
        );
    }
    public function generateViewModel($model)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setCategory($model);


        return $vm->toArray();
    }
}