<?php
// user.php
class User{
    protected $db;
    protected $user_name;
    protected $user_email;
    protected $user_pass;
    protected $user_nick;
    protected $user_bday;
    protected $user_sex;
    protected $hash_pass;
    
    function __construct($db_connection){
        $this->db = $db_connection;
    }

    // SIGN UP USER
    function signUpUser($username, $email, $password, $nickName, $bday, $sex){
        try{
            $this->user_name = trim($username);
            $this->user_email = trim($email);
            $this->user_pass = trim($password);
            $this->user_nick = trim($nickName);
            $this->user_bday = trim($bday);
            $this->user_sex = trim($sex);

            if(!empty($this->user_name) && !empty($this->user_email) && !empty($this->user_pass) && !empty($this->user_nick) && !empty($this->user_bday) && isset($this->user_sex)){

                if (filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) { 
                    $check_email = $this->db->prepare("SELECT * FROM `users` WHERE user_email = ?");
                    $check_email->execute([$this->user_email]);

                    if($check_email->rowCount() > 0){
                        return ['errorMessage' => '此電子郵件已被註冊過，請選擇其他帳號。'];
                    }
                    else{
                        
                        $user_image = "default";

                        $this->hash_pass = password_hash($this->user_pass, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO `users` (username, user_email, user_password, nickname, bday, sex, user_image) VALUES(:username, :user_email, :user_pass, :nickname, :bday, :sex, :user_image)";
            
                        $sign_up_stmt = $this->db->prepare($sql);
                        // BIND VALUES
                        $sign_up_stmt->bindValue(':username', htmlspecialchars($this->user_name), PDO::PARAM_STR);
                        $sign_up_stmt->bindValue(':user_email', $this->user_email, PDO::PARAM_STR);
                        $sign_up_stmt->bindValue(':user_pass', $this->hash_pass, PDO::PARAM_STR);
                        $sign_up_stmt->bindValue(':nickname', htmlspecialchars($this->user_nick), PDO::PARAM_STR);
                        $sign_up_stmt->bindValue(':bday', $this->user_bday, PDO::PARAM_STR);
                        $sign_up_stmt->bindValue(':sex', $this->user_sex, PDO::PARAM_INT);
                        // INSERTING RANDOM IMAGE NAME
                        $sign_up_stmt->bindValue(':user_image', $user_image.'.jpg', PDO::PARAM_STR);
                        $sign_up_stmt->execute();
                        return ['successMessage' => '註冊成功！'];                   
                    }
                }
                else{
                    return ['errorMessage' => '無效的電子郵件。'];
                }    
            }
            else{
                return ['errorMessage' => '尚有資料未輸入完整。'];
            } 
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // LOGIN USER
    function loginUser($email, $password){
        
        try{
            $this->user_email = trim($email);
            $this->user_pass = trim($password);

            $find_email = $this->db->prepare("SELECT * FROM `users` WHERE user_email = ?");
            $find_email->execute([$this->user_email]);
            
            if($find_email->rowCount() === 1){
                $row = $find_email->fetch(PDO::FETCH_ASSOC);

                $match_pass = password_verify($this->user_pass, $row['user_password']);
                if($match_pass){
                    $_SESSION = [
                        'user_id' => $row['id'],
                        'email' => $row['user_email'],
                        'nickname' => $row['nickname']
                    ];
                    header('Location: profile.php');
                }
                else{
                    return ['errorMessage' => '密碼錯誤。'];
                }
                
            }
            else{
                return ['errorMessage' => '尚未註冊。'];
            }

        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    // FIND USER BY ID
    function find_user_by_id($id){
        try{
            $find_user = $this->db->prepare("SELECT * FROM `users` WHERE id = ?");
            $find_user->execute([$id]);
            if($find_user->rowCount() === 1){
                return $find_user->fetch(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    function all_users($id){
        try{
            $get_users = $this->db->prepare("SELECT id, username, user_image FROM `users` WHERE id != ?");
            $get_users->execute([$id]);
            if($get_users->rowCount() > 0){
                return $get_users->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                return false;
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
?>