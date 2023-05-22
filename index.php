<?php 
$sms_send = new App\Http\Controllers\SmsController("Hello Sohel vai , test message from Droptienda!", []);
$sms_send->processSendSms();