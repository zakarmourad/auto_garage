<?php
class Famille{
 
    // database connection and table name , we created this class as our kinda model
    private $conn;
    private $table_name = "familles";
 
    // user properties 
    public $id;
    public $voiture_imma;
    public $sfam;
    public $fam;
    public $created_at;
    public $updated_at;

 
    // constructor with $db as database connection 
    public function __construct($db){
        $this->conn = $db;
    }
    // read users will be used to select all users 
function read(){
 
    // select all query
    $query = "SELECT
                id,voiture_imma,sfam,fam,created_at,updated_at
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
                voiture_imma=:voiture_imma, sfam=:sfam,fam=:fam,created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->voiture_imma=htmlspecialchars(strip_tags($this->voiture_imma));
    $this->sfam=htmlspecialchars(strip_tags($this->sfam));
    $this->fam=htmlspecialchars(strip_tags($this->fam));
    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":voiture_imma", $this->voiture_imma);   
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
     id,voiture_imma,sfam,fam,created_at,updated_at
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
    $this->voiture_imma = $row['voiture_imma'];
    $this->sfam = $row['sfam'];
    $this->fam = $row['fam'];

    $this->created_at = $row['created_at'];

    
}


    // read users will be used to select all users 
    function readAll(){
 
        // select all query
        $query = "SELECT
                    id,voiture_imma,sfam,fam,created_at,updated_at
                    FROM
                    " . $this->table_name . " 
                     WHERE
                     voiture_imma = ?
                   
                ORDER BY
                    created_at DESC";
    
        
                    $stmt = $this->conn->prepare( $query );
                    $stmt->bindParam(1, $this->voiture_imma);
                    $stmt->execute();
     
        return $stmt;
    }

    function update(){
 
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                    
                SET
                 voiture_imma=:voiture_imma,
                 sfam=:sfam,
                 fam=:fam,
                 updated_at=:updated_at
    
                WHERE
                    voiture_imma=:voiture_imma";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
       
        $this->voiture_imma=htmlspecialchars(strip_tags($this->voiture_imma));
        $this->sfam=htmlspecialchars(strip_tags($this->sfam));
        $this->fam=htmlspecialchars(strip_tags($this->fam));
        $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));
    
    
        $stmt->bindParam(':voiture_imma', $this->voiture_imma);
        $stmt->bindParam(':fam', $this->fam);
        $stmt->bindParam(':sfam', $this->sfam);
        $stmt->bindParam(':updated_at', $this->updated_at);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    function delete(){
        $query = " DELETE FROM  " . $this->table_name . " WHERE voiture_imma=:voiture_imma";
          // prepare query statement
          $stmt = $this->conn->prepare($query);
          $this->voiture_imma=htmlspecialchars(strip_tags($this->voiture_imma));
          $stmt->bindParam(':voiture_imma', $this->voiture_imma);
      // execute the query
      if($stmt->execute()){
        return true;
    }
    
    return false;
    
    }
}