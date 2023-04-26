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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head>

<body>
    <nav class="navigation1">
        <div class="content2 flex-con">

            <div>
                <h4><?php echo $_SESSION['name']; ?> <br>
                    <?php
                    $id = $_SESSION['id'];
                    //$vcQuery = "SELECT v_employeeID FROM vc_t WHERE v_employeeID = $id";
                    $vcQuery = "SELECT COUNT(*) FROM vc_t WHERE v_employeeID = $id";
                    $vcTable = mysqli_query($conn, $vcQuery);
                    $vcID = mysqli_fetch_row($vcTable);

                    $deanQuery = "SELECT COUNT(*) FROM dean_t WHERE d_employeeID = $id";
                    $deanTable = mysqli_query($conn, $deanQuery);
                    $deanID = mysqli_fetch_row($deanTable);

                    if ($vcID[0] == 1) {
                        echo "VC";
                    } elseif ($deanID[0] == 1) {
                        echo "Dean";
                    } else {
                        echo "Department Head";
                    }
                    ?>
                </h4>
            </div>
            <div><a href="#"><img src="icons8-university-50.png" alt=""></a></div>
        </div>

        <ul style="top: 48%;">
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-solid fa-chart-pie fa-beat-fade fa-xl"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="list">
                <a href="H_PLO_Analysis.php">
                    <span class="icon">
                        <i class="fa-brands fa-react fa-xl"></i>
                    </span>
                    <span class="title">PLO Analysis</span>
                </a>
            </li>
            <li class="list">
                <a href="H_PLO_Achievement_Stats.php">
                    <span class="icon">
                        <i class="fa-solid fa-thumbtack fa-xl"></i>
                    </span>
                    <span class="title">PLO Achievement Stats</span>
                </a>
            </li>
            <li class="list">
                <a href="H_Spider_Chart_Analysis.php">
                    <span class="icon">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </span>
                    <span class="title">Spider Chart Analysis</span>
                </a>
            </li>
            <li class="list">
                <a href="H_Enrollment_Stats.php">
                    <span class="icon">
                        <i class="fa-solid fa-chart-line fa-xl"></i>
                    </span>
                    <span class="title">Enrollment Stats</span>
                </a>
            </li>
            <li class="list">
                <a href="H_GPA_Analysis.php">
                    <span class="icon">
                        <i class="fa-regular fa-copy fa-xl"></i>
                    </span>
                    <span class="title">GPA Analysis</span>
                </a>
            </li>
            <!-- backlog button-->
            <li class="list">
                <a href="H_Backlog.php">
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


        <table class="table table-hover text center">
            <thead class="table-dark">
                <tr>
                    <!-- <th scope="col">Backlog ID</th> -->
                    <th scope="col">Student ID</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Course</th>
                    <th scope="col">Section</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Year</th>
                    <th scope="col">Faculty ID</th>
                    <th scope="col">Time Stamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connect.php';
                $backlogData = "SELECT *
                FROM backlog_data_t";
                $result = mysqli_query($conn, $backlogData);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <?php
                    $grade = "Z";
                    if ($row['obtained_marks'] >= 90 && $row['obtained_marks'] <= 100)
                        $grade = "A";
                    elseif ($row['obtained_marks'] >= 85 && $row['obtained_marks'] <= 89)
                        $grade = "A-";
                    elseif ($row['obtained_marks'] >= 80 && $row['obtained_marks'] <= 84)
                        $grade = "B+";
                    elseif ($row['obtained_marks'] >= 75 && $row['obtained_marks'] <= 79)
                        $grade = "B";
                    elseif ($row['obtained_marks'] >= 70 && $row['obtained_marks'] <= 74)
                        $grade = "B-";
                    elseif ($row['obtained_marks'] >= 60 && $row['obtained_marks'] <= 69)
                        $grade = "C+";
                    elseif ($row['obtained_marks'] >= 65 && $row['obtained_marks'] <= 64)
                        $grade = "C";
                    elseif ($row['obtained_marks'] >= 55 && $row['obtained_marks'] <= 59)
                        $grade = "C-";
                    elseif ($row['obtained_marks'] >= 50 && $row['obtained_marks'] <= 54)
                        $grade = "D+";
                    elseif ($row['obtained_marks'] >= 45 && $row['obtained_marks'] <= 49)
                        $grade = "D";
                    elseif ($row['obtained_marks'] < 44)
                        $grade = "F";
                    ?>

                    <tr>
                        <!-- <th scope="row">1</th> -->
                        <!-- <td><?php echo $row['backlogID']; ?></td> -->
                        <td><?php echo $row['studentID']; ?></td>
                        <td><?php echo $grade; ?></td>
                        <td><?php echo $row['enrolled_course']; ?></td>
                        <td><?php echo $row['enrolled_section']; ?></td>
                        <td><?php echo $row['edu_semester']; ?></td>
                        <td><?php echo $row['edu_year']; ?></td>
                        <td><?php echo $row['facultyID']; ?></td>
                        <td><?php echo $row['time_stamp']; ?></td>
                    </tr>

                <?php
                }

                ?>

            </tbody>
        </table>
        <!-- JS file link -->
        <script src="main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>