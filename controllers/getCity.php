<?php

require_once '../configs/database.php';

$regionId = $_GET['id_region'];
$sql = "SELECT * FROM comunas WHERE id_region = $regionId";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $name_comuna = $row['comuna'];
        echo "<option value='$id'>$name_comuna</option>";
    }
}else{
    echo "<option value=''>No hay comunas</option>";
}
?>