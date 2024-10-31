<?php
require_once "db.php";
$kid_id = $_COOKIE['kid_id'];
$animal_id = $_GET['id'];
$sql = "SELECT * FROM `seen` WHERE `animal_id`  = $animal_id AND `kid_id` = $kid_id";

if(isset($_GET['what']) and $_GET['what'] == 'delete'){
    $sql = "DELETE FROM seen  WHERE animal_id='$animal_id';";
if($conn->query($sql)){
    echo "Удалено!"."<br>";
    header ("Refresh:1; url=main.php");
}else{

}
$conn->close();
}

$result = $conn->query($sql);
if(mysqli_num_rows($result) > 0){
    echo "Вы уже видели это животное";
    header ("Refresh:1; url=main.php");
    die;
}
$sql = "INSERT INTO seen (kid_id, animal_id) VALUES ('$kid_id', '$animal_id')";
if($conn->query($sql)){
    echo "Данные добавлены"."<br>";
    header ("Refresh:1; url=main.php");
}else{
    echo "Error" . $conn->errorl;
}
$conn->close();
?>