<?php
if(
    !isset($_POST['title'])||$_POST['title']==''||
    !isset($_POST['data'])||$_POST['data']==''
){
    exit('ParamError');
};

if(
    isset($_FILES['image'])&&$_FILES['image']['error']==0
){
    $image_name=$_FILES['image']['name'];
    $tmp_path=$_FILES['image']['tmp_name'];
    $file_dir_path='upload/';

    $extension = pathinfo($image_name, PATHINFO_EXTENSION); 
    $uniq_name = date('YmdHis').md5(session_id()) . "." . $extension; 
    $image_name = $file_dir_path.$uniq_name;


    if (is_uploaded_file($tmp_path)) {
    if (move_uploaded_file($tmp_path, $image_name)) 
    { chmod($image_name, 0644);
    } else { 
    exit('Error:アップロードできませんでした.');
        } 
    }   

}

$id= $_POST['id'];
$title=$_POST['title'];
$data=$_POST['data'];
$comment=$_POST['comment'];


$dbn ='mysql:dbname=gs_f02_db23;charset=utf8;port=3306;host=localhost'; 
$user = 'root';
$pwd = 'root';

try {
$pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) 
{ exit('dbError:'.$e->getMessage());}

$sql = 'UPDATE php_kadai SET title=:a1, image=:image, data=:a3, comment=:a4 WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $title, PDO::PARAM_STR);
$stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
$stmt->bindValue(':a3', $data, PDO::PARAM_STR);
$stmt->bindValue(':a4', $comment, PDO::PARAM_INT);
$stmt->bindValue(':id',$id,PDO::PARAM_STR);
$status = $stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: select.php');
    exit;
}
?>