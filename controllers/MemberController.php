<?php
class MemberController extends Controller {
    
    //會員註冊
    function member() {       
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST['btnok'])) {
            $id = $_POST['userid'];
            $pw = $_POST['password'];
            $pw2 = $_POST['password2'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
         
            $row = $crud->pdogetUserdata_id($firstname,$lastname,$email,$id,$pw,$pw2);

            if($row){
                $insert = $crud->pdoinsertUserdata($firstname,$lastname,$email,$id,$pw,$pw2);
                header("Location:signin");
                exit;
            }
        }
        $this->view("member");
    }
    
    //會員登入確認
    function signin() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST['button'])) {
            $id = $_POST['id'];
            $pw = $_POST['pw'];

            $row = $crud->pdoUserdata_id_pw($id,$pw);
            
            if($row){
                header("Location:/Project_Good_Eat_PDO/Home/index");
                exit;
            }
        }
        $this->view("signin");
    }
    
    //會員登出
    function logout() {             
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_GET["signout"])) {
            $crud->signout();
            header("Location:/Project_Good_Eat_PDO/Home/index");
            exit;
        }
    }
}
?>