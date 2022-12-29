<?php
include '../db.php';

$feedbackID = $_GET["id"];
$sql = ("DELETE FROM faculty WHERE Faculty_Id= '$feedbackID'");

if ($connection->query($sql) === true) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $connection->error;
}

$connection->close();
header("Location:delete_fac.php");
?>