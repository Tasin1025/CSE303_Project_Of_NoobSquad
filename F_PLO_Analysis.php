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
        <!--2nd navbar-->
        <div class="tab">
            <form method="POST">
                <input style="background-color:rgba(255, 99, 132, 0.8);height:50px;border: 1px solid;cursor: pointer;border-radius: 5px;font-size: 14px;letter-spacing:2px;
                      font-weight: bold;text-transform:uppercase; border: none;outline: none;text-align: center;
                      margin-left:43%;margin-top:13px;" type="text" placeholder="Enter Student ID" name="studentID" />
                <button name="submit" class="custom-btn btn-9 tablinks">Submit ID </button>&nbsp;&nbsp;
            </form>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $studentID = $_POST['studentID'];

            include 'connect.php';

            $sql = "SELECT plo.ploNum AS ploNum, 
                    AVG((ans.markObtained/q.markPerQuestion)*100) AS percent
                    FROM registration_t AS r, answer_t AS ans, question_t AS q, 
                    co_t AS co, plo_t AS plo
                    WHERE r.registrationID=ans.registrationID 
                    AND ans.examID=q.examID
                    AND ans.answerNum=q.questionNum AND q.coNum=co.coNum 
                    AND q.courseID=co.courseID AND co.ploID=plo.ploID 
                    AND r.studentID='$studentID'
                    GROUP BY plo.ploNum,r.studentID";
            $plo = mysqli_query($conn, $sql);

            $sqlSch = "SELECT plo.ploNum AS ploNum, 
                    AVG((ans.markObtained/q.markPerQuestion)*100) AS percent
                    FROM registration_t AS r, answer_t AS ans, question_t AS q, 
                    co_t AS co, plo_t AS plo, student_t AS s, program_t AS p, department_t AS d
                    WHERE r.studentID=s.studentID 
                    AND r.registrationID=ans.registrationID AND ans.examID=q.examID
                    AND ans.answerNum=q.questionNum  
                    AND q.coNum=co.coNum AND q.courseID=co.courseID AND co.ploID=plo.ploID 
                    AND s.departmentID=d.departmentID
                    AND d.schoolID=(SELECT d.schoolID FROM student_t AS s, 
                    department_t AS d WHERE s.studentID='$studentID' 
                    AND s.departmentID=d.departmentID)
                    GROUP BY plo.ploNum";
            $resultSch = mysqli_query($conn, $sqlSch);

            $sqlDept = "SELECT plo.ploNum AS ploNum, AVG((ans.markObtained/q.markPerQuestion)*100) 
                    AS percent
                    FROM registration_t AS r, answer_t AS ans, question_t AS q, 
                    co_t AS co, plo_t AS plo, student_t AS s WHERE r.studentID=s.studentID 
                    AND r.registrationID=ans.registrationID AND ans.examID=q.examID
                    AND ans.answerNum=q.questionNum 
                    AND q.coNum=co.coNum AND q.courseID=co.courseID AND co.ploID=plo.ploID
                    AND s.departmentID=(SELECT s.departmentID FROM student_t AS s 
                    WHERE s.studentID='$studentID')
                    GROUP BY plo.ploNum";
            $resultDept = mysqli_query($conn, $sqlDept);


            $sqlPro = "SELECT plo.ploNum AS ploNum, 
                    AVG((ans.markObtained/q.markPerQuestion)*100) AS percent
                    FROM registration_t AS r, answer_t AS ans, question_t AS q, 
                    co_t AS co, plo_t AS plo, student_t AS s, program_t AS p
                    WHERE r.studentID=s.studentID 
                    AND r.registrationID=ans.registrationID AND ans.examID=q.examID
                    AND ans.answerNum=q.questionNum  
                    AND q.coNum=co.coNum AND q.courseID=co.courseID AND co.ploID=plo.ploID 
                    AND s.programID=p.programID
                    AND s.programID=(SELECT s.programID FROM student_t AS s WHERE s.studentID='$studentID')
                    GROUP BY plo.ploNum";
            $resultPro = mysqli_query($conn, $sqlPro);
        }

        ?>

        <div class="container">

            <div>
                <!-- <h3 style="text-align: center; display:flex; margin:auto">Plo Analysis with Department Average </h3> -->
                <h3 style="text-align: center; display:flex; margin:auto"> 

                <?php if (isset($_POST['submit'])) echo "Plo Analysis with Department Average "  ?>
                </h3>
                <canvas id="myChart1" width="600" height="450"></canvas>
            </div>
            <div>
                <!-- <h3 style="text-align: center">Plo Analysis with School Average </h3> -->
                <?php if (isset($_POST['submit'])) echo "Plo Analysis with School Average "  ?>
                <canvas style id="myChart" width="600" height="450"></canvas>
            </div>
            <script>
                const ctx1 = document.getElementById('myChart1').getContext('2d');
                <?php
                while ($data = mysqli_fetch_array($plo)) {

                    $plonum[] = "PLO" . $data['ploNum'];
                    $percent[] = $data['percent'];
                }
                while ($data = mysqli_fetch_array($resultDept)) {

                    //  $plonum[] = "PLO" . $data['ploNum'];
                    $percentDept[] = $data['percent'];
                }
                while ($data = mysqli_fetch_array($resultPro)) {

                    //   $plonum[] = "PLO" . $data['ploNum'];
                    $percentPro[] = $data['percent'];
                }
                while ($data = mysqli_fetch_array($resultSch)) {

                    //  $plonum[] = "PLO" . $data['ploNum'];
                    $percentSch[] = $data['percent'];
                }

                ?>

                new Chart(ctx1, {
                    type: 'bar',
                    data: {

                        labels: <?php echo json_encode($plonum) ?>,
                        datasets: [{
                                label: <?php echo json_encode("Student ID: $studentID") ?>,
                                data: <?php echo json_encode($percent) ?>,
                                backgroundColor: [

                                    'rgba(75, 192, 192, 0.7)'

                                ],
                                borderColor: [

                                    'rgb(75, 192, 192)'

                                ],
                                borderWidth: 1
                            },
                            {
                                label: ['Dept Average'],
                                data: <?php echo json_encode($percentDept) ?>,
                                backgroundColor: [

                                    'rgba(255, 99, 132, 0.8)',

                                ],
                                borderColor: [

                                    'rgb(255, 99, 132)',

                                ],
                                borderWidth: 1
                            }
                        ]
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

                const ctx = document.getElementById('myChart').getContext('2d');


                new Chart(ctx, {
                    type: 'bar',
                    data: {


                        labels: <?php echo json_encode($plonum) ?>,
                        datasets: [{
                                label: <?php echo json_encode("Student ID: $studentID") ?>,
                                data: <?php echo json_encode($percent) ?>,
                                backgroundColor: [

                                    'rgba(75, 192, 192, 0.7)'

                                ],
                                borderColor: [

                                    'rgb(75, 192, 192)'

                                ],
                                borderWidth: 1
                            },
                            {
                                label: ['Program Average'],
                                data: <?php echo json_encode($percentSch) ?>,
                                backgroundColor: [

                                    'rgb(153, 102, 255,0.8)',

                                ],
                                borderColor: [

                                    'rgb(153, 102, 255)',

                                ],
                                borderWidth: 1
                            }
                        ]
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
        </div>

        <div class="container1">
            <div>
                <!-- <h3 style="text-align: center">Plo Analysis with Program Average </h3> -->
                <?php if (isset($_POST['submit'])) echo "Plo Analysis with Program Average "  ?>
                <canvas id="myChart3"></canvas>
            </div>
            <script>
                const ctx3 = document.getElementById('myChart3').getContext('2d');

                new Chart(ctx3, {
                    type: 'bar',
                    data: {


                        labels: <?php echo json_encode($plonum) ?>,
                        datasets: [{
                                label: <?php echo json_encode("Student ID: $studentID") ?>,
                                data: <?php echo json_encode($percent) ?>,
                                backgroundColor: [

                                    'rgba(75, 192, 192, 0.7)'

                                ],
                                borderColor: [

                                    'rgb(75, 192, 192)'

                                ],
                                borderWidth: 1
                            },
                            {
                                label: ['School Average'],
                                data: <?php echo json_encode($percentPro) ?>,
                                backgroundColor: [

                                    'rgba(255, 205, 86, 0.6)',

                                ],
                                borderColor: [

                                    'rgba(255, 205, 86, 0.6)',

                                ],
                                borderWidth: 1
                            }
                        ]
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
        </div>

    </div>

    <script src="main.js"></script>
</body>

</html>