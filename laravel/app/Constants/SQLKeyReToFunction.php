<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 下午4:34
 */
namespace App\Constants;
class  SQLKeyReToFunction
{
    const STR_IN            = ' in';
    const STR_NOT_IN        = ' not in';
    const STR_BETWEEN       = ' between';
    const STR_NOT_BETWEEN   = ' not between';
    const STR_EQUAL         = ' =';
    const STR_NOT_EQUAL_1   = ' !=';
    const STR_NOT_EQUAL_2   = ' <>';
    const STR_GREATER_EQUAL = ' >=';
    const STR_LESS_EQUAL    = ' <=';
    const STR_GREATER       = ' >';
    const STR_LESS          = ' <';
    const STR_IS_NULL       = ' is null';
    const STR_LIKE          = ' like';


    static public $strToWhereFunctionForArray = array(
        self::STR_NOT_IN      => 'whereNotIn',
        self::STR_IN          => 'whereIn',

        self::STR_NOT_BETWEEN => 'whereNotBetween',
        self::STR_BETWEEN     => 'whereBetween',
    );

    static public $strToWhereFunctionForNormal = array(
        self::STR_EQUAL         => 'where',
        self::STR_NOT_EQUAL_1   => 'where',
        self::STR_NOT_EQUAL_2   => 'where',
        self::STR_GREATER_EQUAL => 'where',
        self::STR_GREATER       => 'where',
        self::STR_LESS_EQUAL    => 'where',
        self::STR_LESS          => 'where',
        self::STR_IS_NULL       => 'whereNull',
        self::STR_LIKE          =>  'where'
    );
}