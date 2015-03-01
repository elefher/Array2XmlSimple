<?php

/*
 * Copyright (C) 2015 elefher
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of Array2XmlSimple
 *
 * @author elefher
 */
class Array2XmlSimple {

    public static $xml, $currentTag, $parent;
    /*
     * 
     */
    static function buildXml($rootTag, $array) {
        self::$xml = new SimpleXMLElement('<'.$rootTag.'/>');
        foreach ($array as $key => $value) {
            self::chooseWhat($key, $value);
        }
    }

    static function chooseWhat($key, $value) {
        if (empty($key))
            throw new Exception("Tag value is empty");
        if (is_array($value)) {
            self::$currentTag = self::$parent = self::createTag(self::$xml, $key, $value);
            self::handleArray($value);
        } else {
            self::$parent = self::createTag(self::$xml, $key, $value);
        }
    }

    static function handleArray($array) {
        foreach ($array as $key => $value) {
            if ($key === "@attributes") {
                self::addAttr($value, self::$currentTag);
            } elseif (is_array($value)) {
                self::$currentTag = self::createTag(self::$parent, key($value), null);
                self::handleArray($value[key($value)]);
            } elseif ($key === "@value") {
                self::addValueTo(self::$currentTag, $value);
            } else {
                self::createTag(self::$currentTag, $key, $value);
            }
        }
    }

    static function addAttr($attributesArray, $tag) {
        foreach ($attributesArray as $key => $value) {
            $tag->addAttribute($key, $value);
        }
    }

    static function createTag($parentTag, $tagName, $value = null) {
        return $parentTag->addChild($tagName, is_null($value) || empty($value) || is_array($value) ? null : $value);
    }

    static function addValueTo($tag, $value) {
        $tag[0] = $value;
    }
    
    static function xmlExport($fileName = null){
        if(is_null($fileName))
            return self::$xml->asXml();
        return self::$xml->asXml($fileName);
    }
    
    static function getXml(){
        return self::$xml;
    }
}