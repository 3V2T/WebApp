<?php
    class User {
        public $id;
        public $username;
        public $password;
        /*
                phương thức khởi tạo constructor
            */ 
            public function __construct($username,$password)
            {
                $this->username = $username;
                $this->password = $password;
                
            }

        public static function authenticate($conn, $username, $password) {
    

            // query the database
            $sql = 'select * from users where username=:username';
            // validate the query
            $stmt = $conn->prepare($sql);
            $stmt = $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            // Just return with exact attributes defined previous
            $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');
            $stmt -> execute();
            $user = $stmt -> fetch();

            if($user) {
                $hash = $user -> password;
                return password_verify($password, $hash);
            }
            

        }
        protected function validate(){
            $rs = $this->username != '' && $this->password != '';
            return $rs;
        }
        public function addUser($conn){
            if($this->validate()){
                //tạo câu lệnh insert chống SQL injection
                $sql = "Insert into users(username, password) values(:username, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username',$this->username, PDO::PARAM_STR);
                $hash = password_hash($this->password,PASSWORD_DEFAULT);
                $stmt->bindValue(':password',$hash,PDO::PARAM_STR);
                return  $stmt->execute();
            }else{
                return false;
            }
        }
    }