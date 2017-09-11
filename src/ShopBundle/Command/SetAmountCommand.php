<?php

namespace ShopBundle\Command;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetAmountCommand extends ContainerAwareCommand {

    public function configure() {
        $this
            ->setDefinition(array())
            ->setDescription('Add products and categories')
            ->setName('shop:product:setamount');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $logger = $this->getContainer()->get('logger');
        $logger->info('Set amount for products');
        $product = $this->getContainer()->get('adding.product');
        $product->setCount();

    }
}
