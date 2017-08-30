<?php

namespace ShopBundle\ViewModels\Index;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class IndexViewModelAssembler extends ViewModelAssembler
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