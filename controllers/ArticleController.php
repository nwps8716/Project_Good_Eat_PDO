<?php
class ArticleController extends Controller {
    
    //上傳文章
    function upload() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST['uploadcontent'])) {
            date_default_timezone_set('Asia/Taipei');  //Cloud9上面的時間是格林威治的時間
            $date = date("Y.m.d");
            
            $title = $_POST["uploadtitle"];
        	$content = $_POST["uploadcontent"];
        	$user = $_POST['userid'];
        	
        	$picture = $_FILES["uploadfileimage"]["name"];
        	move_uploaded_file($_FILES["uploadfileimage"]["tmp_name"],"views/img/".$_FILES["uploadfileimage"]["name"]);
        	
        	$row = $crud->pdouploadArticle($title,$content,$user,$picture,$date);
        	if($row){
        	    header("Location:/Project_Good_Eat_PDO/Home/blog");
                exit;
        	}
        }
        $this->view("upload");
    }
    
    //修改文章
    function modify() {
        $this->model("CRUD");
        $crud = new CRUD();
        $modifyArray = Array();
        
        $modifyArray["id"][0] = $_GET['id'];
        $modifyArray["img"][0] = $_GET['img'];
        $modifyArray["tit"][0] = $_GET['tit'];
        $modifyArray["cont"][0] = $_GET['cont'];

        if(isset($_POST['title'])) {
            $picture = $_FILES["fileimage"]["name"];
        	move_uploaded_file($_FILES["fileimage"]["tmp_name"],"views/img/".$_FILES["fileimage"]["name"]);
        	
            $id = $_POST["id"];
        	$title = $_POST["title"];
        	$content = $_POST["content"];

        	if($picture == ""){
        	    $row = $crud->pdoupdateArticle($title,$content,$id);
        	    header("Location:/Project_Good_Eat_PDO/Home/blog");
                exit;
        	}else{
        	    $row = $crud->pdoupdatePicture($picture,$title,$content,$id);
        	    header("Location:/Project_Good_Eat_PDO/Home/blog");
                exit;
        	}
        }
        $this->view("modify",$modifyArray);
    }
    
    //刪除文章、圖片、留言
    function del() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $img = $_GET['img'];
            if (file_exists("views/img/".$img)) {
                unlink("views/img/".$img);
            }
            
            $row = $crud ->pdodeleteArticle($id,$img);
            $message = $crud ->pdodeleteMessageboard($id);
            
            if(isset($row) && isset($message)) {
                header("Location:/Project_Good_Eat_PDO/Home/selfpost");
                exit;
            }
        }
    }
    
    //上傳留言
    function uploadmessage() { 
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST['message'])) {
            date_default_timezone_set('Asia/Taipei');  //Cloud9上面的時間是格林威治的時間
            $date = date("Y.m.d H:i:s");
            
            $ID = $_POST["blogID"];
            $userID = $_POST["userid"];
        	$content = $_POST["message"];
        	
        	$row = $crud ->pdouploadMessageboard($ID,$userID,$content,$date);
        	
        	if($row){
        	    header("Location:/Project_Good_Eat_PDO/Home/blog");
                exit; 
        	}
            $this->blog();
        }
    }
    
}
?>