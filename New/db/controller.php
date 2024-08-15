<?php 
class Controller{
    private $db;

    function __construct($con){
        $this->db=$con;
    }


    function delete($id){
        try{
            $sql="DELETE FROM record WHERE id=:id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    function getEmployeeDetail(){
        try{
            $sql="SELECT * FROM record"; 
            $result=$this->db->query($sql); 
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function delete1($id){
        try{
            $sql="DELETE FROM record1 WHERE id=:id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

}

function getEmployeeDetail($id){
    try{
        $sql="SELECT * FROM record1 WHERE id=:id";
        $stmt=$this->db->prepare($sql);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}



?>