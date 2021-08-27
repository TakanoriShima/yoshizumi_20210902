<!DOCTYPE html>
<html lang="ja">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>プロフィールページ</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      <link rel="stylesheet" href="css/profile.css">
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
               <img src="images/icon.jpg">
           </div>
       </div>
      </nav>           
  </header>
   <main>
       <?php foreach($profiles as $profile):?>
           <div class="grid">
               <div class="grid-item-left">
                   <img src="upload/<?=$profile->image?>" class="icon">
                  写真: <input type="file" name="image"><br>
                  <img src="upload/<?=$post->image?>">
                  <input type="hidden" name="id" value="<?=$post->id?>">
               </div>
               <div class="grid-item-right"> 
                   <div class="items">
                       <h2>Hello&nbsp;<?=$login_user->name?>さん</h2>
                       <ul>
                           <li><?=$login_user->created_at?>からユーザーサービスを利用してます</li>
                           <li><a href="profile_edit.php?id=<?=$login_user->id?>">プロフィールを編集</a></li>
                       </ul>
                   </div>
                   <div class="profile">
                     <section>
                         <h2>自己紹介</h2>
                         <P><?=$profile->introduction?></P>
                     </section>
                     <section>
                         <h2>滞在国</h2>
                         <P><?=$profile->country?></P>
                     </section>                     
                     <section class="flex">
                         <div class="section-item">
                             <h2>性別</h2>
                             <P><?=$profile->gender?></P>                             
                         </div>
                         <div class="section-item">
                             <h2>年齢</h2>
                             <P><?=$profile->age?>歳</P>                             
                         </div>                         
                     </section> 
                     <section>
                         <h2>仕事</h2>
                         <P><?=$profile->job?></P>
                     </section>                      
                 </div>
                   <ul>
                   <li>トップページへ戻りますか？</li>
                   <li><a href="top.php">トップページはこちら&#8599;</a></li>
                </ul>                 
               </div>
           </div>
    </main>
      <?php endforeach;?>
       <footer></footer>   
   </body>
</html>