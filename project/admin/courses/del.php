<?php
include '../db.php';

$feedbackID = $_GET["id"];
$sql = ("DELETE FROM courses WHERE Course_ID= '$feedbackID'");

if ($connection->query($sql) === true) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $connection->error;
}

$connection->close();
header("Location:delete_course.php");
?>