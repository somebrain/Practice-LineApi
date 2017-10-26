<?php



require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
foreach ($events as $event) {
    // $bot->replyText($event->getReplyToken(), 'text');
   //replyTextMessage($bot, $event->getReplyToken(), 'TextMessage');
  // replyLocationMessage($bot, $event->getReplyToken(), 'LINE', '東  京都渋谷区渋谷2-21-1 ヒカリエ27階', 35.659025,139.703473);
//replyStickerMessage($bot, $event->getReplyToken(), 1, 1);
//replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/imgs/original.jpg', 'https://' . $_SERVER['HTTP_HOST'] .
 //'/imgs/preview.jpg');


$columnArray = array();
for($i = 0; $i < 5; $i++) {
$actionArray = array();
array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '_' . 1, 'c-' . $i . '-' . 1));
array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '-' . 2, 'c-' . $i . '-' . 2));
array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '-' . 3, 'c-' . $i . '-' . 3));
$column = new  LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
($i + 1) . '日後の天気',
'晴れ',
 






}
function replyTextMessage($bot, $replyToken, $text) {
$response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));

(!$response->isSucceeded()) {
error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
   // error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody(), 3, './error.log');
   }
}


function replyLocationMessage($bot, $replyToken, $title, $address, $lat, $lon) {
$response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($title, $address, $lat, $lon));

if (!$response->isSucceeded()) {
  error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
   // error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody(), 3, './error.log');
}

}

function replyStickerMessage($bot, $replyToken, $packageId, $stickerId) {
    $response = $bot->replyMessage($replyToken,new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder($packageId, $stickerId));
    if (!$response->isSucceeded()) {
        error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
    }
}


function replyImageMessage($bot, $replyToken, $originalImageUrl,$previewImageUrl) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalImageUrl, $previewImageUrl));
    if (!$response->isSucceeded()) {
        error_log('Failed!' . $response->getHTTPStatus . ' ' .$response->getRawBody());
    }
}


function replyButtonsTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {
    $actionArray = array();
    foreach($actions as $value) {
        array_push($actionArray, $value);
    }
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder($title, $text, $imageUrl, $actionArray));
    $response = $bot->replyMessage($replyToken, $builder);
    if (!$response->isSucceeded()) {
        erro_log('Failded' . $response->getHTTPStatus . ' ' . $response->getRAwBody());

    }
}


function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
    $actionArray = array();
    foreach($actions as $value) {
        array_push($actionArray, $value);
    }
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder ($text, $actionArray)
    );
    $response = $bot->replyMessage($replyToken, $builder);
    if (!$response->isSucceeded()) {
        erro_log('Failded' . $response->getHTTPStatus . ' ' . $response->getRAwBody());

    }

}

function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
 $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder ($columnArray)
);
$response = $bot->replyMessage($replyToken, $builder);
if (!$response->isSucceeded()) {
erro_log('Failded' . $response->getHTTPStatus . ' ' . $response->getRAwBody());
 }
}















?>
