<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    
            
    <?php
     $dsn='データベース名';
    $user='ユーザー名';
    $password="パスワード";
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     $sql = "CREATE TABLE IF NOT EXISTS m5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date char(32),"
    . "pass char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    $rid="";
    $rname="";
    $rcomment="";
    $rpass="";
    if(!empty($_POST["edit"])&&!empty($_POST["password3"])){
       $id=$_POST["edit"];
       $password3=$_POST["password3"];
        $sql = 'SELECT * FROM m5';
        $stmt = $pdo->query($sql);                  
        $results = $stmt->fetchAll();
       foreach($results as $row){
           if($row['id'] == $id && $row['pass'] == $_POST["password3"]){
               $rname = $row['name'];
               $rcomment = $row['comment'];
               $rid = $row['id'];
               $rpass = $row['pass'];
           }
       }
    }
    ?>
    <form method = "POST" action = "">
        名前:
    <input type = "text"  name = "name"  value = "<?php echo $rname;?>"  placeholder = "名前"><br>
    コメント:
    <input type = "text"  name = "comment"  value = "<?php echo $rcomment;?>"  placeholder = "コメント"><br>
    <input type = "password" name= "password" value="<?php echo $rpass;?>" placeholder = "パスワード">
    <input type = "hidden"  name = "judge" value = "<?php echo $rid;?>" >
    <input type = "submit"  name = "submit"value = "送信"><br>
	削除:
    <input type = "text" name = "delete"  placeholder ="番号を入力してください"><br>
    <input type = "password" name = "password2" value = "" placeholder = "パスワード">
    <input type = "submit"  name = "sakujyo" value = "削除"><br>
	編集:
    <input type = "text" name = "edit" placeholder = "編集対象番号" ><br>
    <input type = "password" name = "password3" value = "" placeholder = "パスワード"> 
    <input type =  "submit" name = "hennum" value = "編集"><br> 
    </from>

    <?php
    if(!empty($_POST["judge"])&&!empty($_POST["password"])){
    $id = $_POST["judge"]; //変更する投稿番号
    $name = $_POST["name"];
    $comment = $_POST["comment"]; 
    $password = $_POST["password"];
    $date = date("Y年m月d日 H時i分s秒");
    $sql = 'UPDATE m5 SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
    $stmt->execute();
    }
    elseif(!empty($_POST["submit"])){
    if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["password"])){
    $name = $_POST["name"];
    $comment = $_POST["comment"]; 
    $password = $_POST["password"];
    $date = date("Y年m月d日 H時i分s秒");
     $sql = $pdo -> prepare("INSERT INTO m5 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
    $sql -> execute();
    }
    }
    elseif(!empty($_POST["sakujyo"])&&!empty($_POST["delete"])&&!empty($_POST["password2"])){
         $id =$_POST["delete"];
         $password2=$_POST["password2"];
          $sql = 'SELECT * FROM m5';
        $stmt = $pdo->query($sql);                  
        $results = $stmt->fetchAll();
       foreach($results as $row){
           if($row['id'] == $id && $row['pass'] == $_POST["password2"]){
    $sql = 'delete from m5 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
       }
    }
    ?>
      <p>投稿一覧</p>
     <?php
     $sql = 'SELECT * FROM m5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
    
    
   
    
    ?>
</body>
</html>