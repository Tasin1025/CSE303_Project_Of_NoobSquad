<?php
include 'connect.php';
session_start();
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
    <!-- submit CND -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navigation1">
        <div class="content2 flex-con">
            <div>
                <h4><?php echo $_SESSION['name']; ?> <br> Faculty</h4>
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
                <a href="F_Backlog.php">
                    <span class="icon">
                        <i class="fa-brands fa-react fa-xl"></i>
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
            <a href="F_Backlog.php">
            <span class="icon">
                 <i class="fa-solid fa-database fa-xl fa-beat-fade"></i>
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
        <form method="POST">
    <div class="bg-primary-subtle  p-5 d-flex flex-column align-items-center rounded">     
        <div class="input w-25 ">
          <label class="input-text" for="inputGroupSelect01">Semester: </label>
            <select name="semester" class="form-select  bg-info-subtle" id="inputGroupSelect02">
                <option value="Autumn" selected>Autumn</option>
                <option value="Summer">Summer</option>
                <option value="Spring">Spring</option>
            </select> 
            </div>
            <div class="input w-25">
            <label class="input-text">Semester Year: </label>
            <select  name="year" class="form-select bg-info-subtle">
                <option value="2020" selected>2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
            </div>
            <div class="input w-25">
            <label class="input-text" for="inputGroupSelect01">Enrolled Course: </label>
            <select  name="courseID" class="form-select bg-info-subtle" id="inputGroupSelect02">
                <option value="CSE101" selected>CSE101</option>
                <option value="EEE131">EEE131</option>
                <option value="ENG101">ENG101</option>
            </select>
            </div>
            <div class="w-25">
                <label class="input-text">Enrolled Section: </label>
                <input class="form-control w-100 bg-info-subtle" type="text" name="section">
            </div>
            <div class="w-25">
                <label class="input-text">Student ID:  </label>
                <input class="form-control w-100 bg-info-subtle" type="text" name="studentID">
            </div>
            <div class="w-25">
                <label class="input-text">Obtained Marks: </label>
                <input class="form-control w-100 bg-info-subtle" type="text" name="marks">
        </div>

            <!-- <button name="submit" class="btn btn-primary w-25 mx-0 mt-4" 
            >Submit</button> -->
            <button name="submit" class="btn btn-primary w-25 mx-0 mt-4" onclick="submitt()">Submit
        </button>
<script>
    // function submitt() {
    //     alert("Submitted");
    // Hover code

//     function submitt() {
//   Swal.fire({
//     title: 'Submitted!',
//     text: 'Your form has been submitted successfully.',
//     icon: 'success',
//     confirmButtonText: 'OK',
//     backdrop: `
//       rgba(0,0,123,0.4)
//       url("https://media.giphy.com/media/3o7buirYcmV5nSwIRW/giphy.gif")
//       left top
//       no-repeat
//     `,
//     timer: 60000 // in milliseconds
//   });
// }
function submitt() {
  Swal.fire({
    title: 'Submitted!',
    text: 'Your form has been submitted successfully.',
    icon: 'success',
    confirmButtonText: 'OK',
    backdrop: `
      rgba(0,0,123,0.4)
      url("https://media.giphy.com/media/3o7buirYcmV5nSwIRW/giphy.gif")
      left top
      no-repeat
    `,
    timer: 20000, // in milliseconds
    willClose: () => {
      // Add any code you want to execute when the modal is closed.
      console.log('Modal closed.');
    }
  });
}
            
</script>

</form>
</div>
<?php

        if (isset($_POST['submit'])) {
            $studentID = $_POST['studentID'];
            $semester = $_POST['semester'];
            $year = $_POST['year'];
            $courseID = $_POST['courseID'];
            $section = $_POST['section'];
            $marks = $_POST['marks'];
            $facultyID = $_SESSION['id'];
            $timeStamp = date("Y-m-d H:i:s");

            $backlogQuery="INSERT INTO backlog_data_t (studentID, edu_year, 
            edu_semester, enrolled_course, enrolled_section, obtained_marks,
            facultyID, time_stamp) VALUES 
            ('$studentID', '$year', '$semester', '$courseID',
            '$section', '$marks', '$facultyID', '$timeStamp')";
            $backlogTable = mysqli_query($conn, $backlogQuery);

            $sectionQuery="INSERT INTO section_t (sectionNum, semester, courseID, facultyID, year) VALUES 
            ('$section', '$semester', '$courseID','$facultyID', '$year')";
            $sectionTable = mysqli_query($conn, $sectionQuery);
            
            //Getting sectionID
            $result = mysqli_query($conn,
            "SELECT MAX(sectionID) AS secID
            FROM section_t");
            $row=mysqli_fetch_assoc($result); 
            $secID=$row['secID'];

            $registrationQuery="INSERT INTO registration_t (sectionID, studentID) VALUES 
            ('$secID', '$studentID')";
            $registrationTable = mysqli_query($conn, $registrationQuery);

            $examName="Backlog";
            $examQuery="INSERT INTO exam_t (sectionID, examName) VALUES 
            ('$secID', 'Backlog')";
            $examTable = mysqli_query($conn, $examQuery);

            //Getting registrationID
            $result = mysqli_query($conn,
            "SELECT MAX(registrationID) AS regID
            FROM registration_t");
            $row=mysqli_fetch_assoc($result);
            $regID=$row['regID'];

            //student course performance
            $gradePoint=0;
            if( $marks >= 90 && $marks<=100)
                $gradePoint=4.0;
            elseif( $marks>= 85 && $marks<=89)
                $gradePoint=3.7;
            elseif($marks >= 80 && $marks<=84)
                $gradePoint=3.3;
            elseif( $marks >= 75 && $marks<=79)
                $gradePoint=3.0;
            elseif( $marks >= 70 && $marks <=74)
                $gradePoint=2.7;
            elseif( $marks >= 60 && $marks <=69)
                $gradePoint=2.3;
            elseif( $marks >= 65 && $marks <=64)
                $gradePoint=2.0;
            elseif( $marks >= 55 && $marks <=59)
                $gradePoint=1.7;
            elseif( $marks >= 50 && $marks <=54)
                $gradePoint=1.3;
            elseif( $marks >= 45 && $marks<=49)
                $gradePoint=1.0;
            elseif( $marks < 44 )
                $gradePoint=0.0;
            $studCoursePerformanceQuery = "INSERT INTO student_course_performance_t(registrationID,
            totalMarksObtained,gradePoint)
            VALUES ('$regID', '$marks', '$gradePoint')";
            $studCoursePerformanceTable = mysqli_query($conn, $studCoursePerformanceQuery);
            
            //Getting examID
            $result = mysqli_query($conn,
            "SELECT MAX(examID) AS examID
            FROM exam_t");
            $row=mysqli_fetch_assoc($result);
            $examID=$row['examID'];
            
            $ansMark = $marks/10;
            $answerQuery="INSERT INTO answer_t (answerDetails, answerNum, markObtained,
            registrationID,questionID, examID) VALUES
            ('Backlog', 1, '$ansMark', '$regID', 0, '$examID'),
            ('Backlog', 2, '$ansMark', '$regID', 0, '$examID'),
            ('Backlog', 3, '$ansMark', '$regID', 0, '$examID'),
            ('Backlog', 4, '$ansMark', '$regID', 0, '$examID')";
            $answerTable = mysqli_query($conn, $answerQuery);

            $questionQuery="INSERT INTO question_t (questionDetails, markPerQuestion, questionNum,
            difficultyLevel, examID, courseID, coNum) VALUES
            ('Backlog', 10, 1, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 1),
            ('Backlog', 10, 2, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 2),
            ('Backlog', 10, 3, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 3),
            ('Backlog', 10, 4, FLOOR(RAND()* (5-1+1))+1, '$examID', '$courseID', 4)";
            $questionTable = mysqli_query($conn, $questionQuery);

            //PO Table
            $programID=0;
            if($courseID=="CSE101"){
                $programID=13;}
            elseif($courseID=="EEE131"){
                $programID=20;}
            elseif($courseID=="ENG101"){
                $programID=9; }

            $poQuery="INSERT INTO po_t (poNum, programID) VALUES
            (FLOOR(RAND()* (12-1+1))+1, '$programID'), 
            (FLOOR(RAND()* (12-1+1))+1, '$programID'),
            (FLOOR(RAND()* (12-1+1))+1, '$programID'),
            (FLOOR(RAND()* (12-1+1))+1, '$programID')";
            $poTable = mysqli_query($conn, $poQuery);

            //Getting po/ploID
            $result = mysqli_query($conn,
            "SELECT MAX(poID) AS poID
            FROM po_t");
            $row=mysqli_fetch_assoc($result);
            $poID=$row['poID'];

            //PLO Table :)
            $minPLO =$poID-3;
            $ploQuery="INSERT INTO plo_t (ploNum, programID)
            SELECT poNum, programID
            FROM po_t
            Where poID Between '$minPLO' AND '$poID'";
            $ploTable = mysqli_query($conn, $ploQuery);
            $ploID=$poID;

            //CO Table
            $coQuery="INSERT INTO co_t (coNum, courseID, ploID, poID) VALUES
            (1, '$courseID', '$ploID', '$poID'),
            (2, '$courseID', '$ploID', '$poID'),
            (3, '$courseID', '$ploID', '$poID'),
            (4, '$courseID', '$ploID', '$poID')";
            $coTable = mysqli_query($conn, $coQuery);

        }
?>
    
    <!-- JS file link -->
    <script src="main.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>