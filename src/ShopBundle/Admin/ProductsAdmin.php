<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;

use ShopBundle\Entity\Categories;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductsAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('category', EntityType::class, array(
                'class' => Categories::class
            ))
            ->add('title', TextType::class)
            ->add('description', SimpleFormatterType::class, array(
                'format' => 'richhtml', 'attr' => array(
                    'class' => 'ckeditor')
            ))
            ->add('cost', MoneyType::class)
            ->add('amount', NumberType::class)
            ->add('serviceId', NumberType::class)
            ->add('onMain', CheckboxType::class, array(
                'required' => false
            ))
            ->add('isVisible', CheckboxType::class)
            ->add('images', CollectionType::class, array(
                'by_reference' => false,
                'required' => false
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
        ;
            #->add('image', 'sonata_type_admin', array( 'label' => false, 'delete' => false ));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('category')
            ->add('title')
            ->add('cost')
            ->add('amount')
            ->add('serviceId');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('category')
            ->addIdentifier('title')
            ->addIdentifier('cost')
            ->addIdentifier('amount')
            ->addIdentifier('serviceId');
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('category')
            ->add('title')
            ->add('cost')
            ->add('amount')
            ->add('serviceId');
    }

    public function prePersist($product)
    {
        $this->manageEmbeddedImageAdmins($product);
    }

    public function preUpdate($product)
    {
        $this->manageEmbeddedImageAdmins($product);
    }

    private function manageEmbeddedImageAdmins($product)
    {
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            if ($fieldDescription->getType() === 'Sonata\CoreBundle\Form\Type\CollectionType' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'ShopBundle\Entity\Images'
            ) {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;
                if ($product->getImages()) {
                    foreach ($product->getImages() as $image) {
                        if ($image->getFile()) {
                            $image->refreshUpdated();
                        } elseif ((!$image->getFile()) && (!$image->getFilename())) {
                            $product->$setter(null);
                        }
                    }
                }
            }
        }
    }
}