<?php

namespace App\Application\Lexxpavlov\SettingsBundle\DBAL;

//use App\Application\Sonata\AdminBundle\DBAL\EnumType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class SettingsType extends Type {

    public const NAME = 'LexxpavlovSettingsEnumType';

    public const Boolean = 'boolean';
    public const Integer = 'int';
    public const Float = 'float';
    public const String = 'string';
    public const Text = 'text';
    public const Html = 'html';


    public static function getAvailableTypes(): array {
        return [
            self::Boolean,
            self::Integer,
            self::Float,
            self::String,
            self::Text,
            self::Html
        ];
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        $r = $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
        return $r;

    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName() {
        return self::NAME;
    }

    /**
     * Get array of ENUM Values, where ENUM values are keys and their readable versions are values.
     *
     * @static
     *
     * @return array Array of values with readable format
     */
    public static function getReadableValues(): array {
        return [
            self::Boolean => 'Boolean',
            self::Integer => 'Integer',
            self::Float => 'Float',
            self::String => 'String',
            self::Text => 'Text',
            self::Html => 'Html'
        ];
    }
}
