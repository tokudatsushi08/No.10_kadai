<?php
$id = $_GET['id'];

$dbn ='mysql:dbname=gs_f02_db23;charset=utf8;port=3306;host=localhost'; 
$user = 'root';
$pwd = 'root';

try {
$pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) 
{ exit('dbError:'.$e->getMessage());}


$sql = 'SELECT * FROM php_kadai where id=:id';
$stmt = $pdo->prepare($sql);
$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
$status=$stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    $rs = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>写真登録アプリ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div{
            padding: 10px;
            font-size:16px;
            }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">思い出シェア</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">データ一覧</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <form method="post" action="update.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?=$rs['title']?>">
        </div>
        <div class="form-group">
            <label for="image">登録画像</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" capture="camera" >
        </div>
        <div class="form-group">
            <label for="data">撮影時期</label>
            <input type="data" class="form-control" id="data" name="data" value="<?=$rs['data']?>">
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"><?=$rs['comment']?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!-- idは変えたくない = ユーザーから見えないようにする-->
        <input type="hidden" name="id" value="<?=$rs['id']?>">
    </form>
</body>
</html>