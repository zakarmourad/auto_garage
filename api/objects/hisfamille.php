<?php
class Historiquef{
 
    // database connection and table name , we created this class as our kinda model
    private $conn;
    private $table_name = "historique_f";
 
    // user properties 
    public $id;
    public $his_id;
    public $sfam;
    public $fam;
    public $created_at;

 
    // constructor with $db as database connection 
    public function __construct($db){
        $this->conn = $db;
    }
    // read users will be used to select all users 
function read(){
 
    // select all query
    $query = "SELECT
                id,his_id,sfam,fam,created_at
                FROM
                " . $this->table_name . " 
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}

// create a new  user
function create(){
 
    //  insert statement 
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                his_id=:his_id, sfam=:sfam,fam=:fam,created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->his_id=htmlspecialchars(strip_tags($this->his_id));
    $this->sfam=htmlspecialchars(strip_tags($this->sfam));
    $this->fam=htmlspecialchars(strip_tags($this->fam));
    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":his_id", $this->his_id);   
    $stmt->bindParam(":sfam", $this->sfam);
    $stmt->bindParam(":fam", $this->fam);

    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
function search(){
 
     // select user where id
     $query = "SELECT
     id,his_id,sfam,fam,created_at
     FROM
     " . $this->table_name . " 
            WHERE
            id = ?
            LIMIT
                0,1";
 
    // prepare query statement 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
 
    // get retrieved data of the user
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties in top
    $this->id = $row['id'];
    $this->his_id = $row['his_id'];
    $this->sfam = $row['sfam'];
    $this->fam = $row['fam'];
    $this->created_at = $row['created_at'];

    
}

function readAll(){
 
    // select all query
    $query = "SELECT
                id,his_id,sfam,fam,created_at
                FROM
                " . $this->table_name . " 
                 WHERE
                 his_id = ?
               
            ORDER BY
                created_at DESC";

    
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(1, $this->his_id);
                $stmt->execute();
    return $stmt;
}

function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE his_id = ?";
    $stmt = $this->conn->prepare($query);
 
    $this->his_id=htmlspecialchars(strip_tags($this->his_id));
    $stmt->bindParam(1, $this->his_id);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

}