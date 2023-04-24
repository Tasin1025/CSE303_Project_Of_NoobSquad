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
    <title>Higher Authority GPA Analysis</title>
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/41c61c6dc3.js" crossorigin="anonymous"></script>
</head>

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
                    ?></h4>
            </div>
            <div><a href="#"><img src="icons8-university-50.png" alt=""></a></div>
        </div>

        <ul style="top: 48%;">
            <li class="list">
                <a href="H_Dashboard.php">
                    <span class="icon">
                        <i class="fa-solid fa-chart-pie fa-xl"></i>
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
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-regular fa-copy fa-beat-fade fa-xl"></i>
                    </span>
                    <span class="title">GPA Analysis</span>
                </a>
            </li>
            <li class="list">
                <a href="H_Backlog.php">
                    <span class="icon">
                        <i class="fa-solid fa-database fa-xl"></i>
                    </span>
                    <span class="title">Backlog Data</span>
                </a>
            <li class="list">
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
                    <label class="input-text" for="inputGroupSelect01">Select Year: </label>
                    <select name="year" class="form-select bg-info-subtle" id="inputGroupSelect02">
                        <option value="2020" selected>2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                    </select>
                </div>
                <div class="input w-25 ">
                    <label class="input-text" for="inputGroupSelect01">Select Category: </label>
                    <select name="category" class="form-select bg-info-subtle" id="inputGroupSelect02">
                        <option value="School Wise" selected>School Wise</option>
                        <option value="Department Wise">Department Wise</option>
                        <option value="Program Wise">Program Wise</option>
                    </select>
                </div>
                <button name="submit" class="btn btn-primary w-25 mx-0 mt-4">Submit
                </button>
                <br><br>
        </form>

        <?php

        if (isset($_POST['submit'])) {
            $year = $_POST['year'];
            $category = $_POST['category'];
            if ($category == "School Wise") {
                $sqlAutumn = "SELECT sch.schoolID AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM student_t AS s, registration_t AS r,department_t AS d,school_t
                        AS sch,student_course_performance_t AS scp, section_t AS sec
                        WHERE scp.registrationID=r.registrationID AND r.studentID=s.studentID
                        AND r.sectionID=sec.sectionID AND s.departmentID=d.departmentID 
                        AND d.schoolID=sch.schoolID AND (sec.semester='Autumn' OR sec.semester='autumn')
                        AND sec.year='$year'
                        GROUP BY sch.schoolID";
                $resultAutumn = mysqli_query($conn, $sqlAutumn);

                $sqlSpring = "SELECT sch.schoolID AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM student_t AS s, registration_t AS r,department_t AS d,school_t
                        AS sch,student_course_performance_t AS scp, section_t AS sec
                        WHERE scp.registrationID=r.registrationID AND r.studentID=s.studentID
                        AND r.sectionID=sec.sectionID AND s.departmentID=d.departmentID 
                        AND d.schoolID=sch.schoolID AND (sec.semester='Spring' OR sec.semester='spring')
                        AND sec.year='$year'
                        GROUP BY sch.schoolID";
                $resultSpring = mysqli_query($conn, $sqlSpring);

                $sqlSummer = "SELECT sch.schoolID AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM student_t AS s, registration_t AS r,department_t AS d,school_t
                        AS sch,student_course_performance_t AS scp, section_t AS sec
                        WHERE scp.registrationID=r.registrationID AND r.studentID=s.studentID
                        AND r.sectionID=sec.sectionID AND s.departmentID=d.departmentID 
                        AND d.schoolID=sch.schoolID AND (sec.semester='Summer' OR sec.semester='summer')
                        AND sec.year='$year'
                        GROUP BY sch.schoolID";
                $resultSummer = mysqli_query($conn, $sqlSummer);
            } elseif ($category == "Department Wise") {
                $sqlSummer = "SELECT s.departmentID AS categoryName, AVG(scp.gradePoint) as GPA
                        FROM student_t AS s,student_course_performance_t
                        AS scp, registration_t AS r, section_t AS sec
                        WHERE r.registrationID=scp.registrationID AND
                        r.studentID=s.studentID AND r.sectionID=sec.sectionID
                        AND (sec.semester='summer' OR sec.semester='Summer') AND sec.year='$year'
                        GROUP BY s.departmentID";
                $resultSummer = mysqli_query($conn, $sqlSummer);

                $sqlSpring = "SELECT s.departmentID AS categoryName, AVG(scp.gradePoint) as GPA
                        FROM student_t AS s,student_course_performance_t
                        AS scp, registration_t AS r, section_t AS sec
                        WHERE r.registrationID=scp.registrationID AND
                        r.studentID=s.studentID AND r.sectionID=sec.sectionID
                        AND (sec.semester='spring' OR sec.semester='Spring') AND sec.year='$year'
                        GROUP BY s.departmentID";
                $resultSpring = mysqli_query($conn, $sqlSpring);

                $sqlAutumn = "SELECT s.departmentID AS categoryName, AVG(scp.gradePoint) as GPA
                        FROM student_t AS s,student_course_performance_t
                        AS scp, registration_t AS r, section_t AS sec
                        WHERE r.registrationID=scp.registrationID AND
                        r.studentID=s.studentID AND r.sectionID=sec.sectionID
                        AND (sec.semester='autumn' OR sec.semester='Autumn') AND sec.year='$year'
                        GROUP BY s.departmentID";
                $resultAutumn = mysqli_query($conn, $sqlAutumn);
            } else {
                $sqlSpring = "SELECT p.programName AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM registration_t AS r, student_t AS s, student_course_performance_t 
                        AS scp, program_t AS p, section_t AS sec
                        WHERE r.studentID=s.studentID AND scp.registrationID=r.registrationID 
                        AND r.sectionID=sec.sectionID AND s.programID=p.programID 
                        AND (sec.semester='spring' OR sec.semester= 'Spring')  AND sec.year='$year'
                        GROUP BY p.programID";
                $resultSpring = mysqli_query($conn, $sqlSpring);

                $sqlSummer = "SELECT p.programName AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM registration_t AS r, student_t AS s, student_course_performance_t 
                        AS scp, program_t AS p, section_t AS sec
                        WHERE r.studentID=s.studentID AND scp.registrationID=r.registrationID 
                        AND r.sectionID=sec.sectionID AND s.programID=p.programID 
                        AND (sec.semester='summer' OR sec.semester= 'Summer')  AND sec.year='$year'
                        GROUP BY p.programID";
                $resultSummer = mysqli_query($conn, $sqlSummer);

                $sqlAutumn = "SELECT p.programName AS categoryName, AVG(scp.gradePoint) AS GPA
                        FROM registration_t AS r, student_t AS s, student_course_performance_t 
                        AS scp, program_t AS p, section_t AS sec
                        WHERE r.studentID=s.studentID AND scp.registrationID=r.registrationID 
                        AND r.sectionID=sec.sectionID AND s.programID=p.programID 
                        AND (sec.semester='autumn' OR sec.semester= 'Autumn')  AND sec.year='$year'
                        GROUP BY p.programID";
                $resultAutumn = mysqli_query($conn, $sqlAutumn);
            }
        }
        ?>

        <div>
            <canvas id="myChart" width="850" height="550"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            <?php
            foreach ($resultAutumn as $data) {
                $name[] = $data['categoryName'];
                $number[] = $data['GPA'];
            }
            ?>

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($name) ?>,
                    datasets: [{
                        label: '<?php echo "GPA:" ?>',
                        data: <?php echo json_encode($number) ?>,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(201, 203, 207, 0.6)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: {


                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
<h3><i><b></b><?php if (isset($_POST['submit'])) echo $category." CGPA In Autumn ". $year ?>
</b></i></h3>        <br><br>
        <div>
            <canvas id="myChart2" width="850" height="550"></canvas>
        </div>
        <script>
            const ctx2 = document.getElementById('myChart2').getContext('2d');
            <?php
            foreach ($resultSpring as $data) {
                $name[] = $data['categoryName'];
                $number[] = $data['GPA'];
            }

            ?>

            new Chart(ctx2, {
                type: 'line',
                data: {


                    labels: <?php echo json_encode($name) ?>,
                    datasets: [{
                        label: '<?php echo "CGPA:" ?>',
                        data: <?php echo json_encode($number) ?>,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(201, 203, 207, 0.6)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: {


                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
<h3><i><b></b><?php if (isset($_POST['submit'])) echo $category." CGPA In Spring ". $year ?>
</b></i></h3>        <br><br>
        <div>
            <canvas id="myChart3" width="850" height="550"></canvas>
        </div>
        <script>
            const ctx3 = document.getElementById('myChart3').getContext('2d');
            <?php
            foreach ($resultSpring as $data) {
                $name[] = $data['categoryName'];
                $number[] = $data['GPA'];
            }

            ?>

            new Chart(ctx3, {
                type: 'line',
                data: {


                    labels: <?php echo json_encode($name) ?>,
                    datasets: [{
                        label: '<?php echo "CGPA:" ?>',
                        data: <?php echo json_encode($number) ?>,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(201, 203, 207, 0.6)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: {


                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <h3><i><b></b><?php if (isset($_POST['submit'])) echo $category." CGPA In Summer ". $year ?>
</b></i></h3>
    </div>

    <script src="main.js"></script>
</body>

</html>