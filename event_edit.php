<?php
  require_once "filters/LoginFilter.php";
  require_once "models/User.php";
  require_once "models/Event.php";
  
  session_start();
  
  // var_dump($_GET);
  $id = $_GET["id"];
  
  //対象のイベントをDBから引き出す
  $events = Event::find($id);
  // var_dump($events);
  
  //入力エラーを受け取る
  $errors = $_SESSION["errors"];
  // var_dump($errors);
  $_SESSION["errors"] = null;
  
  //セッションからユーザーアイコンを取得
  $user_icon = $_SESSION["user_icon"];
  $_SESSION["user_icon"] = $user_icon;

include_once "views/event_edit_view.php";
  
  