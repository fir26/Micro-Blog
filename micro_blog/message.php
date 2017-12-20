<?php
    
    include('includes/connexion.inc.php');

    //var_dump($_POST);

    $a=$_GET['a'];
    $id=$_GET['id'];
    
   // var_dump($id);

    if($a=='add'){

        $val=$_POST['message'];
        $sql="INSERT INTO messages(contenu,date) VALUES(:var,UNIX_TIMESTAMP())";
        $prep=$pdo->prepare($sql);
        $prep->bindValue(':var',$val);
        $prep->execute();
    }
    else if($a=='sup'){
        $sql="DELETE FROM messages where id=:id";
        $prep=$pdo->prepare($sql);
        $prep->bindValue(':id', $id);
        $prep->execute();
        
    }

    header("Location: index.php");
    exit();
?>