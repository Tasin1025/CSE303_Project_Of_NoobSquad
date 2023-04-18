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
    <script src="https://kit.fontawesome.com/41c61c6dc3.js" crossorigin="anonymous"></script>   
</head>
<body>
    <nav class="navigation1">
        <div class="content2 flex-con">
            <div><h4><?php echo $_SESSION['name']; ?> <br> Faculty</h4></div>
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
        <li class="list active">
            <a href="#">
            <span class="icon">
                <i class="fa-solid fa-bell fa-beat-fade fa-xl"></i>
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
                    <!--2nd navbar-->
        <div class="tab">
            <button class="custom-btn btn-9 tablinks" onclick="openCity(event, 'London')">Create Course Outline </button>&nbsp;&nbsp;
            <button class="custom-btn btn-10 tablinks" onclick="openCity(event, 'Paris')">View Course Online </button>&nbsp;&nbsp;
        </div>
        
        <div id="London" class="tabcontent">
            <h3>London</h3>
            <p>London is the capital city of England.</p>
        </div>
        
        <div id="Paris" class="tabcontent">
            <h3>Paris</h3>
            <p>Paris is the capital of France.</p> 
        </div>

        <div id="Containerbox" class="submitContainer" width="1200">
            
        </div>
    </div>

    <script src="main.js" ></script>
</body>
</html>