<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

$form444 = [
    "f_name" => [
        'type' => 'Text',
        'placeholder' => 'Name',
        'validation' => 'not_empty',
        'value' => '',
        'error' => '',
        'send' => "From: "
    ],

    "subject" => [
        'type' => 'Text',
        'placeholder' => 'Subject',
        'validation' => 'not_empty',
        'value' => '',
        'error' => '',
        'send' => "Subject: "
    ],

    "mobile" => [
        'type' => 'Text',
        'placeholder' => 'Mobile',
        'validation' => 'mobile',
        'value' => '',
        'error' => '',
        'send' => "Mobile: "
    ],

    "email" => [
        'type' => 'Text',
        'placeholder' => 'E-mail',
        'validation' => 'email',
        'value' => '',
        'error' => '',
        'send' => "From e-mail: "
    ],

    "message" => [
        'type' => 'Textarea',
        'placeholder' => 'Message',
        'validation' => 'not_empty',
        'value' => '',
        'error' => '',
        'send' => "Message: "
    ],

    "select" => [
        'type' => 'Select',
        'size' => '',
        'validation' => 'selected',
        'option' => [
            'default' => 'Select City',
            'value1' => 'Харьков',
            'value2' => 'Киев',
            'value3' => 'Днепр',
        ],
        'value' => '',
        'error' => '',
        'send' => "City: "
    ],

    "checkbox" => [
        'type' => 'Checkbox',
        'validation' => 'checked',
        'variant' => [
            'value1' => 'Английский',
            'value2' => 'Немецкий',
            'value3' => 'Французский',
        ],
        'value' => '',
        'error' => '',
        'send' => "Languages: "
    ],

    "radio" => [
        'type' => 'Radio',
        'validation' => 'checked',
        'skill' => [
            'value1' => 'PHP+HTML',
            'value2' => 'PHP+HTML+CSS',
            'value3' => 'PHP',
        ],
        'value' => '',
        'error' => '',
        'send' => "Attainments: "
    ]
];




