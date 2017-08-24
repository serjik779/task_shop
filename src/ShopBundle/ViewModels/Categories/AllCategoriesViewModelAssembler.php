<?php
//src/ShopBundle/ViewModels/Categories/AllCategoriesViewModelAssembler.php

namespace ShopBundle\ViewModels\Categories;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;
use ShopBundle\Entity\Categories;
class AllCategoriesViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'pageTitle' => array(),
            'mails',
        );
    }

    public function generateViewModel($model)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setCategory($model);


        return $vm->toArray();
    }
}