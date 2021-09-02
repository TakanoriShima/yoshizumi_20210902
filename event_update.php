<?php
    // (C)
    require_once 'filters/LoginFilter.php';
    require_once 'models/Profile.php';
    require_once 'models/User.php';
    require_once "models/Event.php";
    
    // セッション開始
    session_start();
    
    // セッションからログインユーザー情報取得
    $login_user = $_SESSION["login_user"];
    
    //イベントidを取得
    $id = $_POST['id'];
    
    // その他入力情報を取得
    $name = $_POST["name"];
    $content = $_POST["content"];
    $place = $_POST["place"];
    $day = $_POST["day"];
    $time = $_POST["time"];
    $participants = $_POST["participants"];
    $image = $_FILES["image"]["name"];
    
    //イベントidから対象のイベント情報を取得
    $event = Event::find($id);
    
    //インスタンスの情報を更新する
    $event->name = $name;
    $event->content = $content;
    $event->place = $place;
    $event->day = $day;
    $event->time = $time;
    $event->participants = $participants;
    
    //入力エラーチェック
    $errors = $event->validate();

    // 入力エラーが１つもなければ
    if(count($errors) === 0){
        
        // 画像を選択した時
        if (empty($image) !== true) {
            
            // インスタンスの画像名を更新
            $event->image = $image;
        
            $file = 'upload/' . $image;
            // 画像をuploadディレクトリにファイル保存
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
        }
        // 更新されたイベントインスタンスの保存

        $flash_message = $event->save();
        
        // セッションにflash_messageを保存
        $_SESSION["flash_message"] = $flash_message;
        // リダイレクト
        header("Location: event_show.php?id=" . $id);
        exit;
        
    }else{ //入力エラーが１つでもあれば
        // セッションにerrorsを保存
        $_SESSION["errors"] = $errors;
        header("Location: event_edit.php?id=" . $id);
        exit;
    }
    
