<?php

namespace ShopBundle\ViewModels\Index;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class IndexViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Product',
            'Latest',
        );
    }

    public function generateViewModel($model1, $model2, $model3, $model4, $model5)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setProduct($model1);
        $vm->setLatest($model2);
        $vm->setTop($model3);
        $vm->setNew($model4);
        $vm->setCategory($model5);


        return $vm->toArray();
    }
}