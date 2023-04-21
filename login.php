<?php
include "connect.php" ;
session_start();
if (isset($_POST['id']) && isset($_POST['pass'])) {
    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $id = validate($_POST['id']);
    $pass = validate($_POST['pass']);

    // if (empty($id)){
    //     header("Location: index.php?error= Enter ID");
    //     exit();

    // } elseif (empty($pass)) {
    //     header("Location: index.php?error= Enter Password");
    //     exit();
    // } else{
    if ( strlen(strval($id)) === 4){ 
        $sql = "SELECT * from employee_t where employeeID='$id' and password='$pass'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) === 1) {
            if (substr($id, 0, 1) === "1") {
                // the number starts with 1
               // echo "The number starts with 1.";
                if ($row['employeeID'] === $id && $row['password'] === $pass) {
                    //echo "hello " . $row['name'] ;
                    $_SESSION['name'] = $row['firstName']." " . $row['lastName'];
                    $_SESSION['id'] = $row['employeeID'];
                    header("Location: H_Dashboard.php");
                    exit();
                } 
            }else {

            if ($row['employeeID'] === $id && $row['password'] === $pass) {
                //echo "hello " . $row['name'] ;
                $_SESSION['name'] = $row['firstName']." " . $row['lastName'];
                $_SESSION['id'] = $row['employeeID'];
                header("Location: F_Dashboard.php");
                exit();
            } }
        } else {
            header("Location: index.php?error = Incorrect ID or Password");
            exit();
        }
    } elseif ( strlen(strval($id)) === 7 ){
        $sql = "SELECT * from student_t where studentID='$id' and password='$pass'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) === 1) {
            if ($row['studentID'] === $id && $row['password'] === $pass) {
                //echo "hello " . $row['name'] ;
                $_SESSION['name'] = $row['firstName'] ." " . $row['lastName'];
                $_SESSION['id'] = $row['studentID'];
                header("Location: S_Dashboard.php");
                exit();
            } 
        } else {
            header("Location: index.php?error = Incorrect ID or Password");
            exit();
        }

    } elseif ( strlen(strval($id)) === 5 ) { 
        $sql = "SELECT * from authority_t where authorityID='$id' and password='$pass'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) === 1) {
            if ($row['authorityID'] === $id && $row['password'] === $pass) {
                //echo "hello " . $row['name'] ;
                $_SESSION['name'] = $row['firstName'] ." " . $row['lastName'];
                $_SESSION['id'] = $row['authorityID'];
                header("Location: H_Dashboard.php");
                exit();
            } 
        } else {
            header("Location: index.php?error = Incorrect ID or Password");
            exit();
        }
    } else {
        header("Location: index.php?error");
        exit();
    }
        // sesh bhai
    //}
} else {
    header("Location: index.php?error");
    exit();
}
