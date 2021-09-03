<!DOCTYPE html>
<html lang="ja">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>プロフィールページ</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      <link rel="stylesheet" href="css/index/profile.css">
      <link rel="stylesheet" href="css/reset.css">
      <link rel="icon" type="image/png" href="images/favicon.png" sizes="48x48" />
   </head>
   <body>
      <div class="wrapper">
         <div class="content">
            <h1>Awesome&nbsp;<span>Meetup</span></h1>
            <p><?= $login_user->name ?>さんようこそ</p>
            <!--入力エラー表示-->
            <?php if($errors !== null):?>
            <ul>
               <?php foreach($errors as $error): ?>
               <li><?= $error?></li>
               <?php endforeach;?>
            </ul>
            <?php endif; ?>
            
           <form action="profile_store.php" method="POST" enctype="multipart/form-data">
               年齢: <input type="text" name="age"><br>
               <label>
               性別: <input type="radio" name="gender" value="男性" checked>男性
               　　　<input type="radio" name="gender" value="女性">女性
               </label><br>
               仕事: <input type="text" name="job"><br>
               滞在国: <input type="text" name="country"><br>
               自己紹介: <input type="textarea" name="introduction"><br>
               写真: <input type="file" name="image"><br>
               <button type="submit">投稿</button>
               <!--<input type="submit" value="登録">-->
           </form>
            <ul>
               <li><a href="profile_show.php">プロフィールページへ&#8599;</a></li>
               <li><a href="logout.php">ログアウト&#8599;</a></li>
            </ul>           
         </div>
      </div>
   </body>
</html>