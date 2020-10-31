<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

abstract class AbstractField
{
    public $ID_field;
    public $name;
    public $validation;
    public $value;
    public $error;
    public $send;

    public static $validations = [];


    public function __construct($name = '', $params = [])
    {

        $this->name = $name;
        $this->ID_field = $params['ID_field'];
        $this->validation = $params['validation'];
        $this->value = $params['value'];
        $this->send = $params['send'];
    }


    public static function registerValidation ($valueValidation, $funcValidation)
    {
        if (is_callable($funcValidation) && $valueValidation) {
            self::$validations[$valueValidation] = $funcValidation; // ключу коллекции валидации присвоена ССЫЛКА!!! на ф-цию
        }
    }

    // AbstractField::registerValidation;



    public function controlObject()
    {
        if ($this->validation) {
            $rezult = ( self::$validations[$this->validation] ) ($this->value); //
            if (!$rezult['isValid']) {
                $this->error = $rezult['massage'];
                return false;
            }
        }
        return true;
    }

    protected function displayError()
    {
        if ($this->error) {
            echo '<br />' . $this->error . '<br />';
        }
    }

    abstract function renderField();
    abstract function sendField();
}
//  при объявлении абстр.класса сразу заполнияется вся!!! коллекция !!!
require_once 'registerValidation.php';
//print_r(ModelField::$validations);

