<?php
/**
 * 数组工具
 * @author lvsijiang
 */

namespace App\Helper;


class ArrayHelper
{

    /**
     * 爆破去重去空，与原生的 explode 函数类似，但是额外提供去重去空的特性
     * @param string $var
     * @param array $config
     * @return array|string
     * @author lvsijiang
     */
    static function explode($var, $config = array()){
        static $defaultConfig = array(
            'separator'      => ',',         //分隔符
            'trim_charlist' => ',',         //需要去除的字符列表
            'trim_side'     => 'b',         //l 左边，r 右边， b(both) 左右两边
            'unique'        => TRUE,        //是否去重
            'sort_flags'    => SORT_REGULAR,//去重时的sort_flags
            'no_empty'      => TRUE,        //是否去空
        );
        $config = array_merge($defaultConfig, $config);
        if(is_string($var)){
            static $trimFuns = array('l' => 'ltrim', 'r' => 'rtrim', 'b' => 'trim');
            if(!$config['no_empty']){//不去空的话，从去除列表里面去掉分隔符
                $config['trim_charlist'] = str_replace($config['separator'], '', $config['trim_charlist']);
            }
            $var = explode($config['separator'], $trimFuns[$config['trim_side']]($var, $config['trim_charlist']));
        }
        if($config['unique']){
            $var = array_unique($var, $config['sort_flags']);
        }
        if($config['no_empty']){
            $var = array_filter($var);
        }
        return $var;
    }


    /**
     * 更改数组的键名
     * @param $indexKey
     * @param $array
     * @return array
     */
    static function keyBy($array, $indexKey){
        return array_column($array, NULL, $indexKey);
    }


    /**
     * 将数组按某个元素的值分组
     * @param $array
     * @param string $by 按哪个键名分组
     * @param string $indexKey 第二级数组的键名
     * @return array
     * @author lvsijiang
     */
    static function groupBy($array, $by, $indexKey=null){
        if(empty($array)) return $array;
        $return = array();
        if(is_null($indexKey)){
            foreach($array as $v)	$return[$v[$by]][] = $v;
        }else{
            foreach($array as $v)	$return[$v[$by]][$v[$indexKey]] = $v;
        }
        return $return;
    }


    /**
     * 所有元素转为字符串
     * @param array $array
     * @return array
     */
    public static function itemsToString(array $array){
        return array_map('strval', $array);
    }
}