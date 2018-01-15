<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');



$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
    	//Type:Sticker,Image,Video,Audio,Location,Imagemap,Template
        case 'message':
            $message = $event['message'];
            //篩選種類
            switch ($message['type']) {
                case 'text':
                	//篩選指定文字
                	switch ($message['text']) {
                		case "請問":
                			$botReply = "有什麼問題呢？";
                			break;
                		case 'confirm範例':
                			$client->replyMessage(array(
	                        'replyToken' => $event['replyToken'],
	                        'messages' => array(
	                            array(
	                                'type' => 'template',
	                                'altText' => 'Yes or No.',
	                                'template' => array(
	                                	'type' => 'confirm',
	                                	'text' => '確定嗎？',
	                                	'actions' => array(
	                                		array(
	                                			'type' => 'message',
	                                			'label' => 'Yes',
	                                			'text' => 'Yes'
	                                		),
	                                		array(
	                                			'type' => 'message',
	                                			'label' => 'No',
	                                			'text' => 'No'
	                                		)
	                                	)
	                                )

	                            )
	                        )
	                    	));
                			break;
            			case 'button範例':
            			$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'template',
                                'altText' => 'This is a buttons template.',
                                'template' => array(
                                	'type' => 'buttons',
                                	'thumbnailImageUrl' => 'https://example.com/bot/images/image.jpg',
                                	'imageAspectRatio' => 'rectangle',
                                	'imageSize' => 'cover',
                                	'imageBackgroundColor' => '#FFFFFF',
                                	'title' => 'Menu',
                                	'text' => '請選擇',
                                	'actions' => array(
                                		array(
                                			'type' => 'message',
                                			'label' => 'Yes',
                                			'text' => 'Yes'
                                		),
                                		array(
                                			'type' => 'message',
                                			'label' => 'No',
                                			'text' => 'No'
                                		)
                                	)
                                )

                            )
                        )
                    	));
            			break;
                	}
                	//傳送template測試(tamplate button)
                	// if($template_val != 0){
                	// 	$client->replyMessage(array(
                 //        'replyToken' => $event['replyToken'],
                 //        'messages' => array(
                 //            array(
                 //                'type' => 'template',
                 //                'alttext' => 'Yes or No.',
                 //                'template' => array(
                 //                	'type' => 'confirm',
                 //                	'text' => '確定嗎？',
                 //                	'action' =>array(
                 //                		array(
                 //                			'type' => 'message',
                 //                			'label' => 'Yes',
                 //                			'text' => 'No'
                 //                		),
                 //                		array(
                 //                			'type' => 'message',
                 //                			'label' => 'Yes',
                 //                			'text' => 'No'
                 //                		)
                 //                	)
                 //                )

                 //            )
                 //        )
                 //    	));
                 //    	$template_val = 0;
                	// }
                	if($botReply != ""){
                		$m_message = $botReply;
                	}else{
                		$m_message = "你說：" . $message['text'];
                	}
                    break;
                case 'sticker':
                 	$m_message = "我不知道你說了什麼？";
                    break;
                case 'image':
                 	$m_message = "圖片網址：" . $message['originalContentUrl'];
                    break;
            }
            // ReplySetting 
            if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $m_message
                            )
                        )
                    	));
                	}
            // relpysetting($m_message);
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};


