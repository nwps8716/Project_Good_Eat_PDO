<?php
class CRUD {
    
    public $dbcon;
    public $dbpdo;
    
    
    function __construct(){
        $this->dbpdo = new myPDO();
        $this->dbcon = $this->dbpdo->getConnection();
    }
    
    // 第二種方法
    // public function pdogetUserdata_id($firstname,$lastname,$email,$id,$pw,$pw2){
    //     $db = new myPDO();
    //     $sql = "SELECT * FROM `userdata` WHERE id = :id";
    //     $paramArray = array(":id" => $id );
    //     $result = $db->doSelect($sql, $paramArray);
        
    //     if($id != null && $pw != null && $pw2 != null && $result[4] != $id && $pw == $pw2) {
    //         $_SESSION['alert'] = "註冊成功";
    //         $result['alert'] = $_SESSION['alert'];
    //         return $result['alert'];
    //     }
    //     else if($pw != $pw2) { 
    //         $_SESSION['alert'] = "密碼確認是否一致";
    //     }
    //     else if($result[4] == $id) {
    //         $_SESSION['alert'] = "此帳號已有人註冊";
    //     }
    // }
    
    public function pdogetUserdata_id($firstname,$lastname,$email,$id,$pw,$pw2){
        
        $sql = "SELECT * FROM `userdata` WHERE `userid` = :id";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $this->dbpdo->closeConnection();
        
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
        
        $sql = "SELECT * FROM `userdata` WHERE `userid`= :id AND `password`= :pw ;";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':pw', $pw);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $this->dbpdo->closeConnection();
        
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
        
        $sql = "INSERT INTO `userdata`(`firstname`, `lastname`, `email`, `userid`, `password`) VALUES (?, ?, ?, ?, ?)";
    	$stmt = $this->dbcon->prepare($sql);
    	
    	$stmt->bindValue(1,$firstname);
    	$stmt->bindValue(2,$lastname);
    	$stmt->bindValue(3,$email);
    	$stmt->bindValue(4,$id);
    	$stmt->bindValue(5,$pw);
    	
    	$result = $stmt->execute();
    	
    	$this->dbpdo->closeConnection();
    	
    	return $result;
    }
    
    public function pdouploadArticle($title,$content,$user,$picture,$date){
        
        $sql = "INSERT INTO `fooddata` (`imgfile`, `title`, `content`, `date`, `user`) VALUES (:picture, :title, :content, :date, :user)";
    	$stmt = $this->dbcon->prepare($sql);
    	
    	$stmt->bindValue(':picture',$picture);
    	$stmt->bindValue(':title',$title);
    	$stmt->bindValue(':content',$content);
    	$stmt->bindValue(':date',$date);
    	$stmt->bindValue(':user',$user);
    	
    	$result = $stmt->execute();
    	
    	$this->dbpdo->closeConnection();
    	
    	if($result>0) {
    	    $_SESSION['alert'] = "貼文新增成功";
    	    return $result;
    	}else{
    	    $_SESSION['alert'] = "貼文新增失敗";
        }
    }
    
    public function pdodeleteArticle($id,$img) {
        
        $sql ="DELETE FROM `fooddata` WHERE `ID`=:id"; 
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $this->dbpdo->closeConnection();
        
        $_SESSION['alert'] = "刪除成功";
        
        return $result;
    }
    
    public function pdodeleteMessageboard($id) {
        
        $sql ="DELETE FROM `messageboard` WHERE `ID` =:id";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $result = $stmt->execute();
        $this->dbpdo->closeConnection();
        
        $_SESSION['alert'] = "刪除成功";
        
        return $result;
    }
    
    public function pdoupdateArticle($title,$content,$id) {
        
	    $sql = "UPDATE `fooddata` SET `title`=:title,`content`=:content WHERE `ID`=:id ";
	    $stmt = $this->dbcon->prepare($sql);
	    
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $this->dbpdo->closeConnection();
	    
	    $_SESSION['alert'] = "文章修改成功";
	    
	    return $result;
    }
    
    public function pdoupdatePicture($picture,$title,$content,$id) {
    	
    	$sql = "UPDATE `fooddata` SET `imgfile`=':picture',`title`=':title',`content`=:content WHERE `ID`=:id ";
        $stmt = $this->dbcon->prepare($sql);
	    
	    $stmt->bindValue(':picture',$picture);
	    $stmt->bindValue(':title',$title);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':id',$id);
	    
	    $result = $stmt->execute();
	    $this->dbpdo->closeConnection();
	    
	    $_SESSION['alert'] = "文章修改成功";
	    
	    return $result; 
    }
    
    public function pdouploadMessageboard($ID,$userID,$content,$date) {
        
	    $sql = "INSERT INTO `messageboard` (`ID`, `content`, `date`, `user`) VALUES (:ID, :content, :date, :userID)";
	    $stmt = $this->dbcon->prepare($sql);
	    
	    $stmt->bindValue(':ID',$ID);
	    $stmt->bindValue(':content',$content);
	    $stmt->bindValue(':date',$date);
	    $stmt->bindValue(':userID',$userID);
	    
	    $result = $stmt->execute();
	    $this->dbpdo->closeConnection();
	    
	    if($result>0) {
    	    $_SESSION['alert'] = "留言成功";
    	    return $result;
        }else{
            $_SESSION['alert'] = "留言失敗";
        }
    }
    
    public function pdogetFooddata_DESC() {
        
        $sql = "SELECT * FROM `fooddata` ORDER BY `ID` DESC";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
	    $this->dbpdo->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetPage($start,$per) {
        
        $sql = "SELECT * FROM `fooddata` ORDER BY `ID` DESC LIMIT :start, :per";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':per', $per, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
	    $this->dbpdo->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddata() {
        
        $sql = "SELECT * FROM `fooddata`";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result; 
    }
    
    public function pdogetFooddataID($id) {
        
        $sql = "SELECT * FROM `fooddata` WHERE `ID` = :id";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result;
    }
    
    public function pdogetMessageboardID($id) {
        
        $sql = "SELECT * FROM `messageboard` WHERE `ID` = :id";
        
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->bindValue(':id',$id);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result;
    }
    
}
?>