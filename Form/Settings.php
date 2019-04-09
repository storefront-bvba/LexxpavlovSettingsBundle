<?php

namespace App\Application\Lexxpavlov\SettingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Application\Lexxpavlov\SettingsBundle\DBAL\SettingsType;
use App\Application\Lexxpavlov\SettingsBundle\Form\Type\SettingValueType;

class Settings extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $valueType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ? SettingValueType::class : 'setting_value';
        $builder->add('category', \App\Application\Lexxpavlov\SettingsBundle\Entity\Category::class, array(
            //'class' => 'LexxpavlovSettingsBundle:Category',
            'property' => 'name',
            //                'property_path' => 'name',
            'required' => false
        ));
        $builder->add('name', 'text');
        $builder->add('type', ChoiceType::class, array('choices' => SettingsType::getChoices()));
        $builder->add('value', $valueType);
        $builder->add('comment', 'textarea', array('required' => false));
        $builder->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Application\Lexxpavlov\SettingsBundle\Entity\Settings',
        ));
    }

    public function getName() {
        return 'lexxpavlov_settings';
    }
}
