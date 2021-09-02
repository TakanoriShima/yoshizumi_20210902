<!DOCTYPE html>
<html lang="ja">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>イベント編集ページ</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      <link rel="stylesheet" href="css/profile_edit.css">
      <link rel="stylesheet" href="css/reset.css">
      <link rel="icon" type="image/png" href="images/favicon.png" sizes="48x48" />
   </head>
   <body>
      <header>
         <!-- ナビゲーションバー -->
         <nav class="navbar navbar-light fixed-top">
            <h1>Awesome&nbsp;<span>Meetup</span></h1>
            <div id="nav">
               <div class="menu-btn">
                  <span></span>
                  <span></span>
                  <span></span>
               </div>
               <div class="user-icon">
                  <img src="upload/<?=$user_icon?>">
               </div>
            </div>
         </nav>
      </header>
      <main>
            <!--入力エラー表示-->
            <?php if($errors !== null):?>
            <ul>
               <?php foreach($errors as $error): ?>
               <li><?= $error?></li>
               <?php endforeach;?>
            </ul>
            <?php endif; ?>
            <?php if($flash_message !== null):?>
            <ul>
               <li><?= $flash_message?></li>
            </ul>
            <?php endif; ?>                     
         
            <div class="grid">

               </div>
               <div class="grid-item-right">
                  <div class="items">
                     <h2>Hello&nbsp;<?=$login_user->name?>さん</h2>
                     <ul>
                        <li><?=$login_user->created_at?>からユーザーサービスを利用してます</li>
                     </ul>
                  </div>
                  <form action="event_update.php" method="POST" enctype="multipart/form-data">
                                 イベント名: <input type="text" name="name" value="<?= $events->name ?>"><br>
                                 イベント内容: <input type="textarea" name="content" value="<?= $events->content ?>"><br>
                                                写真: <input type="file" name="image"><br>
                                 開催地: <input type="text" name="place" value="<?= $events->place ?>"><br>
                                 開催日: <input type="date" name="day" value="<?= $events->day ?>"><br>
                                 開催時間: <input type="time" name="time" value="<?= $events->time ?>"><br>
                                 参加人数: <input type="number" name="participants" value="<?= $events->participants ?>"><br>
                                 <input type="hidden" name="id" value="<?=$events->id?>">
                                 <button type="submit">投稿</button>
                                 <!--<input type="submit" value="登録">-->
                  </form>
                     <ul>
                        <li>トップページへ戻りますか？</li>
                        <li><a href="top.php">トップページはこちら&#8599;</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </form>
      </main>
      <footer></footer>
   </body>
</html>
