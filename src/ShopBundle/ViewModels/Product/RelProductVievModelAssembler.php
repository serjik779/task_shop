<?php
//src/ViewModels/Product/RelProductVievModelAssembler.php

namespace ShopBundle\ViewModels\Product;


use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class RelProductVievModelAssembler extends ViewModelAssembler
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

        $vm->setRelated($model);



        return $vm->toArray();
    }
}