<?php
 
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password, $image) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, image, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $uuid, $name, $email, $image, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            $stmt->bind_result($id, $unique_id, $name, $email, $image, $encrypted_password, $salt, $created_at, $updated_at);
            $stmt->fetch();
            $user = array('id'=>$id,'unique_id'=>$unique_id,'name'=>$name,'email'=>$email,'image'=>$image,'encrypted_password'=>$encrypted_password,'salt' => $salt,'created_at' => $created_at,'updated_at' =>$updated_at);

            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
        // added
        if($stmt->execute()){
            $stmt->bind_result($id, $unique_id, $name, $email, $image, $encrypted_password, $salt, $created_at, $updated_at);
            $stmt->fetch();
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                 $user = array('id'=>$id,'unique_id'=>$unique_id,'name'=>$name,'email'=>$email,'image'=>$image,'encrypted_password'=>$encrypted_password,'salt' => $salt,'created_at' => $created_at,'updated_at' =>$updated_at);
                 $stmt->close();
                return $user;
            }
            $stmt->close();
            return NULL;

        }else {
            return NULL;
        }

 

        // //Previous
        // if ($stmt->execute()) {
        //     $user = $stmt->get_result()->fetch_assoc();
        //     $stmt->close();
 
        //     // verifying user password
        //     $salt = $user['salt'];
        //     $encrypted_password = $user['encrypted_password'];
        //     $hash = $this->checkhashSSHA($salt, $password);
        //     // check for password equality
        //     if ($encrypted_password == $hash) {
        //         // user authentication details are correct
        //         return $user;
        //     }
        // } else {
        //     return NULL;
        // }
    }

    /**
     * Get user by email and password
     */
    public function getFbUserByEmail($email) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users_fb WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $stmt->bind_result($id, $unique_id, $name, $email, $image, $created_at, $updated_at);
            $stmt->fetch();
            $user = array('id'=>$id,'unique_id'=>$unique_id,'name'=>$name,'email'=>$email,'image'=>$image,'created_at' => $created_at,'updated_at' =>$updated_at);
            
                return $user;
            
        } else {
            return NULL;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Check fb user is existed or not
     */
    public function isFbUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users_fb WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }

     /**
     * Storing new fb user
     * returns user details
     */
    public function storeFbUser($uid, $name, $email, $image) {
 
        $stmt = $this->conn->prepare("INSERT INTO users_fb(unique_id, name, email, image, created_at) VALUES(?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $uid, $name, $email, $image);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users_fb WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $unique_id, $name, $email, $image, $created_at, $updated_at);
            $stmt->fetch();
            $user = array('id'=>$id,'unique_id'=>$unique_id,'name'=>$name,'email'=>$email,'image'=>$image,'created_at' => $created_at,'updated_at' =>$updated_at);
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
 
}
 
?>