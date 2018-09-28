<?php

namespace App\Enums;

abstract class BaseEnum
{
    private static $constCacheArray = null;
    private static $statusTexts = null;

    public static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    public static function getConstant($value)
    {
        return $value ?
            array_search($value, static::getConstants()) :
            null;
    }

    public static function getText($value)
    {
        return $value ?
            static::$statusTexts[$value] :
            null;
    }

    public static function toSelect($placeholder = '')
    {
            $keys = isset(static::$statusTexts) ? array_values(static::$statusTexts) : array_keys(static::getConstants());
            $values = array_values(static::getConstants());
            $result = array_combine($values, $keys);
            return $placeholder ? (['' => $placeholder] + $result) : $result;
    }
}