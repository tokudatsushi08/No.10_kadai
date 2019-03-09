<?php
$id = $_GET['id'];

$dbn ='mysql:dbname=gs_f02_db23;charset=utf8;port=3306;host=localhost'; 
$user = 'root';
$pwd = 'root';

try {
$pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) 
{ exit('dbError:'.$e->getMessage());}


$sql = 'DELETE FROM php_kadai where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status=$stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: select.php');
    exit;
}
?>