<?php
include '../db.php';

$feedbackID = $_GET["id"];
$sql = ("DELETE FROM students WHERE Student_ID= '$feedbackID'");

if ($connection->query($sql) === true) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $connection->error;
}

$connection->close();
?>

<script language="javascript">
document.location="delete_user.php";
</script> 