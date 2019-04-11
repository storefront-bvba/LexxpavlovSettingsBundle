<?php

namespace App\Application\Lexxpavlov\SettingsBundle\Twig;

use App\Application\Lexxpavlov\SettingsBundle\Service\Settings;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingsExtension extends AbstractExtension
{
    /** @var Settings */
    private $settings;

    /**
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getName()
    {
        return 'lexxpavlov_settings_extension';
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('setting', array($this, 'getSetting')),
            //new TwigFunction('settings_group', array($this, 'getSettingsGroup')),
        );
    }

    public function getSetting($name, $type = 'string', $comment = null, $defaultValue = null, $langCode = null)
    {
        return $this->settings->get($name, $type, $comment, $defaultValue, $langCode);
    }

//    public function getSettingsGroup($name)
//    {
//        return $this->settings->group($name);
//    }
}
