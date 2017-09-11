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
            'Brands',
            'Slider'

        );
    }

    public function generateViewModel($slider, $latestproducts, $topsellers, $topnew, $brand)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setSlider($slider);
        $vm->setLatest($latestproducts);
        $vm->setTop($topnew);
        $vm->setNew($topsellers);
        $vm->setBrands($brand);



        return $vm->toArray();
    }
}