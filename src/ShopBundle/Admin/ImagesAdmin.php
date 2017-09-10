<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImagesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $class = strpos(get_class($image), 'ShopBundle\\Entity\\Images');
        if ($image && is_numeric($class)) {
            // get the container so the full path to the image can be set
            $imagePath = $image->getPath();
            $container = $this->getConfigurationPool()->getContainer();

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img style="width:200px;border:1px solid;" src="'.$imagePath.'" class="admin-preview" />';


        } elseif (is_array($image)) {
            foreach ($image as $im) {
                $webPath = $im->getWebPath();
                $container = $this->getConfigurationPool()->getContainer();
                $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;

                // add a 'help' option containing the preview's img tag
                $fileFieldOptions['help'] = '<img style="width:200px;border:1px solid;" src="'.$fullPath.'" class="admin-preview" />';
            }
        }
        $fileFieldOptions['required'] = true;

        $formMapper
            ->add('file', FileType::class, $fileFieldOptions);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('filename');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('filename');
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('filename');
    }

    public function prePersist($images)
    {
        $this->manageFileUpload($images);
    }

    public function preUpdate($images)
    {
        $this->manageFileUpload($images);
    }

    private function manageFileUpload($images)
    {
        if ($images->getFile()) {
            $images->refreshUpdated();
        }
    }

}