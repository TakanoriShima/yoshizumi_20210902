<?php
 //(M)
 //ユーザーのプロフィール設計図
 require_once 'models/Model.php'; 
 class Profile extends Model{
     public $id;
     public $user_id;
     public $age;
     public $gender;
     public $job;
     public $country;
     public $introduction;
     public $image;
     public $created_at;
     public function __construct($user_id='',$age= '', $gender = '', $job= '',$country='',$introduction = '',$image = ''){
         
         $this->user_id = $user_id;
         $this->age = $age;
         $this->gender = $gender;
         $this->job = $job;
         $this->country = $country;
         $this->introduction = $introduction;
         $this->image = $image;
         
     }
     
     //ユーザー登録メソッド
     public function save(){
                try {
                    $pdo = self::get_connection();
                    
                    //新規登録の時
                    if($this->id === null){
                        $stmt = $pdo -> prepare("INSERT INTO profile (user_id,age, gender,job,country,introduction,image) VALUES (:user_id,:age, :gender,:job,:country,:introduction,:image)");//変数値を保持しているのでprepare
                        // バインド処理
                        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
                        $stmt->bindParam(':age', $this->age, PDO::PARAM_INT);
                        $stmt->bindParam(':gender', $this->gender, PDO::PARAM_STR);
                        $stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
                        $stmt->bindParam(':country', $this->country, PDO::PARAM_STR);
                        $stmt->bindParam(':introduction', $this->introduction, PDO::PARAM_STR);
                        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                        $stmt->execute();
                        self::close_connection($pdo, $stmp);
                        return "プロフィールの作成が成功しました";
                    }else{ //更新処理
                        $stmt = $pdo -> prepare("UPDATE profile SET age=:age,gender=:gender,job=:job,country=:country,introduction=:introduction WHERE id=:id");//変数値を保持しているのでprepare
                        
                        $stmt->bindParam(':age', $this->age, PDO::PARAM_INT);
                        $stmt->bindParam(':gender', $this->gender, PDO::PARAM_STR);
                        $stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
                        $stmt->bindParam(':country', $this->country, PDO::PARAM_STR);
                        $stmt->bindParam(':introduction', $this->introduction, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
                        // $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
                        // 実行
                        $stmt->execute();
                        self::close_connection($pdo, $stmp);
                        return "プロフィールを更新しました";
                        
                    }
                    
                } catch (PDOException $e) {
                    return 'PDO exception: ' . $e->getMessage();
                }
            }
     //入力チェック メソッド
     public function validate(){
         $errors = array();
         if ($this->age === '') {
             $errors[] = '年齢を入力してください';
         }
         if ($this->userID === '') {
             $errors[] = 'ユーザーIDを入力してください';
         }
         if($this->password ===""){
            $errors[] ="パスワードを入力してください";
         }elseif(!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $this->password)){
            $errors[] = '半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上のパスワードを入力してください';
         }
         return $errors;
     }
     //全プロフィール情報　取得メソッド
     public static function all(){
         try {
            $pdo = self::get_connection();
                    $stmt = $pdo->query('SELECT age, gender,job,country,introduction,image FROM profile');
             // フェッチの結果を、Profileクラスのインスタンスにマッピングする
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Profile');
            $profiles = $stmt->fetchAll();
            self::close_connection($pdo, $stmp);
            // Pfofileクラスのインスタンスの配列を返す
            return $profiles;
         } catch (PDOException $e) {
            return 'PDO exception: ' . $e->getMessage();
         }
         
     }
     
     //idから対象のProfileオブジェクトを取得するメソッド
     public static function find($id){
            
         try {
            $pdo = self::get_connection();
            $stmt = $pdo -> prepare("SELECT * FROM profile WHERE id=:id");//変数値を保持しているのでprepare
            // バインド処理
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // 実行
            $stmt->execute();
            // フェッチの結果を、Userクラスのインスタンスにマッピングする
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Profile');
            // Userクラスのインスタンスを返す
            $profiles = $stmt->fetch();  //ひとり抜き出し
            self::close_connection($pdo, $stmp);
            return $profiles;                    
        } catch (PDOException $e) {
            return 'PDO exception: ' . $e->getMessage();
                }
            }     
     
     //ログインチェック　メソッド
     public static function login($userID,$password){
         try{
                $pdo = self::get_connection();
                $stmt = $pdo -> prepare("SELECT * FROM users WHERE userID=:userID AND password=:password");
                $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                // フェッチの結果を、Userクラスのインスタンスにマッピングする
                $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
                // Userクラスのインスタンスを返す
                $user = $stmt->fetch();  
                self::close_connection($pdo, $stmp);
                return $user;                
         }catch(PDOException $e){
                return 'PDO exception: ' . $e->getMessage();
         }
     }
  }