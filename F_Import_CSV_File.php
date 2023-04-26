<?php
include 'connect.php';
session_start();
$message = '<label class="text-danger">Please Select File</label>';
if (isset($_POST["upload"])) {
    if ($_FILES['fileToUpload']['name']) {
        $filename = explode(".", $_FILES['fileToUpload']['name']);
        if (end($filename) == "csv") {
            $handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
            $header = fgetcsv($handle);
            while ($data = fgetcsv($handle)) {
                $studentID = mysqli_real_escape_string($conn, $data[0]);
                $year = mysqli_real_escape_string($conn, $data[1]);
                $semester = mysqli_real_escape_string($conn, $data[2]);
                $courseID = mysqli_real_escape_string($conn, $data[3]);
                $section = mysqli_real_escape_string($conn, $data[4]);
                $marks = mysqli_real_escape_string($conn, $data[5]);
                $facultyID = $_SESSION['id'];
                $time = date("Y-m-d H:i:s");
                $query = "
                    INSERT INTO backlog_data_t (studentID, edu_year, 
                    edu_semester, enrolled_course, enrolled_section, obtained_marks,
                    facultyID, time_stamp) VALUES 
                    ('$studentID', '$year', '$semester', '$courseID',
                    '$section', '$marks', '$facultyID', '$time')
                    
                    ";

                mysqli_query($conn, $query);
                $result = mysqli_query(
                    $conn,
                    "SELECT MAX(backlogID) AS backlogID
                        FROM backlog_data_t"
                );
                $row = mysqli_fetch_assoc($result);
                $backlogID = $row['backlogID'];

                $sectionQuery = "INSERT INTO section_t (sectionNum, semester, courseID, facultyID, year) VALUES 
                        ('$section', '$semester', '$courseID','$facultyID', '$year')";
                $sectionTable = mysqli_query($conn, $sectionQuery);

                //Getting sectionID
                $result = mysqli_query(
                    $conn,
                    "SELECT MAX(sectionID) AS secID
                        FROM section_t"
                );
                $row = mysqli_fetch_assoc($result);
                $secID = $row['secID'];

                $registrationQuery = "INSERT INTO registration_t (sectionID, studentID) VALUES 
                        ('$secID', '$studentID')";
                $registrationTable = mysqli_query($conn, $registrationQuery);

                $examName = "Backlog";
                $examQuery = "INSERT INTO exam_t (sectionID, examName) VALUES 
                        ('$secID', 'Backlog')";
                $examTable = mysqli_query($conn, $examQuery);

                //Getting registrationID
                $result = mysqli_query(
                    $conn,
                    "SELECT MAX(registrationID) AS regID
                        FROM registration_t"
                );
                $row = mysqli_fetch_assoc($result);
                $regID = $row['regID'];

                //student course performance
                $gradePoint = 0;
                if ($marks >= 90 && $marks <= 100)
                    $gradePoint = 4.0;
                elseif ($marks >= 85 && $marks <= 89)
                    $gradePoint = 3.7;
                elseif ($marks >= 80 && $marks <= 84)
                    $gradePoint = 3.3;
                elseif ($marks >= 75 && $marks <= 79)
                    $gradePoint = 3.0;
                elseif ($marks >= 70 && $marks <= 74)
                    $gradePoint = 2.7;
                elseif ($marks >= 60 && $marks <= 69)
                    $gradePoint = 2.3;
                elseif ($marks >= 65 && $marks <= 64)
                    $gradePoint = 2.0;
                elseif ($marks >= 55 && $marks <= 59)
                    $gradePoint = 1.7;
                elseif ($marks >= 50 && $marks <= 54)
                    $gradePoint = 1.3;
                elseif ($marks >= 45 && $marks <= 49)
                    $gradePoint = 1.0;
                elseif ($marks < 44)
                    $gradePoint = 0.0;
                $studCoursePerformanceQuery = "INSERT INTO student_course_performance_t(registrationID, totalMarksObtained,gradePoint)
                        VALUES ('$regID', '$marks', '$gradePoint')";
                $studCoursePerformanceTable = mysqli_query($conn, $studCoursePerformanceQuery);

                //Getting examID
                $result = mysqli_query(
                    $conn,
                    "SELECT MAX(examID) AS examID
                        FROM exam_t"
                );
                $row = mysqli_fetch_assoc($result);
                $examID = $row['examID'];


                $ansMark = $marks / 10;
                $answerQuery = "INSERT INTO answer_t (answerDetails, answerNum, markObtained,
                        registrationID,questionID, examID) VALUES
                        ('Backlog', 1, '$ansMark', '$regID', 0, '$examID'),
                        ('Backlog', 2, '$ansMark', '$regID', 0, '$examID'),
                        ('Backlog', 3, '$ansMark', '$regID', 0, '$examID'),
                        ('Backlog', 4, '$ansMark', '$regID', 0, '$examID')";
                $answerTable = mysqli_query($conn, $answerQuery);

                $questionQuery = "INSERT INTO question_t (questionDetails, markPerQuestion, questionNum,
                        difficultyLevel, examID, courseID, coNum) VALUES
                        ('Backlog', 10, 1, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 1),
                        ('Backlog', 10, 2, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 2),
                        ('Backlog', 10, 3, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 3),
                        ('Backlog', 10, 4, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 4)";
                $questionTable = mysqli_query($conn, $questionQuery);

                //PO Table
                $programID = 0;
                if ($courseID == "CSE101") {
                    $programID = 13;
                } elseif ($courseID == "EEE131") {
                    $programID = 20;
                } elseif ($courseID == "ENG101") {
                    $programID = 9;
                }

                $poQuery = "INSERT INTO po_t (poNum, programID) VALUES
                        (FLOOR(RAND()* (12-1+1))+1, '$programID'), 
                        (FLOOR(RAND()* (12-1+1))+1, '$programID'),
                        (FLOOR(RAND()* (12-1+1))+1, '$programID'),
                        (FLOOR(RAND()* (12-1+1))+1, '$programID')";
                $poTable = mysqli_query($conn, $poQuery);

                //Getting po/ploID
                $result = mysqli_query(
                    $conn,
                    "SELECT MAX(poID) AS poID
                        FROM po_t"
                );
                $row = mysqli_fetch_assoc($result);
                $poID = $row['poID'];

                //PLO Table :)
                $minPLO = $poID - 3;
                $ploQuery = "INSERT INTO plo_t (ploNum, programID)
                        SELECT poNum, programID
                        FROM po_t
                        Where poID Between '$minPLO' AND '$poID'";
                $ploTable = mysqli_query($conn, $ploQuery);
                $ploID = $poID;


                //CO Table
                $coQuery = "INSERT INTO co_t (coNum, courseID, ploID, poID) VALUES
                        (1, '$courseID', '$ploID', '$poID'),
                        (2, '$courseID', '$ploID', '$poID'),
                        (3, '$courseID', '$ploID', '$poID'),
                        (4, '$courseID', '$ploID', '$poID')";
                $coTable = mysqli_query($conn, $coQuery);
            }
            fclose($handle);
            header("location: F_Import_CSV_File.php?updation=1");
        } else {
            $message = '<label class="text-danger">Please Select CSV File Only</label>';
        }
    } else {
        $message = '<label class="text-danger">Please Select File</label>';
    }
}
if (isset($_GET["updation"])) {
    $message = '<label class="text-success">Update Done</label>';
}



//  UPDATE backlog_data_t
//  SET studentID='studentID',
//edu_year='year',
//                             edu_semester='semester',
//                             enrolled_course='courseID',
//                             enrolled_section='section',
//                             obtained_marks='marks',
//                             facultyID='facultyID',
//                             time_stamp='time'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="middel_button.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/41c61c6dc3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navigation1">
        <div class="content2 flex-con">
            <div>
                <h4>
                    <?php echo $_SESSION['name']; ?> <br> Faculty
                </h4>
            </div>
            <div><a href="#"><img src="icons8-man-teacher-48.png" alt=""></a></div>
        </div>

        <ul>
            <li class="list">
                <a href="F_Dashboard.php">
                    <span class="icon">
                        <i class="fa-solid fa-chart-pie fa-xl"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="list">
                <a href="F_PLO_Analysis.php">
                    <span class="icon">
                        <i class="fa-brands fa-react fa-beat-fade fa-xl"></i>
                    </span>
                    <span class="title">PLO Analysis</span>
                </a>
            </li>
            <li class="list">
                <a href="F_Spider_Chart_Analysis.php">
                    <span class="icon">
                        <i class="fa-solid fa-thumbtack fa-xl"></i>
                    </span>
                    <span class="title">Spider Chart Analysis</span>
                </a>
            </li>
            <li class="list">
                <a href="F_Data Entry.php">
                    <span class="icon">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </span>
                    <span class="title">Data Entry</span>
                </a>
            </li>
            <!-- backlog button-->
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-solid fa-database fa-xl"></i>
                    </span>
                    <span class="title">Backlog Data</span>
                </a>
            <li class="list">
                <a href="index.php">
                    <span class="icon">
                        <i class="fa-solid fa-person-running fa-xl"></i>
                    </span>
                    <span class="title">Sign Out</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="check">
        <input type="checkbox" name="check" id="check" class="checkbox1">
        <label for="check"><i class="fa-solid fa-moon fa-xl"></i></label>
    </div>

    <div class="content1">
        <div style="background-color: rgb(75, 192, 192); margin-right: 10px; text-align: center;">
            <h2>STUDENT PERFORMANCE MONITORING SYSTEM</h2>
        </div>


        <div class="tab">
            <!-- <p><a href="Backlog_Data_Entry.csv">Download TEXT file</a></p> -->

            <form method="post" enctype="multipart/form-data">

                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" name="upload" class="custom-btn btn-11 tablinks" value="Upload">
                <button class="custom-btn btn-10 tablinks"><a href="Backlog_Data_Entry.csv">Download Sample CSV file</a> </button>&nbsp;&nbsp;
                <button class="custom-btn btn-11 tablinks"><a href="F_viewbacklog.php" class="submit_btn_css">View
                        Backlog Data</a></button>
            </form>
        </div>

        <?php


        if (isset($_GET['path'])) {
            //Read the filename
            $filename = $_GET['path'];
            //Check the file exists or not
            if (file_exists($filename)) {

                //Define header information
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header("Cache-Control: no-cache, must-revalidate");
                header("Expires: 0");
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
                header('Content-Length: ' . filesize($filename));
                header('Pragma: public');

                //Clear system output buffer
                flush();

                //Read the size of the file
                readfile($filename);

                //Terminate from the script
                die();
            } else {
                echo "File does not exist.";
            }
        }

        ?>
        <?php

        echo $message;





        // if (isset($_POST['submit'])) {
        //     if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {

        //         $file_name = $_FILES['csv_file']['name'];
        //         $file_size = $_FILES['csv_file']['size'];


        //         if (pathinfo($file_name, PATHINFO_EXTENSION) == 'csv') {

        //             $file = fopen($_FILES['csv_file']['tmp_name'], 'r');


        //             while (($row = fgetcsv($file)) !== false) {
        //                 $studentID = mysqli_real_escape_string($conn, $row[0]);
        //                 $year = mysqli_real_escape_string($conn, $row[1]);
        //                 $semester = mysqli_real_escape_string($conn, $row[2]);
        //                 $courseID = mysqli_real_escape_string($conn, $row[3]);
        //                 $section = mysqli_real_escape_string($conn, $row[4]);
        //                 $marks = mysqli_real_escape_string($conn, $row[5]);
        //                 $facultyID = mysqli_real_escape_string($conn, $row[6]);
        //                 $time_stamp = mysqli_real_escape_string($conn, $row[7]);

        //                 $backlogQuery = "INSERT INTO backlog_data_t (studentID, edu_year, 
        //                 edu_semester, enrolled_course, enrolled_section, obtained_marks,
        //                 facultyID, time_stamp) VALUES 
        //                 ('$studentID', '$year', '$semester', '$courseID',
        //                 '$section', '$marks', '$facultyID', '$timeStamp')";
        //                 $backlogTable = mysqli_query($conn, $backlogQuery);

        //                 //Getting backlogID
        //                 $result = mysqli_query(
        //                     $conn,
        //                     "SELECT MAX(backlogID) AS backlogID
        //                 FROM backlog_data_t"
        //                 );
        //                 $row = mysqli_fetch_assoc($result);
        //                 $backlogID = $row['backlogID'];

        //                 $sectionQuery = "INSERT INTO section_t (sectionNum, semester, courseID, facultyID, year) VALUES 
        //                 ('$section', '$semester', '$courseID','$facultyID', '$year')";
        //                 $sectionTable = mysqli_query($conn, $sectionQuery);

        //                 //student course performance
        //                 $gradePoint=0;
        //                 if( $marks >= 90 && $marks<=100)
        //                     $gradePoint=4.0;
        //                 elseif( $marks>= 85 && $marks<=89)
        //                     $gradePoint=3.7;
        //                 elseif($marks >= 80 && $marks<=84)
        //                     $gradePoint=3.3;
        //                 elseif( $marks >= 75 && $marks<=79)
        //                     $gradePoint=3.0;
        //                 elseif( $marks >= 70 && $marks <=74)
        //                     $gradePoint=2.7;
        //                 elseif( $marks >= 60 && $marks <=69)
        //                     $gradePoint=2.3;
        //                 elseif( $marks >= 65 && $marks <=64)
        //                     $gradePoint=2.0;
        //                 elseif( $marks >= 55 && $marks <=59)
        //                     $gradePoint=1.7;
        //                 elseif( $marks >= 50 && $marks <=54)
        //                     $gradePoint=1.3;
        //                 elseif( $marks >= 45 && $marks<=49)
        //                     $gradePoint=1.0;
        //                 elseif( $marks < 44 )
        //                     $gradePoint=0.0;
        //                 $studCoursePerformanceQuery = "INSERT INTO student_course_performance_t(registrationID, totalMarksObtained,gradePoint)
        //                 VALUES ('$regID', '$marks', '$gradePoint')";
        //                 $studCoursePerformanceTable = mysqli_query($conn, $studCoursePerformanceQuery);

        //                 //Getting sectionID
        //                 $result = mysqli_query(
        //                     $conn,
        //                     "SELECT MAX(sectionID) AS secID
        //                 FROM section_t"
        //                 );
        //                 $row = mysqli_fetch_assoc($result);
        //                 $secID = $row['secID'];

        //                 $backlogCourseQuery = "INSERT INTO backlog_course_t (backlogID, courseID) VALUES
        //                 ('$backlogID', '$courseID')";
        //                 $backlogCourseTable = mysqli_query($conn, $backlogCourseQuery);

        //                 $backlogSectionQuery = "INSERT INTO backlog_section_t (backlogID, sectionID) VALUES
        //                 ('$backlogID', '$secID')";
        //                 $backlogSectionTable = mysqli_query($conn, $backlogSectionQuery);

        //                 $registrationQuery = "INSERT INTO registration_t (sectionID, studentID) VALUES 
        //                 ('$secID', '$studentID')";
        //                 $registrationTable = mysqli_query($conn, $registrationQuery);

        //                 $examName = "Backlog";
        //                 $examQuery = "INSERT INTO exam_t (sectionID, examName) VALUES 
        //                 ('$secID', 'Backlog')";
        //                 $examTable = mysqli_query($conn, $examQuery);

        //                 //Getting registrationID
        //                 $result = mysqli_query(
        //                     $conn,
        //                     "SELECT MAX(registrationID) AS regID
        //                     FROM registration_t"
        //                 );
        //                 $row = mysqli_fetch_assoc($result);
        //                 $regID = $row['regID'];

        //                 //Getting examID
        //                 $result = mysqli_query(
        //                     $conn,
        //                     "SELECT MAX(examID) AS examID
        //                 FROM exam_t"
        //                 );
        //                 $row = mysqli_fetch_assoc($result);
        //                 $examID = $row['examID'];


        //                 $ansMark = $marks / 10;
        //                 $answerQuery = "INSERT INTO answer_t (answerDetails, answerNum, markObtained,
        //                 registrationID,questionID, examID) VALUES
        //                 ('Backlog', 1, '$ansMark', '$regID', 0, '$examID'),
        //                 ('Backlog', 2, '$ansMark', '$regID', 0, '$examID'),
        //                 ('Backlog', 3, '$ansMark', '$regID', 0, '$examID'),
        //                 ('Backlog', 4, '$ansMark', '$regID', 0, '$examID')";
        //                 $answerTable = mysqli_query($conn, $answerQuery);

        //                 $questionQuery = "INSERT INTO question_t (questionDetails, markPerQuestion, questionNum,
        //                 difficultyLevel, examID, courseID, coNum) VALUES
        //                 ('Backlog', 10, 1, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 1),
        //                 ('Backlog', 10, 2, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 2),
        //                 ('Backlog', 10, 3, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 3),
        //                 ('Backlog', 10, 4, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 4)";
        //                             $questionTable = mysqli_query($conn, $questionQuery);

        //                 //PO Table
        //                 $programID = 0;
        //                 if ($courseID == "CSE101") {
        //                     $programID = 13;
        //                 } elseif ($courseID == "EEE131") {
        //                     $programID = 20;
        //                 } elseif ($courseID == "ENG101") {
        //                     $programID = 9;
        //                 }

        //                 $poQuery = "INSERT INTO po_t (poNum, programID) VALUES
        //                 (FLOOR(RAND()* (12-1+1))+1, '$programID'), 
        //                 (FLOOR(RAND()* (12-1+1))+1, '$programID'),
        //                 (FLOOR(RAND()* (12-1+1))+1, '$programID'),
        //                 (FLOOR(RAND()* (12-1+1))+1, '$programID')";
        //                 $poTable = mysqli_query($conn, $poQuery);

        //                 //Getting po/ploID
        //                 $result = mysqli_query(
        //                     $conn,
        //                     "SELECT MAX(poID) AS poID
        //                     FROM po_t"
        //                 );
        //                 $row = mysqli_fetch_assoc($result);
        //                 $poID = $row['poID'];

        //                 //PLO Table :)
        //                 $minPLO = $poID - 3;
        //                 $ploQuery = "INSERT INTO plo_t (ploNum, programID)
        //                 SELECT poNum, programID
        //                 FROM po_t
        //                 Where poID Between '$minPLO' AND '$poID'";
        //                 $ploTable = mysqli_query($conn, $ploQuery);
        //                 $ploID = $poID;


        //                 //CO Table
        //                 $coQuery = "INSERT INTO co_t (coNum, courseID, ploID, poID) VALUES
        //                 (1, '$courseID', '$ploID', '$poID'),
        //                 (2, '$courseID', '$ploID', '$poID'),
        //                 (3, '$courseID', '$ploID', '$poID'),
        //                 (4, '$courseID', '$ploID', '$poID')";
        //                 $coTable = mysqli_query($conn, $coQuery);
        //             }
        //             echo "done";
        //             fclose($file);

        //             // Redirect the user back to the form
        //             // header('Location: upload_form.php?success=1');
        //             exit();
        //         } else {
        //             // File is not a CSV
        //             exit();
        //         }
        //     } else {
        //         // No file was uploaded
        //         exit();
        //     }
        // }
        ?>
        <!-- JS file link -->
        <script src="main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        

        <div style="background-color: rgb(75, 192, 192); margin-right: 10px; text-align: center;">
            <h3>Submit Backlog Data by importing CSV FILE</h3>
        </div>
</body>

</html>