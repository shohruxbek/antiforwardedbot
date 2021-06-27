<?php

if (!file_exists('admin.txt')) { 
 $myfile = fopen("admin.txt", "a");
 fclose($myfile);
}
if(!file_exists('creator.txt')) { 
  $myfile = fopen("creator.txt", "a");
  fclose($myfile);
}


$adminlaar = explode("|", file_get_contents("admin.txt"));
$creator = file_get_contents("creator.txt");
if($chat_id){
    $adminqadam = file_get_contents("admin/".$chat_id."/qadam.txt");
}


if($text=="/id"){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Sizning id: $chat_id"
    ]);
    exit();
}

//---Bot creatorini ro'yxatdan o'tkazish



if($text == "/mencreator" and $creator==""){
  file_put_contents("creator.txt", $chat_id);
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"{$chat_id} - {$firstname} - siz, creator bo'ldingiz"
]);
  exit();
}elseif($text == "/mencreator" and $creator!=""){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz endi creator bo'lolmaysiz"
    ]);
    exit();
}

//----------------


if($chat_id==$creator or in_array($chat_id,$adminlaar)){





//Adminlar qadamlari uchun fayl hosil qilinyapdi
if($chat_id==$creator or in_array($chat_id,$adminlaar)){
   if(!file_exists("admin/".$chat_id)){
    mkdir("admin/".$chat_id);
} 
} 

$key =json_encode([
    'keyboard'=>[
        [['text'=>"⚖️ Statistika"]],
        [['text'=>"Admin qo'shish ➕"],['text'=>"➖ Adminni o'chirish"]],
    ],
    'resize_keyboard'=>true
]);
//-------------

//---------

if($text=="Bekor qilish"){
 bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Tanlang",
    'reply_markup'=>$key
]);
 file_put_contents("admin/".$chat_id."/qadam.txt","adm");
 exit();
}





if($text=="admin" and $chat_id==$creator or $text=="admin" and in_array($chat_id,$adminlaar) or $text=="Admin" and $chat_id==$creator or $text=="Admin" and in_array($chat_id,$adminlaar)){
 bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Tanlang",
    'reply_markup'=>$key,
]);
 file_put_contents("admin/".$chat_id."/qadam.txt","adm");
 exit();
}




//⚖️ Statistika bo'limi

if(mb_stripos($text,"⚖️ Statistika") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"⚖️ Statistika") !== false and $chat_id==$creator){

    $admson = count($adminlaar)-1;
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'parse_mode'=>"Markdown",
        'text'=>"*Ushbu botda*:\n\n*Adminlar:* {$admson}ta"
    ]);
    exit();
}

//----------










//Yangi admin tayinlash

if(mb_stripos($text,"Admin qo'shish ➕") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"Admin qo'shish ➕") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni admin qilmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242\n\nAgar bilmasangiz o'sha kishi botga /id deb yozsin. Bot o'sha kishiga id raqamini yuboradi. keyin id raqamini sizga yuborsin.",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","addadmin");

    exit();
}elseif(mb_stripos($text,"Admin qo'shish ➕") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"Admin qo'shish ➕") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="addadmin" or $message and $chat_id==$creator and $adminqadam=="addadmin"){
    $ref = file_get_contents("admin.txt");
    $ref.="{$text}|";
    file_put_contents("admin.txt", $ref);
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"{$text} - kishi; adminlar ro'yxatiga qo'shildi",
        'reply_markup'=>$key
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    exit();
}
//--------------------------




//➖ Adminni o'chirish
if(mb_stripos($text,"➖ Adminni o'chirish") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Adminni o'chirish") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni adminlikdan o'chirmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242 \n\nAgar bilmasangiz o'sha kishi botga /id deb yozsin. Bot o'sha kishiga id raqamini yuboradi. keyin id raqamini sizga yuborsin.",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
                [['text'=>"Hamma adminlarni o'chirish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","delladmin");
    exit();

}elseif(mb_stripos($text,"➖ Adminni o'chirish") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Adminni o'chirish") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="delladmin" or $message and $chat_id==$creator and $adminqadam=="delladmin"){
    if($text=="Hamma adminlarni o'chirish"){
      file_put_contents("admin.txt", "");
      bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Hamma adminlar ro'yxatdan o'chirildi",
        'reply_markup'=>$key
    ]);

  }else{
   $ref = file_get_contents("admin.txt");
   $ref=str_replace("{$text}|", "", $ref);
   file_put_contents("admin.txt", $ref);
   bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"{$text} - kishi; adminlar ro'yxatidan o'chirildi",
    'reply_markup'=>$key
]);
}
file_put_contents("admin/".$chat_id."/qadam.txt","adm");
exit();
}


//------------------


}?>