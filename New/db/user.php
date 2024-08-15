<?php 
class User{
    private $db;
    function __construct($con){
        $this->db=$con;
    }
    function insertUser($user_id,$user_password){
        try{
            $result=$this->getUserByUserName($user_id);
            if($result["num"]>0){
                return false;
            }else{
                $new_password = md5($user_password.$user_id);
                $sql="INSERT INTO users(user_id,user_password) VALUES(:user_id,:user_password)";
                $stmt=$this->db->prepare($sql);
                $stmt->bindParam(":user_id",$user_id);
                $stmt->bindParam(":user_password",$new_password);
                $stmt->execute();
                return true;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    function getUserByUserName($user_id){
        try{
            $sql="SELECT COUNT(*) as num FROM users WHERE user_id=:user_id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":user_id",$user_id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    function getUser($user_id,$user_password){
        try{
            $sql="SELECT * FROM users WHERE user_id=:user_id AND user_password=:user_password";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":user_id",$user_id);
            $stmt->bindParam(":user_password",$user_password);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function insertdataUser($Name,$Student_id,$Bank_name,$Bank_account,$Telephone){
        try{
            $result=$this->getUserByUserName1($Student_id);
            if($result["num"]>0){
            return false;}
            else{
               $sql="INSERT INTO record1(Name,Student_id,Bank_name,Bank_account,Telephone) VALUES(:Name,:Student_id,:Bank_name,:Bank_account,:Telephone)";
                $stmt=$this->db->prepare($sql);
                $stmt->bindParam(":Name",$Name);
                $stmt->bindParam(":Student_id",$Student_id);
                $stmt->bindParam(":Bank_name",$Bank_name);
                $stmt->bindParam(":Bank_account",$Bank_account);
                $stmt->bindParam(":Telephone",$Telephone);
                $stmt->execute();
                return true;
            }
            }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function getUserByUserName1($Name){
        try{
            $sql="SELECT COUNT(*) as num FROM record1 WHERE Name=:Name";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":Name",$Name);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}

?>