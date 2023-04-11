<?php

include '../../main/db.php';
$prislusnostOtazky = strip_tags($_GET['test']);
$res=mysqli_query($connection,"SELECT * FROM otazky WHERE prislusnostOtazky='$prislusnostOtazky'");
$data=array();
while ($row=mysqli_fetch_assoc($res)){
    $data[]=$row;
}
echo json_encode($data);

?>