<?php
 //(M)
 //ユーザーのプロフィール設計図
 require_once 'models/Model.php';
 require_once 'models/User.php';
 class Event extends Model{
     
     public $id;
     public $user_id;
     public $name;
     public $content;
     public $place;
     public $day;
     public $time;
     public $participants;
     public $image;
     public $created_at;
     
     public function __construct($user_id='',$name= '', $content = '', $place= '',$day='',$time= '',$image = '',$participants=""){
         
         $this->user_id = $user_id;
         $this->name = $name;
         $this->content = $content;
         $this->place = $place;
         $this->day = $day;
         $this->time= $time;
         $this->image = $image;
         $this->participants= $participants;
         
     }
     
    //イベント登録・更新メソッド
    public function save(){
        try {
            $pdo = self::get_connection();
            
            //新規登録の時
            if($this->id === null){
                $stmt = $pdo -> prepare("INSERT INTO events (user_id,name,content,place,day,time,image,participants) VALUES (:user_id,:name,:content,:place,:day,:time,:image,:participants)");//変数値を保持しているのでprepare
                // バインド処理
                $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                $stmt->bindParam(':place', $this->place, PDO::PARAM_STR);
                $stmt->bindParam(':day', $this->day, PDO::PARAM_STR);
                $stmt->bindParam(':time', $this->time, PDO::PARAM_STR);
                $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                $stmt->bindParam(':participants', $this->participants, PDO::PARAM_INT);
                $stmt->execute();
                self::close_connection($pdo, $stmp);
                return "イベントの作成が成功しました";
            }else{ //更新処理
            
                // 更新では以下のようなSQLが必要
                // UPDATE events SET name='ramen', content='ramen', place='tokyo', day='2021-09-22', time='21:50', image='2.jpg', participants=100 WHERE id=1;
                $stmt = $pdo -> prepare("UPDATE events SET name=:name, content=:content, place=:place, day=:day, time=:time, image=:image, participants=:participants WHERE id=:id");//変数値を保持しているのでprepare
                // バインド処理
                $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
                $stmt->bindParam(':place', $this->place, PDO::PARAM_STR);
                $stmt->bindParam(':day', $this->day, PDO::PARAM_STR);
                $stmt->bindParam(':time', $this->time, PDO::PARAM_STR);
                $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                $stmt->bindParam(':participants', $this->participants, PDO::PARAM_INT);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                
                // 実行
                $stmt->execute();
                
                self::close_connection($pdo, $stmp);
                
                return "イベント情報を更新しました";
            
            }
        
        } catch (PDOException $e) {
            return 'PDO exception: ' . $e->getMessage();
        }
    }
     //入力チェック メソッド
     public function validate(){
         $errors = array();
         if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z一-龠\s]+|[ 　]+$/', $this->name)){
            $errors[] = 'イベント名は数字、記号は入力できません';
         }
         if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z一-龠\s]+|[ 　]+$/', $this->content)){
            $errors[] = 'イベント内容は、数字、記号は入力できません';
         } 
         if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z一-龠\s]+|[ 　]+$/', $this->place)){
            $errors[] = 'イベント開催場所は、数字、記号は入力できません';
         }  
         if($this->image === ''){
             $errors[] = '画像を選択してください';
         }
         if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/',$this->day)){
             $errors[]="日にちはxxxx-xx-xxの形式で入力してください";
         }         
         if(!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/',$this->time)){
             $errors[]="時刻はxx:xxの形式で入力してください";
         }
         if(!preg_match('/^[1-9][0-9]*$/',$this->participants)){
             $errors[]="参加者人数は0以上の数字で入力してください";
         }         
         return $errors;
     }
     //全プロフィール情報　取得メソッド
     public static function all(){
                try {
                    $pdo = self::get_connection();
                    $stmt = $pdo->query('SELECT id,name, content,place,day,time,participants,image,created_at FROM events');
                    // フェッチの結果を、Postクラスのインスタンスにマッピングする
                    $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Event');
                    $events = $stmt->fetchAll();
                    self::close_connection($pdo, $stmp);
                    
                    return $events;
                } catch (PDOException $e) {
                    return 'PDO exception: ' . $e->getMessage();
                }
            }
     
     //idから対象のEventオブジェクトを取得するメソッド
     public static function find($id){
            
         try {
            $pdo = self::get_connection();
            $stmt = $pdo -> prepare("select * from events where id=:id");//変数値を保持しているのでprepare
            // バインド処理
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // 実行
            $stmt->execute();
            // フェッチの結果を、Userクラスのインスタンスにマッピングする
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Event');
            // Userクラスのインスタンスを返す
            $events = $stmt->fetch();  //ひとり抜き出し
            self::close_connection($pdo, $stmp);
            return $events;                    
        } catch (PDOException $e) {
            return 'PDO exception: ' . $e->getMessage();
                }
            }     
  }
