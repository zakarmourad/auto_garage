<?php
class Client{
 
    // database connection and table name , we created this class as our kinda tel
    private $conn;
    private $table_name = "clients";
 
    // user properties 
    public $id;
    public $name;
    public $tel;
    public $contact;
    public $etat;
    public $count;
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
                id,name,tel,contact,etat,created_at,updated_at
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
             clients.id, clients.name,clients.tel,clients.contact,clients.etat,clients.created_at,COUNT(historique_v.cliname) AS Total
              FROM clients LEFT JOIN historique_v ON clients.name = historique_v.cliname 
              GROUP BY clients.id, clients.name,clients.tel,clients.contact,clients.etat,clients.created_at 
              order by Total desc
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
                name=:name,etat=:etat,tel=:tel,contact=:contact,created_at=:created_at";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // this one is for security issues 
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->etat=htmlspecialchars(strip_tags($this->etat));
    $this->tel=htmlspecialchars(strip_tags($this->tel));
    $this->contact=htmlspecialchars(strip_tags($this->contact));
    $this->created_at=htmlspecialchars(strip_tags($this->created_at));
 
    // bind values from the insert statement 
  
    $stmt->bindParam(":etat", $this->etat);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":tel", $this->tel);
    $stmt->bindParam(":contact", $this->contact);
    $stmt->bindParam(":created_at", $this->created_at);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
function search(){
 
     // select user where id
     $query = "SELECT
     id,name,tel,contact,etat,created_at,updated_at
     FROM
     " . $this->table_name . " 
            WHERE
            LOWER(name) LIKE LOWER(?)
            LIMIT
                0,1";
 
    // prepare query statement 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->name);
    $stmt->execute();
 
    // get retrieved data of the user
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties in top
    if(!empty($row)){
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->tel = $row['tel'];
        $this->etat = $row['etat'];
        $this->contact = $row['contact'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }
 

    
}


function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
                
            SET
             tel=:tel,
             contact=:contact,
             etat=:etat,
             updated_at=:updated_at

            WHERE
                id=:id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
   
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->etat=htmlspecialchars(strip_tags($this->etat));
    $this->contact=htmlspecialchars(strip_tags($this->contact));
    $this->tel=htmlspecialchars(strip_tags($this->tel));
    $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));


    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':tel', $this->tel);
    $stmt->bindParam(':etat', $this->etat);
    $stmt->bindParam(':contact', $this->contact);
    $stmt->bindParam(':updated_at', $this->updated_at);

    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function list(){
 
    // select all query
    $query = "SELECT
                name
                FROM
                " . $this->table_name . " 
               
            ORDER BY
                created_at DESC";

    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
}
function count(){
 
    // select all query
    $query = "SELECT
                count(*) AS  cae
                FROM
               voitures
               WHERE 
               cliname = ?

            LIMIT
                0,1";
 
    // prepare query statement 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->name);
    $stmt->execute();
 

    // get retrieved data of the user
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties in top
    $this->count = $row['cae'];

}
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
 
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}


function checkValability(){

    $query = "SELECT
    name
    FROM
    " . $this->table_name . " 
           WHERE
           name = ?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->name);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
        return false;
     }
        return true;

}

function searchByID(){
 
    // select user where id
    $query = "SELECT
    id,name,tel,contact,etat
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
   $this->name = $row['name'];
   $this->tel = $row['tel'];
   $this->etat = $row['etat'];
   $this->contact = $row['contact'];

   
}


}