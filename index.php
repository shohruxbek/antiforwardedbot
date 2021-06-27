<?php
define('API_KEY','MTU0NzM1MzE5MTpBQUZ2WWU5aUFmdjEzaUdpSS1PU1Q1X05hWnVpXzQzUXVpUQ');
// echo "https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME'];
function bot($method,$datas=[]){
    $url = "https://api.Telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$firstname = $message->from->first_name;
$username = $message->from->username;

$callback = $update->callback_query;
$cap2 = $callback->message->caption;
$sdg = $callback->message->from->first_name;
$data = $callback->data;
$chdi = $callback->message->message_id;
$chi = $callback->message->chat->id;
$cqid = $callback->id;
$text = $message->text;

if(!$chat_id){
    $chat_id=$chi;
    $message_id=$chdi;
}

include('admin.php');
include('files.php');


function del($chat_id,$message_id){
    bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id
]);
}

function keys($chat_id){
$photos = json_decode(file_get_contents('photo.json'));
$lenphoto = count($photos);

$audio = json_decode(file_get_contents('audio.json'));
$lenaudio = count($audio);

$video = json_decode(file_get_contents('video.json'));
$lenvideo = count($video);

$voice = json_decode(file_get_contents('voice.json'));
$lenvoice = count($voice);

$video_note = json_decode(file_get_contents('video_note.json'));
$lenvideo_note = count($video_note);


$document = json_decode(file_get_contents('document.json'));
$lendocument = count($document);

$key =json_encode([
    'inline_keyboard'=>[
        [['text'=>"🌄 Photo - [ $lenphoto ]",'callback_data'=>"#photo"],['text'=>"🎼 Audio - [ $lenaudio ]",'callback_data'=>"#audio"]],
        [['text'=>"🎬 Video - [ $lenvideo ]",'callback_data'=>"#video"],['text'=>"🎤 Voice - [ $lenvoice ]",'callback_data'=>"#voice"]], 
        [['text'=>"🎥 VideoNote - [ $lenvideo_note ]",'callback_data'=>"#video_note"],['text'=>"🗂 Document - [ $lendocument ]",'callback_data'=>"#document"]],
    ]
]);
     bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Photo.Audio.Video.Voice.VideoNote.Doc. yuboring",
'reply_markup'=>$key
]);
}

function gets($chat_id,$data){
$files = json_decode(file_get_contents("$data.json"));
$lenfiles = count($files);

for($i=0;$i<$lenfiles;$i++){

if($i==$lenfiles-1){
    $key =json_encode([
    'inline_keyboard'=>[
        [['text'=>"Delete",'callback_data'=>"$i*$data"],['text'=>"Bosh menyu",'callback_data'=>"BM"]],
    ]
]);
    if($data=="video_note"){
        bot("sendvideonote",[
'chat_id'=>$chat_id,
"{$data}"=>"{$files[$i]}",
'reply_markup'=>$key
]); 
    }else{
         bot("send{$data}",[
'chat_id'=>$chat_id,
"{$data}"=>"{$files[$i]}",
'reply_markup'=>$key
]);
    }
   

}else{
    $key =json_encode([
    'inline_keyboard'=>[
        [['text'=>"Delete",'callback_data'=>"$i*$data"]],
    ]
]);
    if($data=="video_note"){
        bot("sendvideonote",[
'chat_id'=>$chat_id,
"{$data}"=>"{$files[$i]}",
'reply_markup'=>$key
]); 
    }else{
         bot("send{$data}",[
'chat_id'=>$chat_id,
"{$data}"=>"{$files[$i]}",
'reply_markup'=>$key
]);
    }
}
}



 
}





if($chat_id==$creator or in_array($chat_id,$adminlaar)){

if($text=="/start"){
keys($chat_id); 
}


if($message->photo){
    $filel = $message->photo[0]->file_id;
    array_push($photos, $filel);

$myfile = fopen("photo.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($photos));
fclose($myfile);
keys($chat_id);
}



if($message->audio){
    $filel = $message->audio->file_id;
    array_push($audios, $filel);

$myfile = fopen("audio.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($audios));
fclose($myfile);
keys($chat_id);
}

if($message->video){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>json_encode($message->video->file_id)
]);

    $filel = $message->video->file_id;
    array_push($videos, $filel);

$myfile = fopen("video.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($videos));
fclose($myfile);
keys($chat_id);
}

if($message->voice){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>json_encode($message->voice->file_id)
]);

    $filel = $message->voice->file_id;
    array_push($voices, $filel);

$myfile = fopen("voice.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($voices));
fclose($myfile);
keys($chat_id);
}

if($message->video_note){

    $filel = $message->video_note->file_id;
    array_push($video_notes, $filel);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$filel
]);
$myfile = fopen("video_note.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($video_notes));
fclose($myfile);
keys($chat_id);
}

if($message->document){

    $filel = $message->document->file_id;
    array_push($documents, $filel);

$myfile = fopen("document.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($documents));
fclose($myfile);
keys($chat_id);
}


if(mb_stripos($data,"#") !== false){
    $data = str_replace("#", '', $data);
    gets($chat_id,$data);
}





 if($data){
  bot('answerCallbackQuery',[
     'callback_query_id'=>$cqid,
     'text'=> "wait...",
     'show_alert'=>false
 ]);
}



if($data=="BM"){
    keys($chat_id);
}

if(mb_stripos($data,"*") !== false){
    $d = explode("*", $data);

$file = json_decode(file_get_contents("{$d[1]}.json"));
array_splice($file, $d[0], 1);

$myfile = fopen("{$d[1]}.json", "w") or die("Faylni ochib bo'lmayapdi!");
fwrite($myfile, json_encode($file));
fclose($myfile);

keys($chat_id);

del($chat_id,$message_id);

}











}else{
    bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Salom, boshqa joyda o'yna!"
]);
}
?>