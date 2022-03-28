<?php
class Admin{
 
    // database connection and table name , we created this class as our kinda model
    private $conn;
    private $table_name = "admins";
    // user properties 
    public $id;
    public $etat;
    public $password;
    public $phone;
    public $username;
    public $email;
    public $token;

    public $email_confirmed;
    public $account_activated;
    public $created_at;

 
    // constructor with $db as database connection 
    public function __construct($db){
        $this->conn = $db;
    }
function checkValability(){
    $query = "SELECT
    id,password,username,etat
    FROM
    " . $this->table_name . " 
           WHERE
               username = ? 
           LIMIT
               0,1";

               $stmt = $this->conn->prepare( $query );
               $this->username=htmlspecialchars(strip_tags($this->username));
               $stmt->bindParam(1, $this->username);
               $stmt->execute();
               $num = $stmt->rowCount();
               if($num>0){
                   
               return false;
            }
               return true;
}

function searchEmail(){ // select user where id
    $query = "SELECT
    id,password,username,etat
    FROM
    " . $this->table_name . " 
           WHERE
               username = ? and account_activated='activated' and email_confirmed='confirmed'
           LIMIT
               0,1";
   
   // prepare query statement 
   $stmt = $this->conn->prepare( $query );
   $this->username=htmlspecialchars(strip_tags($this->username));
   $stmt->bindParam(1, $this->username);
   $stmt->execute();
   $num = $stmt->rowCount();
   if($num>0){
   // get retrieved data of the user
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   // set values to object properties in top
   $this->id = $row['id'];
   $this->password = $row['password'];
   $this->etat = $row['etat'];
   $this->username = $row['username'];
   return true;
   }
   return false;

}
function searchByEmail(){ // select user where id
    $query = "SELECT
    id,password,username,etat,email,token
    FROM
    " . $this->table_name . " 
           WHERE
               email = ? and account_activated='activated' and email_confirmed='confirmed'
           LIMIT
               0,1";
   
   // prepare query statement 
   $stmt = $this->conn->prepare( $query );
   $this->email=htmlspecialchars(strip_tags($this->email));
   $stmt->bindParam(1, $this->email);
   $stmt->execute();
   $num = $stmt->rowCount();
   if($num>0){
   // get retrieved data of the user
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   // set values to object properties in top
   $this->id = $row['id'];
   $this->password = $row['password'];
   $this->etat = $row['etat'];
   $this->token = $row['token'];

   $this->username = $row['username'];
   return true;
   }
   return false;

}
function search(){ // select user where id
    $query = "SELECT
    id,username,email,phone,etat,account_activated,email_confirmed
    FROM
    " . $this->table_name . " 
           WHERE
               id = ? 
           LIMIT
               0,1";
   
   // prepare query statement 
   $stmt = $this->conn->prepare( $query );
   $this->id=htmlspecialchars(strip_tags($this->id));
   $stmt->bindParam(1, $this->id);
   $stmt->execute();
   $num = $stmt->rowCount();
   if($num>0){
   // get retrieved data of the user
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   // set values to object properties in top
   $this->id = $row['id'];
   $this->email = $row['email'];
   $this->username = $row['username'];
   $this->etat = $row['etat'];
   $this->phone = $row['phone'];
   $this->account_activated = $row['account_activated'];
   $this->email_confirmed = $row['email_confirmed'];

   return true;
   }
   return false;

}

function searchId($TheID){ // select user where id
    $query = "SELECT
    id,username,email,phone,etat
    FROM
    " . $this->table_name . " 
           WHERE
               id = ? 
           LIMIT
               0,1";
   
   // prepare query statement 
   $stmt = $this->conn->prepare( $query );
   $stmt->bindParam(1, $TheID);
   $stmt->execute();
  
   return $stmt;

}
function Lookup($email,$token){ // select user where id
    $query = "SELECT
    id,username,email,phone,etat
    FROM
    " . $this->table_name . " 
           WHERE
               email = ? and  token = ?
           LIMIT
               0,1";
   
   // prepare query statement 
   $stmt = $this->conn->prepare( $query );
   $stmt->bindParam(1, $email);
   $stmt->bindParam(2, $token);

   $stmt->execute();
  
   return $stmt;

}

function verificationEm(){
 
    //  insert statement 
    $query = "UPDATE
                " . $this->table_name . "
            SET
            email_confirmed='confirmed'
               
               WHERE email=? and token=?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
 
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->token=htmlspecialchars(strip_tags($this->token));
   
    // bind values from the insert statement 

    $stmt->bindParam(1, $this->email);
    $stmt->bindParam(2, $this->token);
   
    // $stmt->bindParam('is', $this->email, $this->etat,$this->phone,$this->password,$this->id);

    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}



function verifyPass($pass1,$pass2){
    if ( $pass1 == $pass2){
        return true;
    }
return false;
}



function update(){
 
    //  insert statement 
    $query = "UPDATE
                " . $this->table_name . "
            SET
               email=?, etat=?,phone=?, password=?
               
               WHERE id=?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
 
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->etat=htmlspecialchars(strip_tags($this->etat));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->password=htmlspecialchars(strip_tags($this->password));
 
    // bind values from the insert statement 

    $stmt->bindParam(1, $this->email);
    $stmt->bindParam(3, $this->phone);
    $stmt->bindParam(2, $this->etat);
    $stmt->bindParam(4, $this->password);
    $stmt->bindParam(5, $this->id);
    // $stmt->bindParam('is', $this->email, $this->etat,$this->phone,$this->password,$this->id);

    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}

function smolCreate(){
 
    //  insert statement 
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username=:username, email=:email, etat=:etat, token=:token,password=:password, email_confirmed=:email_confirmed, account_activated=:account_activated, created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->etat=htmlspecialchars(strip_tags($this->etat));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->token=htmlspecialchars(strip_tags($this->token));

    $this->account_activated=htmlspecialchars(strip_tags($this->account_activated));
    $this->email_confirmed=htmlspecialchars(strip_tags($this->email_confirmed));

    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":etat", $this->etat);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":token", $this->token);

    $stmt->bindParam(":account_activated", $this->account_activated);
    $stmt->bindParam(":email_confirmed", $this->email_confirmed);

    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}
function create(){
 
    //  insert statement 
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username=:username, email=:email, etat=:etat,phone=:phone, token=:token,password=:password, email_confirmed='confirmed', account_activated='activated', created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->etat=htmlspecialchars(strip_tags($this->etat));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->token=htmlspecialchars(strip_tags($this->token));


    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":etat", $this->etat);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":token", $this->token);


    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}
function allAdmin(){
    $query="SELECT email,username FROM  " . $this->table_name . " 
    where account_activated='activated' and email_confirmed='confirmed' and etat='admin' ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function read(){
 
    // select all query
    $query = "SELECT
               id,username,password,email,phone,etat,email_confirmed,account_activated,created_at
                FROM
                " . $this->table_name . " 
                where account_activated='activated' and email_confirmed='confirmed'
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function pendingUsers(){
 
    // select all query
    $query = "SELECT
               id,username,password,email,phone,etat,email_confirmed,account_activated,token,created_at
                FROM
                " . $this->table_name . " 
                where account_activated='pending' and email_confirmed='confirmed'
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
 
    $stmt->bindParam(1, $this->id);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}









function updatePassword(){
 
    //  insert statement 
    $query = "UPDATE
                " . $this->table_name . "
            SET
               password=?
               
               WHERE email=? and token=?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
 
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->token=htmlspecialchars(strip_tags($this->token));
    $this->password=htmlspecialchars(strip_tags($this->password));

    // bind values from the insert statement 

    $stmt->bindParam(1, $this->password);
    $stmt->bindParam(2, $this->email);
    $stmt->bindParam(3, $this->token);

    // $stmt->bindParam('is', $this->email, $this->etat,$this->phone,$this->password,$this->id);

    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}
function activate(){
 
    //  insert statement 
    $query = "UPDATE
                " . $this->table_name . "
            SET
               account_activated='activated'
               
               WHERE id=? ";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
 
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind values from the insert statement 

    $stmt->bindParam(1, $this->id);

    // $stmt->bindParam('is', $this->email, $this->etat,$this->phone,$this->password,$this->id);

    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}


}