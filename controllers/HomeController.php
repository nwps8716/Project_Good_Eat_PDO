<?php
class HomeController extends Controller {
    
    function index() {
        $this->view("index");
    }
    
    //Blog文章分頁
    function blog() {                               
        $this->model("CRUD");
        $crud = new CRUD();
        $result = $crud ->pdogetFooddata_DESC();
        
        $data_nums = count($result);       
        $per = 2;                                   
        $pages = ceil($data_nums/$per);             
        if (!isset($_GET["page"])) {                 
            $page=1;                                
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }
        }else{
            $page = intval($_GET["page"]);          
        }
        $start = ($page-1)*$per;                    
        
        $result = $crud ->pdogetPage($start, $per);
        $blogArray = Array();
        
        $blogArray["num"] = count($result);
        $blogArray["page"] = $page;
        $blogArray["pages"] = $pages;
        $blogArray['result'] = $result;
        
        $this->view("blog",$blogArray);
    }
    
    //顯示會員新增過的貼文
    function selfpost() {
        $this->model("CRUD");
        $crud = new CRUD();
        $result = $crud->pdogetFooddata();
        $selfArray = Array();
        $selfArray['num'] = count($result);
        $selfArray['result'] = $result;
            
        $this->view("selfpost",$selfArray);
    }
    
    //抓取資料庫顯示留言內容
    function showmessage() {
        $this->model("CRUD");
        $crud = new CRUD();
        $showArray = Array();
        
        $id = $_GET['id'];
        
        $result = $crud ->pdogetFooddataID($id);
        $showArray["id"] = $id;
        $showArray['result'] = $result;

        $message = $crud ->pdogetMessageboardID($id);
        
        $showArray["num"] = count($message);
        $showArray["message"] = $message;
        
        $this->view("showmessage",$showArray);
    }
    
}

?>
