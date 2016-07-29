<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SelfPages - Good Eat</title>
    <!-- Bootstrap Core CSS -->
    <link href="../views/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../views/css/business-casual.css" rel="stylesheet">
</head>

<body>
    <?php require_once "menu.php"; ?>
    
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                <p>已發佈文章</p>
                <?php 
                $selfArray = $data;
                for($i=0;$i<=$selfArray['num'];$i++) {  
                ?>
                <div class="col-lg-12 text-center">
                    <p>
                    <?php 
                    if($_SESSION['username'] == $selfArray['result'][$i]['user']) {
                        echo $selfArray['result'][$i]['title']."<br>";
                        echo '<a href="/Project_Good_Eat_PDO/Article/modify?cont='.htmlspecialchars($selfArray['result'][$i]['content']).'&tit='.$selfArray['result'][$i]['title'].'&img='.$selfArray['result'][$i]['imgfile'].'&id='.$selfArray['result'][$i]['ID'].'";>修改</a>'." ";
                        echo '<a href="/Project_Good_Eat_PDO/Article/del?img='.$selfArray['result'][$i]['imgfile'].'&id='.$selfArray['result'][$i]['ID'].'";>刪除</a>' . "<hr>";
                    }
                    ?>
                    </p>
                </div>
                <?php } ?> 
                <!--ending php for circle-->
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <?php include "footer.php"?>
</body>

</html>
