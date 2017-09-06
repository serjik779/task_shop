<?php

namespace ShopBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetProductsCommand extends ContainerAwareCommand {

    public function configure() {
        $this
            ->setDefinition(array())
            ->setDescription('Add products and categories')
            ->setName('shop:product:update');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $logger = $this->getContainer()->get('logger');
        $logger->info('Adding information for products and categories');
        $product = $this->getContainer()->get('adding.product');
        $product->addProductAction();

    }

}
