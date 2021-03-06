<?php

namespace Lexxpavlov\SettingsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;

use Lexxpavlov\SettingsBundle\DBAL\SettingsType;
use Lexxpavlov\SettingsBundle\Entity\Settings;
use Lexxpavlov\SettingsBundle\Entity\Category;
use Lexxpavlov\SettingsBundle\Form\Type\SettingValueType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SettingsAdmin extends AbstractAdmin {
    /**
     * @var \Lexxpavlov\SettingsBundle\Service\Settings
     */
    private $settingsService;

    public function __construct($code, $class, $baseControllerName, \Lexxpavlov\SettingsBundle\Service\Settings $settingsService) {
        parent::__construct($code, $class, $baseControllerName);
        $this->settingsService = $settingsService;
    }

    public function configureListFields(ListMapper $listMapper) {
//        $useCategoryComment = $this->getConfigurationPool()->getContainer()->getParameter('lexxpavlov_settings.use_category_comment');

        $listMapper->addIdentifier('name');
//        $listMapper->add('category', null, array(
//            'associated_property' => function (Category $cat) use ($useCategoryComment) {
//                return $useCategoryComment && $cat->getComment() ? $cat->getComment() : $cat->getName();
//            },
//            'sortable' => true,
//            'sort_field_mapping' => array('fieldName' => 'name'),
//            'sort_parent_association_mappings' => array(array('fieldName' => 'category'))
//        ));
        $listMapper->add('type', ChoiceType::class, array(
            'choices' => SettingsType::getReadableValues(),
            'catalogue' => 'messages'
        ));
        $listMapper->add('value', null, array('template' => 'LexxpavlovSettingsBundle:Admin:list_value.html.twig'));
        $listMapper->add('comment');
    }

    public function configureFormFields(FormMapper $formMapper) {
        $valueType = $this->isNewForm() ? SettingValueType::class : 'setting_value';
        $formMapper->add('name');
        //$formMapper->add('category', ModelAutocompleteType::class, ['property' => 'name']);
        $formMapper->add('type', ChoiceType::class, array(
            'choices' => SettingsType::getChoices(),
            'attr' => array('data-sonata-select2' => 'false')
        ));
        $formMapper->add('value', $valueType)->add('comment');
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper) {
//        $useCategoryComment = $this->getConfigurationPool()->getContainer()->getParameter('lexxpavlov_settings.use_category_comment');
//
//        $categoryOptions = $this->isNewForm() ? array(
//            'choice_label' => function (Category $cat) use ($useCategoryComment) {
//                return $useCategoryComment && $cat->getComment() ? $cat->getComment() : $cat->getName();
//            },
//        ) : array();
//        $datagridMapper->add('category', null, array(), null, $categoryOptions)->add('name')->add('type', null, array(), ChoiceType::class, array('choices' => SettingsType::getChoices()));
    }

    public function configureShowFields(ShowMapper $showMapper) {
        $showMapper->add('name')->add('type')->add('value')->add('comment');
    }

    /**
     * @param Settings $object
     */
    public function postPersist($object) {
        $this->clearCache($object);
    }

    /**
     * @param Settings $object
     */
    public function postUpdate($object) {
        $this->clearCache($object);
    }

    /**
     * @param Settings $object
     */
    public function preRemove($object) {
        $this->clearCache($object);
    }

    public function getFormTheme() {
        return array_merge(parent::getFormTheme(), array('LexxpavlovSettingsBundle:Form:setting_value_edit.html.twig'));
    }

    /**
     * @param Settings $object
     */
    private function clearCache(Settings $object) {
        $this->settingsService->clearCache($object->getName());
        if ($object->getCategory()) {
            $this->settingsService->clearGroupCache($object->getCategory()->getName());
        }
    }

    /**
     * @return bool
     */
    protected function isNewForm() {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }
}
