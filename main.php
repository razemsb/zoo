<?php
require_once "db.php";
//если установлена cookies, используем ее
if (isset ($_GET['id']) AND isset($_GET['name'])){
	$kid_id = $_GET['id'];
	$kid_name = $_GET['name'];
	setcookie("kid_id", $kid_id, time() + 3600);
	setcookie("kid_name", $kid_name, time() + 3600);
	header ("Location: main.php");
}
?>
<html>
<head>
<title>Животные</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
echo "<p style='color:black; text-align:center;font-size:30px;'>Привет, ".$_COOKIE['kid_name']."</p>";
echo "<br>";

$kid_id = $_COOKIE['kid_id'];

$sql = "SELECT animals.id, animals.name, animals.pic FROM animals";

$sql_count = "SELECT COUNT(*) AS seen_count FROM seen WHERE kid_id = $kid_id";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$seen_count = $row_count['seen_count'];

if($result = $conn->query($sql)){
    if ($seen_count == 16){
        echo "<p style='color:black; text-align:center;font-size:40px;'>Ты уже увидел всех животных!</p>"; 
        echo "<br>";
    }
    foreach($result as $row){
        $animal_id = $row["id"];
        $animal_name = $row["name"];
        $animal_pic = $row["pic"];

        $sql_check_seen = "SELECT 1 FROM seen WHERE animal_id = $animal_id AND kid_id = $kid_id";
        $result_check_seen = $conn->query($sql_check_seen);
        if ($result_check_seen->num_rows > 0) {

            echo "<a href='markanimal.php?id=$animal_id&what=delete'><img src='animals/$animal_pic' height='150' class='seen'></a>";
        } else {

            echo "<a href='markanimal.php?id=$animal_id'><img src='animals/$animal_pic' height='150' class='not_seen'></a>";
        }
    }
}
?>
</body>
</html>