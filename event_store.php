<?php
    // (C)
    require_once "filters/LoginFilter.php";
    require_once "models/User.php";
    require_once "models/Profile.php";
    require_once "models/Event.php";

    // セッション開始
    session_start();
    
    // セッションからログインユーザー情報を取得
    $login_user = $_SESSION["login_user"];
    
    // 入力情報を取得
    $name = $_POST["name"];
    $content = $_POST["content"];
    $place = $_POST["place"];
    $day = $_POST["day"];
    $time = $_POST["time"];
    $participants = $_POST["participants"];
    $image = $_FILES["image"]["name"];
    
    // 入力値をもとにイベントインスタンスを新規作成
    $event = new Event($login_user->id, $name, $content, $place, $day, $time, $image, $participants);

    // 入力項目に誤りがないかチェック
    $errors = $event->validate();
   
    // 入力エラーが１つもなければ
    if(count($errors) === 0){

        // 画像が選択されていれば
        if($_FILES["image"]["size"] !==0){
            //uploadディレクトリにファイルを保存
            $file = 'upload/' . $image;
            // 画像をアップロード
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
        }
        
        // イベントインスタンスを作成
        $flash_message = $event->save();
        // セッションにflash_messageを保存
        $SESSION["flash_message"] = $flash_message;
    
        // リダイレクト
        header("Location: event_top.php");
        exit;

    //入力エラーが１つでもあれば
    }else{
        // セッションにerrorsを保存
        $SESSION["errors"] = $errors;
        // リダイレクト
        header("Location: event_create.php");
        exit;
    }


