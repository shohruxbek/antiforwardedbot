<?php

if(!file_exists('photo.json')) { 
  file_put_contents("photo.json","[]");
}
$photos = json_decode(file_get_contents('photo.json'));

if(!file_exists('audio.json')) { 
  file_put_contents("audio.json","[]");
}
$audios = json_decode(file_get_contents('audio.json'));

if(!file_exists('video.json')) { 
  file_put_contents("video.json","[]");
}
$videos = json_decode(file_get_contents('video.json'));

if(!file_exists('voice.json')) { 
  file_put_contents("voice.json","[]");
}
$voices = json_decode(file_get_contents('voice.json'));

if(!file_exists('video_note.json')) { 
  file_put_contents("video_note.json","[]");
}
$video_notes = json_decode(file_get_contents('video_note.json'));

if(!file_exists('document.json')) { 
  file_put_contents("document.json","[]");
}
$documents = json_decode(file_get_contents('document.json'));

?>