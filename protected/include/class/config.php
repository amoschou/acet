<?php

/*
  This class from Stack Overflow:
  http://stackoverflow.com/questions/2047264/use-of-pdo-in-classes
  and is attributed to Guillaume Boschini
  (http://stackoverflow.com/users/246248/guillaume-boschini)
  licenced under CC BY-SA 3.0 (http://creativecommons.org/licenses/by-sa/3.0/)
  with attribution required.
  This file is also distributed under the same license.
*/

class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}