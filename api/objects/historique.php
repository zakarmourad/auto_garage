<?php
class Historique{
 
    // database connection and table name , we created this class as our kinda model
    private $conn;
    private $table_name = "historique_v";
 
    // user properties 
    public $id;
    public $last_id;
    public $voiture_imma;
    public $cliname;
    public $model;
    public $mark;
    public $chassis;
    public $kilometrage;
    public $t1;
    public $t2;
    public $t3;
    public $modification_status;
    public $created_at;
    public $regulars;
 
    // constructor with $db as database connection 
    public function __construct($db){
        $this->conn = $db;
    }
    // read users will be used to select all users 
function read(){
 
    // select all query
    $query = "SELECT
                id,voiture_imma,cliname,model,mark,chassis,kilometrage,niveau,modification_status,created_at
                FROM
                " . $this->table_name . " 
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function his(){
 
    // select all query
    $query = "SELECT
                id,voiture_imma,cliname,chassis,created_at
                FROM
                " . $this->table_name . " 
                 WHERE
                 voiture_imma= ?
               
            ORDER BY
                created_at asc";

    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->voiture_imma);
    $stmt->execute();
 
    return $stmt;
}
function pagination($limit){
 
    // select all query
    $query = "SELECT
                id,voiture_imma,cliname,model,mark,chassis,kilometrage,niveau,created_at
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
                voiture_imma=:voiture_imma, cliname=:cliname,chassis=:chassis,kilometrage=:kilometrage,model=:model,niveau=:niveau,mark=:mark,t1=:t1,t2=:t2,t3=:t3,modification_status=:modification_status,created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->voiture_imma=htmlspecialchars(strip_tags($this->voiture_imma));
    $this->cliname=htmlspecialchars(strip_tags($this->cliname));
    $this->chassis=htmlspecialchars(strip_tags($this->chassis));
    $this->niveau=htmlspecialchars(strip_tags($this->niveau));
    $this->kilometrage=htmlspecialchars(strip_tags($this->kilometrage));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->t1=htmlspecialchars(strip_tags($this->t1));
    $this->t2=htmlspecialchars(strip_tags($this->t2));
    $this->t3=htmlspecialchars(strip_tags($this->t3));
    $this->modification_status=htmlspecialchars(strip_tags($this->modification_status));

    
    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
    $stmt->bindParam(":voiture_imma", $this->voiture_imma);
    $stmt->bindParam(":chassis", $this->chassis);
    $stmt->bindParam(":niveau", $this->niveau);
    $stmt->bindParam(":kilometrage", $this->kilometrage);
    $stmt->bindParam(":cliname", $this->cliname);
    $stmt->bindParam(":model", $this->model);
    $stmt->bindParam(":mark", $this->mark);
    $stmt->bindParam(":t1", $this->t1);
    $stmt->bindParam(":t2", $this->t2);
    $stmt->bindParam(":t3", $this->t3);
    $stmt->bindParam(":modification_status", $this->modification_status);

    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){
        $this->last_id = $this->conn->lastInsertId();

        return true;
    }
 
    return false;
     
}
function Regulars(){
    $query = "SELECT
                COUNT(*) as regs
    FROM
    " . $this->table_name . " 
           WHERE
           cliname= ? ";

               $stmt = $this->conn->prepare( $query );
               $stmt->bindParam(1, $this->cliname);
               $stmt->execute();
            
               // get retrieved data of the user
               $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
               // set values to object properties in top
               $this->regulars = $row['regs'];
              

}
function search(){
 
     // select user where id
     $query = "SELECT
     id,voiture_imma,cliname,model,mark,chassis,niveau,t1,t2,t3,kilometrage,created_at
     FROM
     " . $this->table_name . " 
            WHERE
            id= ?
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
    $this->t1 = $row['t1'];
    $this->t2 = $row['t2'];
    $this->t3 = $row['t3'];

    $this->cliname = $row['cliname'];
    $this->model = $row['model'];
    $this->niveau = $row['niveau'];
    $this->chassis = $row['chassis'];
    $this->kilometrage = $row['kilometrage'];
    $this->mark = $row['mark'];
    $this->created_at = $row['created_at'];

    
}

function updating(){

// update query
    $query = "UPDATE
                " . $this->table_name . "
                
            SET
             voiture_imma=:voiture_imma,
             cliname=:cliname,
             model=:model,
             mark=:mark,
             kilometrage=:kilometrage,
             chassis=:chassis,
             niveau=:niveau,
             t1=:t1,
             t2=:t2,
             t3=:t3,
             modification_status=:modification_status

            WHERE
               id=:id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->voiture_imma=htmlspecialchars(strip_tags($this->voiture_imma));
    $this->cliname=htmlspecialchars(strip_tags($this->cliname));
    $this->niveau=htmlspecialchars(strip_tags($this->niveau));
    $this->kilometrage=htmlspecialchars(strip_tags($this->kilometrage));
    $this->chassis=htmlspecialchars(strip_tags($this->chassis));
    $this->mark=htmlspecialchars(strip_tags($this->mark));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->t1=htmlspecialchars(strip_tags($this->t1));
    $this->t2=htmlspecialchars(strip_tags($this->t2));
    $this->t3=htmlspecialchars(strip_tags($this->t3));
    $this->modification_status=htmlspecialchars(strip_tags($this->modification_status));


    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':voiture_imma', $this->voiture_imma);
    $stmt->bindParam(':model', $this->model);
    $stmt->bindParam(':cliname', $this->cliname);
    $stmt->bindParam(':niveau', $this->niveau);
    $stmt->bindParam(':chassis', $this->chassis);
    $stmt->bindParam(':kilometrage', $this->kilometrage);
    $stmt->bindParam(':mark', $this->mark);
    $stmt->bindParam(':t1', $this->t1);
    $stmt->bindParam(':t2', $this->t2);
    $stmt->bindParam(':t3', $this->t3);
    $stmt->bindParam(':modification_status', $this->modification_status);


    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}