<?php

return [

    'driver' => 'smtp',
    'host' => 'smtp.sendgrid.net',
    'pretend' => false,
    'port' => 587,
    'from' => array('address' => 'admin.support@support.vendpad.com', 'name' => 'Admin SIP'),
    'encryption' => 'tls',
    'username' => 'febripratama',
    'password' => 'admin123',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
