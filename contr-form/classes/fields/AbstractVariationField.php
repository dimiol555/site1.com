<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

abstract class AbstractVariationField extends AbstractField
{
    public $variants;

    public function __construct($name = '', $params = [])
    {
        parent::__construct($name, $params);
        $this->variants = json_decode($params['options'],true);
    }

}