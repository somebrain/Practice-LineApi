<!DOCTYE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='ja' xml:lang='ja'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta name='viewport' content='width=device-width,inital-scale=1.0,user-scalable=no' />
<link rel=stylesheet type="text/css" href="style.css">
<title>LINE Loginサンプル</title>
</head>
<body>
<div class='all'>
<div class='main'>
<p>下のボタンをタップしてログインしてください</p>
<?php

require_once __DIR__ . '/vendor/autoload.php';



$session_factory = new \Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);

$segment = $session->getSegment('Vendor\Package\ClassName');

$csrf_valu = $session->getCsrfToken()->getValue();

$callback = urlencode('https://' . $_SEVER['HTTP_HOST'] . '/line_callback.php');

$url = 'https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id=' . getenv('LOGIN_CHANNEL_ID') . '&redirect_uri=' . $callback . '&state=' . $csrf_value;


echo '<a href=' . $url . '><button class="contact">LINEログイン</button></a>';

?>

</div>
</div>
</body>
</html>