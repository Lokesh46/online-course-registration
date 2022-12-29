<?php
    include_once 'db.php';
    if (!empty($_POST["dept_id_fac"])){
        $dept = $_POST["dept_id_fac"];
        $query="select * from faculty where dept_id = '$dept' ";
        $result=$connection->query($query);

        if ($result -> num_rows >0) {
            echo '<option value="">Select Faculty Name</option>';
            while ($row = $result->fetch_assoc()){
                echo '<option value="'.$row['Faculty_Id'].'">'.$row['Name'].'</option>';
            }
        } else {
            echo '<option value=""> No Faculty Available </option>';
        }
    } elseif (!empty($_POST["type"])) {
        $type = $_POST["type"];
        $exp=explode('#',$type);
        $c_type = $exp[0];
        $c_id=$exp[1];

        $res= $connection->query("select * from courses where Course_ID='$c_id'");

        while ($row=$res->fetch_object()) {
            $orig_type=$row->CourseType;
            $credits=$row->Credits;
        }
        echo "<option value=''>Select Slot</option>";
        if ($c_type == "lab") {
            
            echo "<option val='l1+l2'>L1+L2</option>";
            echo "<option val='l3+l4'>L3+L4</option>";
            echo "<option val='l5+l5'>L5+L6</option>";
            echo "<option val='l7+l8'>L7+L8</option>";
            echo "<option val='l9+l10'>L9+L10</option>";
            echo "<option val='l11+l12'>L11+L12</option>";
        } else {
            if ($orig_type=="Lab+Theory") {
                $credits=$credits-1;
            }
            if ($credits==4) {
                echo "<option val='A+TA+TAA'> A+TA+TAA </option>";
                echo "<option val='B+TB+TBB'> B+TB+TBB </option>";
                echo "<option val='C+TC+TCC'> C+TC+TCC </option>";
                echo "<option val='D+TD+TDD'> D+TD+TDD </option>";
                echo "<option val='E+TE+TEE'> E+TE+TEE </option>";
                echo "<option val='F+TF+TFF'> F+TF+TFF </option>";
            } elseif ($credits==3) {
                echo "<option val='A+TA'> A+TA </option>";
                echo "<option val='B+TB'> B+TB </option>";
                echo "<option val='C+TC'> C+TC </option>";
                echo "<option val='D+TD'> D+TD </option>";
                echo "<option val='E+TE'> E+TE </option>";
                echo "<option val='F+TF'> F+TF </option>";
            } elseif ($credits==2) {
                echo "<option val='A'> A </option>";
                echo "<option val='B'> B </option>";
                echo "<option val='C'> C </option>";
                echo "<option val='D'> D </option>";
                echo "<option val='E'> E </option>";
                echo "<option val='F'> F </option>";
            } else {
                echo "<option val='TAA'> TAA </option>";
                echo "<option val='TBB'> TBB </option>";
                echo "<option val='TCC'> TCC </option>";
                echo "<option val='TDD'> TDD </option>";
                echo "<option val='TEE'> TEE </option>";
                echo "<option val='TFF'> TFF </option>";
            }
        }
    } elseif (!empty($_POST["dept_id_course"])){
        $dept = $_POST["dept_id_course"];
        $query="select * from courses where dept_id = '$dept' ";
        $result=$connection->query($query);

        if ($result -> num_rows >0) {
            echo '<option value="">Select Course Name</option>';
            while ($row = $result->fetch_assoc()){
                echo '<option value="'.$row['Course_ID'].'">'.$row['Course_Name'].' - '.$row['Course_Name'].'</option>';
            }
        } else {
            echo '<option value=""> No Course Available </option>';
        }
    } elseif (!empty($_POST["c_type"])){
        $dept = $_POST["c_type"];
        $query="select CourseType from courses where Course_ID = '$dept' ";
        $result=$connection->query($query);

            while ($row=$result->fetch_object()) {
                $ctype=$row->CourseType;
            }
        echo '<option value="">Select Course Type</option>';
        if ($ctype == "Lab") {
            echo "<option value='lab'> Lab</option>";
        } elseif ($ctype == "Theory") {
            echo "<option value='theory'> Theory</option>";
        } else {
            echo "<option value=''>{$ctype}</option>";
            echo "<option value='theory'> Theory</option>";
            echo "<option value='lab'> Lab</option>";
        }

    }

