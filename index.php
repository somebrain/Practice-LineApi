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

 //   replyButtonsTemplate($bot,$event->getReplyToken(),'お天気お知らせ - 今日は天気は晴れです', 'https://' . $_SERVER['HTTP_HOST'] . '/imgs/template.jpg',
   //     'お天気お知らせ','今日は晴れです',
    //    new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('明日の天気', 'tomorrow'),
    //    new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder ('週末の天気', 'weekend'),
     //   new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ('webで見る', 'http://google.jp'));

// replyConfirmTemplate($bot,$event->getReplyToken(),'webでみますか?','webでみますか?',new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
  //   '見る', 'http://google.jp'),new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('見ない', 'ignore')
// );

//$columnArray = array();
//for($i = 0; $i < 5; $i++) {
 //   $actionArray = array();
  //  array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '-' . 1, 'c-' . $i . '-' . 1));
 //   array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '-' . 2, 'c-' . $i . '-' . 2));
 //   array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('ボタン' . $i . '-' . 3, 'c-' . $i . '-' . 3));

  //  $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
  //      ($i + 1) . '日後の天気',
  //      '晴れ',
 //       'https://' . $_SERVER['HTTP_HOST'] . '/imgs/template.jpg', $actionArray);


  //      array_push($columnArray, $column);
 //       }
  //      replyCarouselTemplate($bot, $event->getReplyToken(),'今後の天気予報', $columnArray);


if ($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage) {
    $content = $bot->getMessageContent($event->getMessageId());
    $headers = $content->getHeaders();
    error_log(var_export($headers, true));
    $directory_path = 'tmp';
    $filename = uniqid();
    $extension = explode('/', $headers['Content-Type'])[1];
    if(!file_exists($directory_path)) {
        if(mkdir($directory_path, 0777, true)) {
            chmod($directory_path, 0777);
        }
    }
    file_put_contents($directory_path . '/' . $filename . '.' . $extension, $content->getRawBody());
    replyTextMessage($bot, $event->getReplyToken(), 'http://' . $_SERVER['HTTP_HOST'] . '/' . $directory_path. '/' . $filename . '.' . $extension);
}






}

function replyTextMessage($bot, $replyToken, $text) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));

    if (!$response->isSucceeded()) {
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

//Buttonsテンプレートメッセージ
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
//Confirmテンプレートメッセージ
function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {


    $actionArray = array();
    foreach($actions as $value) {
        array_push($actionArray, $value);
    }
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder ($text, $actionArray));
    $response = $bot->replyMessage($replyToken, $builder);
    if (!$response->isSucceeded()) {
        erro_log('Failded' . $response->getHTTPStatus . ' ' . $response->getRAwBody());

    }
}
//carouselテンプレートメッセージ
function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder (
        $columnArray)
    );
    $response = $bot->replyMessage($replyToken, $builder);
if (!$response->isSucceeded()) {
    erro_log('Failded' . $response->getHTTPStatus . ' ' . $response->getRAwBody());

 }

}







?>











