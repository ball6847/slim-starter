<?php
namespace Library;

trait EntityHelper
{
    public function fromArray($array)
    {
        if (isset($array['id'])) {
            unset($array['id']);
        }

        foreach ($this->toArray() as $key => $value) {
            if (isset($array[$key])) {
                $this->$key = $array[$key];
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public static function collectionToArray($collection)
    {
        return array_map(function($item) {
            return $item->toArray();
        }, $collection);
    }
}
