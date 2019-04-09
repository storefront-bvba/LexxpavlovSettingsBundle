<?php

namespace App\Application\Lexxpavlov\SettingsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use App\Application\Lexxpavlov\SettingsBundle\Entity\Category;

class CategoryAdmin extends AbstractAdmin
{
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('comment')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('comment')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('comment')
        ;
    }

    /**
     * @param Category $object
     */
    public function postPersist($object)
    {
        $this->clearCache($object);
    }

    /**
     * @param Category $object
     */
    public function postUpdate($object)
    {
        $this->clearCache($object);
    }

    /**
     * @param Category $object
     */
    public function preRemove($object)
    {
        $this->clearCache($object);
    }

    /**
     * @param Category $object
     */
    private function clearCache(Category $object)
    {

        // TODO fix this. Causes error: The "lexxpavlov_settings.settings" service or alias has been removed or inlined when the container was compiled. You should either make it public, or stop using the container directly and use dependency injection instead.

        /** @var \Lexxpavlov\SettingsBundle\Service\Settings $settings */
//        $settings = $this->getConfigurationPool()->getContainer()->get('lexxpavlov_settings.settings');
//        $settings->clearGroupCache($object->getName());
    }
}
