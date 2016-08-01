<?php
class CRUD {
    
    public function pdogetUserdata_id($firstname,$lastname,$email,$id,$pw,$pw2){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `userdata` WHERE `userid` = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
        
        if($id != null && $pw != null && $pw2 != null && $result[4] != $id && $pw == $pw2) {
            $_SESSION['alert'] = "註冊成功";
            $result['alert'] = $_SESSION['alert'];
            return $result['alert'];
        }
        else if($pw != $pw2) { 
            $_SESSION['alert'] = "密碼確認是否一致";
        }
        else if($result[4] == $id) {
            $_SESSION['alert'] = "此帳號已有人註冊";
        }
        
    }
    
    public function pdoUserdata_id_pw($id,$pw){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `userdata` WHERE `userid`= :id AND `password`= :pw ;";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':pw', $pw);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
        
        if($id == null && $pw == null) {
            $_SESSION['alert'] = "請輸入帳號或密碼";    
            }
            else if ($result) {
                $_SESSION['username'] = $id;
                $_SESSION['alert'] = "登入成功";
                return $_SESSION['username'];
            }else{
                $_SESSION['alert'] = "帳號或密碼錯誤";
            }
    }
    
    public function signout() {
        unset($_SESSION['username']);
        $_SESSION['alert'] = "登出成功";
    }
    
    public function pdoinsertUserdata($firstname,$lastname,$email,$id,$pw,$pw2){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `userdata`(`firstname`, `lastname`, `email`, `userid`, `password`) VALUES (?, ?, ?, ?, ?)";
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
    
    public function pdouploadArticle($title,$content,$user,$picture,$date){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `fooddata` (`imgfile`, `title`, `content`, `date`, `user`) VALUES (:picture, :title, :content, :date, :user)";
    	$stmt = $pdo->prepare($sql);
    	
    	$stmt->bindValue(':picture',$picture);
    	$stmt->bindValue(':title',$title);
    	$stmt->bindValue(':content',$content);
    	$stmt->bindValue(':date',$date);
    	$stmt->bindValue(':user',$user);
    	
    	$result = $stmt->execute();
    	
    	$db->closeConnection();
    	
    	if($result>0) {
    	    $_SESSION['alert'] = "貼文新增成功";
    	    return $result;
    	}else{
    	    $_SESSION['alert'] = "貼文新增失敗";
        }
    }
    
    public function pdodeleteArticle($id,$img) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql ="DELETE FROM `fooddata` WHERE `ID`=:id"; 
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $db->closeConnection();
        
        $_SESSION['alert'] = "刪除成功";
        
        return $result;
    }
    
    public function pdodeleteMessageboard($id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql ="DELETE FROM `messageboard` WHERE `ID` =:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $db->closeConnection();
        
        $_SESSION['alert'] = "刪除成功";
        
        return $result;
    }
    
    public function pdoupdateArticle($title,$content,$id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
	    $sql = "UPDATE `fooddata` SET `title`=:title,`content`=:content WHERE `ID`=:id ";
	    $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    $_SESSION['alert'] = "文章修改成功";
	    
	    return $result;
    }
    
    public function pdoupdatePicture($picture,$title,$content,$id) {
    	$db = new myPDO();
        $pdo = $db->getConnection();
    	$sql = "UPDATE `fooddata` SET `imgfile`=':picture',`title`=':title',`content`=:content WHERE `ID`=:id ";
        $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':picture',$picture);
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    $_SESSION['alert'] = "文章修改成功";
	    
	    return $result; 
    }
    
    public function pdouploadMessageboard($ID,$userID,$content,$date) {
        $db = new myPDO();
        $pdo = $db->getConnection();
	    $sql = "INSERT INTO `messageboard` (`ID`, `content`, `date`, `user`) VALUES (:ID, :content, :date, :userID)";
	    $stmt = $pdo->prepare($sql);
	    
	    $stmt->bindValue(':ID',$ID);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':date',$date);
	    $stmt->bindValue(':userID',$userID);
	    
	    $result = $stmt->execute();
	    $db->closeConnection();
	    
	    if($result>0) {
    	    $_SESSION['alert'] = "留言成功";
    	    return $result;
        }else{
            $_SESSION['alert'] = "留言失敗";
        }
    }
    
    public function pdogetFooddata_DESC() {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `fooddata` ORDER BY `ID` DESC";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
	    $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetPage($start,$per) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `fooddata` ORDER BY `ID` DESC LIMIT :start, :per";
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
        $sql = "SELECT * FROM `fooddata`";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddataID($id) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `fooddata` WHERE `ID` = :id";
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
        $sql = "SELECT * FROM `messageboard` WHERE `ID` = :id";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result;
    }
    
}
?>