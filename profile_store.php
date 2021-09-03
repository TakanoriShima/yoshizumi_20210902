<?php
    // (C)
    require_once "filters/LoginFilter.php";
    require_once "models/User.php";
    require_once "models/Profile.php";
    
    // セッション開始
    session_start();
    
    // セッションからログインしているユーザー情報を取得
    $login_user = $_SESSION["login_user"];
    
    // プロフィールの入力情報を取得
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $job = $_POST["job"];
    $country = $_POST["country"];
    $introduction = $_POST["introduction"];
    $image = $_FILES["image"]["name"];
    
    // 入力内容から新規プロフィールインスタンスを作成
    $profile = new Profile($login_user->id, $age, $gender, $job, $country, $introduction, $image);
    
    // 入力項目に誤りがないかチェック
    $errors = $profile->validate();

    // 入力エラーが１つもなければ
    if(count($errors) === 0){
    
        //画像が選択されていれば
        if($_FILES["image"]["size"] !==0){
            // uploadディレクトリにファイルを保存
            $file = 'upload/' . $image;
            // 画像をアップロード
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
        }
        
        // データベースにプロフィールを保存
        $flash_message = $profile->save();
        
        // セッションに flash_messageを保存
        $_SESSION["flash_message"] = $flash_message;
        
        // リダイレクト
        header("Location: profile_show.php?id=" . $login_user->id);
        exit;
        
    }else{ //入力エラーが１つでもあれば
        
        // セッションにエラーメッセージを保存
        $_SESSION["errors"] = $errors;
        // リダイレクト
        header("Location: profile_create.php");
        exit;
    }
      
  
