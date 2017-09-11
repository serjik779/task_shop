<?php
//src/ViewModels/Product/RelProductVievModelAssembler.php

namespace ShopBundle\ViewModels\Product;


use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

class RelProductVievModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'Related',
        );
    }

    public function generateViewModel($relproduct)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setRelated($relproduct);



        return $vm->toArray();
    }
}