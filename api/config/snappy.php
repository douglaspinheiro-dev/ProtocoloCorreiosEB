<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => $_ENV["CAMINHO_PDF"],
        // 'binary'  => '/usr/local/bin/wkhtmltopdf',
        // 'binary'  => "\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"",
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
