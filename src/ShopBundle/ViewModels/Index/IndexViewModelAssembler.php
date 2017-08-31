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
            'Top',
            'New',
            'Category'
        );
    }

    public function generateViewModel($model1, $model2, $model3, $model4)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setProduct($model1);
        $vm->setLatest($model2);
        $vm->setTop($model3);
        $vm->setNew($model4);


        return $vm->toArray();
    }
}