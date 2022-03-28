<?php
class Voiture{
 
    // database connection and table name , we created this class as our kinda model
    private $conn;
    private $table_name = "voitures";
 
    // user properties 
    public $imma;
    public $cliname;
    public $model;
    public $mark;
    public $chassis;
    public $kilometrage;
    public $t1;
    public $t2;
    public $t3;
    public $last_his;
    public $SearchKit;
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
                imma,cliname,model,mark,chassis,kilometrage,niveau,last_his,created_at,updated_at
                FROM
                " . $this->table_name . " 
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function pagination($limit){
 
    // select all query
    $query = "SELECT
                imma,cliname,model,mark,chassis,kilometrage,niveau,created_at,updated_at
                FROM
                " . $this->table_name . " 
               
            ORDER BY
                created_at DESC
                LIMIT ".$limit.",6";

    
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
                imma=:imma, cliname=:cliname,chassis=:chassis,kilometrage=:kilometrage,model=:model,niveau=:niveau,mark=:mark,t1=:t1,t2=:t2,t3=:t3,last_his=null,created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->imma=htmlspecialchars(strip_tags($this->imma));
    $this->cliname=htmlspecialchars(strip_tags($this->cliname));
    $this->chassis=htmlspecialchars(strip_tags($this->chassis));
    $this->niveau=htmlspecialchars(strip_tags($this->niveau));
    $this->kilometrage=htmlspecialchars(strip_tags($this->kilometrage));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->t1=htmlspecialchars(strip_tags($this->t1));
    $this->t2=htmlspecialchars(strip_tags($this->t2));
    $this->t3=htmlspecialchars(strip_tags($this->t3));

    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":imma", $this->imma);
    $stmt->bindParam(":chassis", $this->chassis);
    $stmt->bindParam(":niveau", $this->niveau);
    $stmt->bindParam(":kilometrage", $this->kilometrage);
    $stmt->bindParam(":cliname", $this->cliname);
    $stmt->bindParam(":model", $this->model);
    $stmt->bindParam(":mark", $this->mark);
    $stmt->bindParam(":t1", $this->t1);
    $stmt->bindParam(":t2", $this->t2);
    $stmt->bindParam(":t3", $this->t3);

    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){

        return true;
    }
 
    return false;
     
}

function checkValability(){
    $query = "SELECT
    imma
    FROM
    " . $this->table_name . " 
           WHERE
           imma = ?
           LIMIT
           0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->imma);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
        return false;
     }
        return true;

}
function search(){
 
     // select user where id
     $query = "SELECT
     imma,cliname,model,mark,chassis,niveau,t1,t2,t3,kilometrage,last_his,created_at,updated_at
     FROM
     " . $this->table_name . " 
            WHERE
            imma = ?
            LIMIT
                0,1";
 
    // prepare query statement 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->imma);
    $stmt->execute();
 
    // get retrieved data of the user
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties in top
    $this->imma = $row['imma'];
    $this->cliname = $row['cliname'];
    $this->model = $row['model'];
    $this->niveau = $row['niveau'];
    $this->chassis = $row['chassis'];
    $this->t1 = $row['t1'];
    $this->t2 = $row['t2'];
    $this->t3 = $row['t3'];
    $this->last_his = $row['last_his'];

    $this->kilometrage = $row['kilometrage'];
    $this->mark = $row['mark'];
    $this->created_at = $row['created_at'];
    $this->updated_at = $row['updated_at'];

    
}


function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
                
            SET
             imma=:imma,
             cliname=:cliname,
             model=:model,
             mark=:mark,
             kilometrage=:kilometrage,
             chassis=:chassis,
             niveau=:niveau,
             t1=:t1,
             t2=:t2,
             t3=:t3,
             updated_at=:updated_at

            WHERE
                imma=:imma";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
   
    $this->imma=htmlspecialchars(strip_tags($this->imma));
    $this->cliname=htmlspecialchars(strip_tags($this->cliname));
    $this->niveau=htmlspecialchars(strip_tags($this->niveau));
    $this->kilometrage=htmlspecialchars(strip_tags($this->kilometrage));
    $this->chassis=htmlspecialchars(strip_tags($this->chassis));
    $this->mark=htmlspecialchars(strip_tags($this->mark));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->t1=htmlspecialchars(strip_tags($this->t1));
    $this->t2=htmlspecialchars(strip_tags($this->t2));
    $this->t3=htmlspecialchars(strip_tags($this->t3));

    $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));


    $stmt->bindParam(':imma', $this->imma);
    $stmt->bindParam(':model', $this->model);
    $stmt->bindParam(':cliname', $this->cliname);
    $stmt->bindParam(':niveau', $this->niveau);
    $stmt->bindParam(':chassis', $this->chassis);
    $stmt->bindParam(':kilometrage', $this->kilometrage);
    $stmt->bindParam(':mark', $this->mark);
    $stmt->bindParam(':t1', $this->t1);
    $stmt->bindParam(':t2', $this->t2);
    $stmt->bindParam(':t3', $this->t3);

    $stmt->bindParam(':updated_at', $this->updated_at);

    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


function updateOnly(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
                
            SET
           last_his=:last_his

            WHERE
                imma=:imma";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
   
    $this->imma=htmlspecialchars(strip_tags($this->imma));
    $this->last_his=htmlspecialchars(strip_tags($this->last_his));



    $stmt->bindParam(':imma', $this->imma);  
    $stmt->bindParam(':last_his', $this->last_his);

    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}





function searchbv(){
 
        // select all query
        $query = "SELECT
                    imma,cliname,chassis,created_at
                    FROM
                    " . $this->table_name . " 
                     WHERE
                     cliname = ?
                   
                ORDER BY
                    created_at asc";
       
        
        $stmt = $this->conn->prepare($query);
        $this->cliname=htmlspecialchars(strip_tags($this->cliname));
        $stmt->bindParam(1, $this->cliname);
        $stmt->execute();
       
        return $stmt;
       
}


function searchBCName(){
 
    // select all query
    $query = "SELECT
                imma
                FROM
                " . $this->table_name . " 
                 WHERE
                 cliname = ?";
   
    
    $stmt = $this->conn->prepare($query);
    $this->cliname=htmlspecialchars(strip_tags($this->cliname));
    $stmt->bindParam(1, $this->cliname);
    $stmt->execute();
   
    return $stmt;
   
}

function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE imma = ?";
    $stmt = $this->conn->prepare($query);
 
    $this->imma=htmlspecialchars(strip_tags($this->imma));
    $stmt->bindParam(1, $this->imma);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function BackUpSearch(){
 
    // select all query
    $query = "SELECT
             imma,cliname,model,mark,chassis,niveau,t1,t2,t3,kilometrage,last_his,created_at,updated_at
                FROM
                " . $this->table_name . " 
               where imma LIKE ? or lower(cliname) LIKE lower(?)
            
           ";

    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->SearchKit);
    $stmt->bindParam(2, $this->SearchKit);

    $stmt->execute();
 
    return $stmt;
}


function SearchPagination($limit){
 
    // select all query
    $query = "SELECT
             imma,cliname,model,mark,chassis,niveau,t1,t2,t3,kilometrage,last_his,created_at,updated_at
                FROM
                " . $this->table_name . " 
               where imma LIKE ? or lower(cliname) LIKE lower(?)
            
               ORDER BY
               created_at DESC
               LIMIT ".$limit.",6 ";

    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->SearchKit);
    $stmt->bindParam(2, $this->SearchKit);

    $stmt->execute();
 
    return $stmt;
}


}