<?php

namespace Lexxpavlov\SettingsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\DBAL\Types\Type as DoctrineType;
use Lexxpavlov\SettingsBundle\DBAL\SettingsType;

class LexxpavlovSettingsBundle extends Bundle {
    public function boot() {
        if (!DoctrineType::hasType(SettingsType::NAME)) {
            DoctrineType::addType(SettingsType::NAME, SettingsType::class);
        }
    }
}
