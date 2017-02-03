<?php
// src/AppBundle/Admin/ImageAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Image;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array(
                'required' => false,
                'multiple' => true,
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('filename','file');
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload(Image $image)
    {

        if ($image->getFile()) {
            $image->refreshUpdated();
        }
        $image->lifecycleFileUpload();
    }

    // ...
}