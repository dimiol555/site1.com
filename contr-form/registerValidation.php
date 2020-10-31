<?php

use \classes\fields\AbstractField;




AbstractField::registerValidation ('not_empty',
    function ($val) {
        return [
            'isValid' => (bool)$val,
            'massage' => "Заполните поле  !!!"
        ];
    });

AbstractField::registerValidation ('email',
    function ($val) {
        return [
            'isValid' => filter_var($val, FILTER_VALIDATE_EMAIL),
            'massage' => "E-mail адрес указан неверно!!!"
        ];
    });

AbstractField::registerValidation ('selected',
    function ($val) {
        return [
            'isValid' => ($val != 'default'),
            'massage' => "Выберите значение!!!"
        ];
    });

AbstractField::registerValidation ('checked',
    function ($val) {
        return [
            'isValid' => (bool)$val,
            'massage' => "Выберите значение!!!"
        ];
    });

AbstractField::registerValidation ('mobile',
    function ($val) {
        $phone = preg_replace('/[^\d]/', '', $val);
        return [
            'isValid' => strlen($phone) === 10,
            'massage' => "Номер неправильно написан  !!!"
        ];
    });

