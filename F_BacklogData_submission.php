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
            <li class="list active">
                <a href="#">
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
            <li class="list">
            <a href="F_Backlog.php">
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

            <button name="submit" class="btn btn-primary w-25 mx-0 mt-4" 
            >Submit</button>
</form>
</div>
<?php

        if (isset($_POST['submit'])) {
            //include 'connect.php';
            //session_start();
            $studentID = $_POST['studentID'];
            $semester = $_POST['semester'];
            $year = $_POST['year'];
            $courseID = $_POST['courseID'];
            $section = $_POST['section'];
            $marks = $_POST['marks'];
            $facultyID = $_SESSION['id'];
            $timeStamp = date("Y-m-d H:i:s");

            echo $studentID;
            echo $semester;
            echo $year;
            echo $courseID;
            echo $section;
            echo $marks;
            echo $facultyID;
            echo $timeStamp;
            $backlogQuery="INSERT INTO backlog_data_t (studentID, edu_year, 
            edu_semester, enrolled_course, enrolled_section, obtained_marks,
            facultyID, time_stamp) VALUES 
            ('$studentID', '$year', '$semester', '$courseID',
            '$section', '$marks', '$facultyID', '$timeStamp')";
            $backlogTable = mysqli_query($conn, $backlogQuery);
            
            //Getting backlogID
            $result = mysqli_query($conn,
            "SELECT MAX(backlogID) AS backlogID
            FROM backlog_data_t");
            $row=mysqli_fetch_assoc($result); 
            $backlogID=$row['backlogID'];

            //Getting sectionID
            // $result = mysqli_query($conn,
            // "SELECT MAX(sectionID) AS secID
            // FROM section_t");
            // $row=mysqli_fetch_assoc($result); 
            // $secID=$row['secID'];

            $backlogCourseQuery = "INSERT INTO  backlog_course_t (backlogID, courseID) VALUES ('$backlogID', '$courseID')";
            $backlogCourseTable = mysqli_query($conn, $backlogCourseQuery);

            // $backlogSectionQuery = "INSERT INTO  backlog_section_t (backlogID, secID) VALUES 
            // ('$backlogID', '$sectionID')";
            // $backlogSectionTable = mysqli_query($conn, $backlogSectionQuery);
        }
?>
    
    <!-- JS file link -->
    <script src="main.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>