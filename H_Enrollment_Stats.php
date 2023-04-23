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
    <title>Higher Authority Enrollment Stats</title>
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
                <a href="F_Dashboard.php">
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
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-solid fa-chart-line fa-beat-fade fa-xl"></i>
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
                $sql = "SELECT sch.schoolName as categoryName, COUNT(s.studentID) AS studNumber
                        FROM student_t AS s INNER JOIN department_t AS d 
                        ON s.departmentID=d.departmentID
                        INNER JOIN school_t AS sch
                        ON d.schoolID=sch.schoolID
                        WHERE d.departmentID=s.departmentID 
                        AND s.enrollmentYear='$year' 
                        GROUP BY sch.schoolName";

                $result = mysqli_query($conn, $sql);
            } elseif ($category == "Department Wise") {
                $sql = "SELECT d.departmentName AS categoryName, COUNT(s.studentID) AS studNumber
                        FROM department_t AS d, student_t AS s
                        WHERE s.enrollmentYear='$year' AND d.departmentID=s.departmentID
                        GROUP BY s.departmentID";

                $result = mysqli_query($conn, $sql);
            } else {
                $sql = "SELECT p.programName AS categoryName,COUNT(s.studentID) AS studNumber
                        FROM student_t AS s,program_t AS p
                        WHERE s.enrollmentYear='$year' AND s.programID=p.programID
                        GROUP BY p.programName";

                $result = mysqli_query($conn, $sql);
            }
        }
        ?>

        <div>
            <canvas id="myChart" width="550" height="550"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            <?php
            foreach ($result as $data) {
                $name[] = $data['categoryName'];
                $number[] = $data['studNumber'];
            }

            ?>

            new Chart(ctx, {
                type: 'pie',
                data: {


                    labels: <?php echo json_encode($name) ?>,
                    datasets: [{
                        label: '<?php echo "Number of Student:" ?>',
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
        <h3><i><b></b><?php if (isset($_POST['submit'])) echo $category." Enrollment Status In ". $year ?>
</b></i></h3>
    </div>


    <script src="main.js"></script>
</body>

</html>