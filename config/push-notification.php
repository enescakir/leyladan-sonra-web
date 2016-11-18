<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'production',
        'certificate' => app_path() . '/LSPush.pem',
        'passPhrase'  =>'@Kaliforniya@',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);