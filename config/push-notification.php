<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' => app_path() . '/certificate.pem',
        'passPhrase'  =>'',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);