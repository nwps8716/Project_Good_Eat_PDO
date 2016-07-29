<?php
class CRUD {
    
    public function pdogetUserdata_id($firstname,$lastname,$email,$id,$pw,$pw2){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from userdata where userid = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
        
        return $result;
    }
    
    public function pdoUserdata_id_pw($id,$pw){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from userdata where userid= :id AND password= :pw ;";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':pw', $pw);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
        
        return $result;
    }
    
    public function pdoinsertUserdata($firstname,$lastname,$email,$id,$pw,$pw2){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "insert into userdata(firstname, lastname, email, userid, password) values (?, ?, ?, ?, ?)";
    	$stmt = $pdo->prepare($sql);
    	
    	$stmt->bindValue(1,$firstname);
    	$stmt->bindValue(2,$lastname);
    	$stmt->bindValue(3,$email);
    	$stmt->bindValue(4,$id);
    	$stmt->bindValue(5,$pw);
    	
    	$result = $stmt->execute();
    	
    	$db->closeConnection();
    	
    	return $result;
    }
    
    public function signout() {
        unset($_SESSION['username']);
    }
    
    public function pdouploadArticle($title,$content,$user,$picture,$date){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "insert into fooddata (imgfile, title, content, date, user) value (:picture, :title, :content, :date, :user)";
    	$stmt = $pdo->prepare($sql);
    	
    	$stmt->bindValue(':picture',$picture);
    	$stmt->bindValue(':title',$title);
    	$stmt->bindValue(':content',$content);
    	$stmt->bindValue(':date',$date);
    	$stmt->bindValue(':user',$user);
    	
    	$result = $stmt->execute();
    	
    	$db->closeConnection();
    	
    	return $result;
    }
    
    public function pdodeleteArticle($id,$img) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql ="delete from fooddata where ID=:id"; 
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $db->closeConnection();
        
        return $result;
    }
    
    public function pdodeleteMessageboard($id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql ="delete from messageboard where ID =:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $db->closeConnection();
        
        return $result;
    }
    
    public function pdoupdateArticle($title,$content,$id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
	    $sql = "update fooddata set title=:title,content=:content where ID=:id ";
	    $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    return $result;
    }
    
    public function pdoupdatePicture($picture,$title,$content,$id) {
    	$db = new myPDO();
        $pdo = $db->getConnection();
    	$sql = "update fooddata set imgfile=:picture,title=:title,content=:content where ID=:id ";
        $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':picture',$picture);
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdouploadMessageboard($ID,$userID,$content,$date) {
        $db = new myPDO();
        $pdo = $db->getConnection();
	    $sql = "insert into messageboard (ID, content, date, user) value (:ID, :content, :date, :userID)";
	    $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':ID',$ID);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':date',$date);
	    $stmt->bindValue(':userID',$userID);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddata_DESC() {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from fooddata ORDER BY ID DESC";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
	    $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetPage($start,$per) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from fooddata ORDER BY ID DESC LIMIT :start, :per";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':per', $per, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
	    $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddata() {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from fooddata";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddataID($id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from fooddata where ID = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result;
    }
    
    public function pdogetMessageboardID($id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "select * from messageboard where ID = :id";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result;
    }
}
?>