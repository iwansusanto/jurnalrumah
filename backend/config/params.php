<?php
return [
    'adminEmail' => 'admin@example.com',
    'appname'   =>  'JurnalRumah',
    'salt'  =>  'labalabapenjagagua',
    'pathUpload'   =>  'E:\wamp\www\jurnalrumah\frontend\web\general',
    'pathImageSlider' =>  '/images/slider/',
    'pathImageArtikel' =>  '/images/artikel/',
    'pathImageUser' =>  '/images/user/',
    'urlGeneral'    =>  '/jurnalrumah/frontend/web/general',
    'urlImageSlider'    =>  '/images/slider/', // tidak di pakai
    'urlNoImage'    =>  '/noimages/no-preview.jpg',
    'pageSizeGrid'  =>  10,
    'maskMoneyOptions' => [
        'prefix' => 'Rp ',
        'suffix' => '',
        'affixesStay' => true,
        'thousands' => '.',
        'decimal' => ',',
        'precision' => 2, 
        'allowZero' => false,
        'allowNegative' => false,
    ]
];
