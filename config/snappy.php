<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary'  => base_path('public/rendering-engine/wkhtmltopdf/bin/wkhtmltopdf.exe'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => base_path('public/rendering-engine/wkhtmltopdf/bin/wkhtmltoimage.exe'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
