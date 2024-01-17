<?/***API***/
$jurl='http://'.$_SERVER['HTTP_HOST']._path.$lg.'/API.json';
$sendNoti=1;
$complStatus=['جديد','تم الاطلاع','جار المتابعة ','منتهي'];
$complActionsStatus=[
    1=>'الإطلاع على الشكوى',
    2=>'اختيار المتابع',
    3=>'إجراء',
    4=>'إغلاق الشكوى',
    5=>'',
    6=>'',
    7=>'',
    8=>'',
    9=>'',    
];
$payData=[
    'url'=>'https://egate-t.fatora.me/api/create-payment', 
    'url_status'=>'https://egate-t.fatora.me/api/get-payment-status/',       
    'user'=>'dummar',
    'pass'=>'dummar@center#123',
    'tid'=>'14740016',
    'pay_opr_url'=>'https://'.$_SERVER['HTTP_HOST']._path.$lg.'/Payments-Page/',
    //'tid'=>'14740026',
    //'range'=>'9110016130204872',
    //'exp'=>'3-26'
];
$mtnPayData=[
    'tokenURL'=>'https://services.mtnsyr.com:2021/authenticateMerchant', 
    'creatOTP_URL'=>'https://services.mtnsyr.com:2021/paymentRequestInit', 
    'doPayment_URL'=>'https://services.mtnsyr.com:2021/doPayment',
    'userName'=>'test_usr',
    'password'=>'testUSR23MTN@',
    'merchantGSM'=>'963944222963',
    'testMood'=>'1',    
];


?>
