<?php
include 'connect.php';
session_start();

$studentID = "1910876";

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="main.css">
    <script src="https://kit.fontawesome.com/41c61c6dc3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navigation1">
        <div class="content2 flex-con">
            <div>
                <h4><?php echo $_SESSION['name']; ?> </h4>
                <small>Student</small>
            </div>
            <div><a href="#"><img src="icons8-kuroo-48.png" alt=""></a></div>
        </div>

        <ul>
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-solid fa-chart-pie fa-beat-fade fa-xl"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="list">
                <a href="OVERALL_PLO_ANALYSIS.php">
                    <span class="icon">
                        <i class="fa-brands fa-react fa-xl"></i>
                    </span>
                    <span class="title">OVERALL PLO ANALYSIS</span>
                </a>
            </li>
            <li class="list">
                <a href="S_COURSE_WISE_PLO_ANALYSIS.php">
                    <span class="icon">
                        <i class="fa-solid fa-thumbtack fa-xl"></i>
                    </span>
                    <span class="title">COURSE WISE PLO ANALYSIS</span>
                </a>
            </li>
            <li class="list">
                <a href="S_PLO_ACHIEVEMENT_TABLE.php">
                    <span class="icon">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </span>
                    <span class="title">PLO ACHIEVEMENT TABLE</span>
                </a>
            </li>
            <li class="list">
                <a href="S_GRADE_WISE_CO_ANALYSIS.php">
                    <span class="icon">
                        <i class="fa-solid fa-chart-line fa-xl"></i>
                    </span>
                    <span class="title">GRADE WISE CO ANALYSIS</span>
                </a>
            </li>
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
        
      <div class="container">
      <div>
        <!-- <div><a href="#"><img src="gpa.png" alt=""></a></div> -->
        <h3 style="text-align: center">GPA PERFORMANCE </h3>
            <canvas id="myChart" width="500" height="500"canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Spring 2020', 'Summer 2020', 'Autumn 2020'],
                    datasets: [{
                            label: 'Individual GPA',
                            data: [2.8, 3.0, 3.5],
                            backgroundColor: [
                                // 'rgba(153, 102, 255, 0.4)',
                                'rgba(75, 192, 192, 0.6)',
                                // 'rgba(255, 99, 132, 0.8)',
                                //  'rgba(255, 159, 64, 0.6)',
                                //  'rgba(255, 205, 86, 0.6)',

                                //  'rgba(54, 162, 235, 0.6)',

                                // 'rgba(201, 203, 207, 0.6)'
                            ],
                            borderColor: [
                                // 'rgb(255, 99, 132)',
                                // 'rgb(255, 159, 64)',
                                //  'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                // 'rgb(54, 162, 235)',
                                // 'rgb(153, 102, 255)',
                                // 'rgb(201, 203, 207)'
                            ],
                            tension: 0.2
                        },
                        {
                            label: 'Department GPA',
                            data: [2.4, 2.8, 2.9],
                            backgroundColor: [
                                // 'rgba(153, 102, 255, 0.4)',
                                // 'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 99, 132, 0.8)',
                                //  'rgba(255, 159, 64, 0.6)',
                                //  'rgba(255, 205, 86, 0.6)',

                                //  'rgba(54, 162, 235, 0.6)',

                                // 'rgba(201, 203, 207, 0.6)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                // 'rgb(255, 159, 64)',
                                //  'rgb(255, 205, 86)',
                                // 'rgb(75, 192, 192)',
                                // 'rgb(54, 162, 235)',
                                // 'rgb(153, 102, 255)',
                                // 'rgb(201, 203, 207)'
                            ],
                            tension: 0.2
                        }
                    ]

                },
                options: {
                    scales: {
                        x: {
                            display: false
                           
                        },
                        y: {
                            beginAtZero:false
                        }
                    }
                }
            });
        </script>
        <div>
        <h3 style="text-align: center">PLO PERFORMANCE </h3>
            <canvas id="myChart1" width="500" height="500" ></canvas>
        </div>
        <script>
            const ctx1 = document.getElementById('myChart1').getContext('2d');
            <?php
            while ($data = mysqli_fetch_array($plo)) {

                $plonum[] = "PLO" . $data['ploNum'];
                $percent[] = $data['percent'];
                // $percent1[] = $data['percent']-10;
            }
            while ($data = mysqli_fetch_array($resultDept)) {
                $percentDept[] = $data['percent'];
            }

            ?>

            new Chart(ctx1, {
                type: 'bar',
                data: {


                    labels: <?php echo json_encode($plonum) ?>,
                    datasets: [{
                        label: ['Individual'] ,
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
                        label:['Dept Average'],
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
        </script>
      </div>



    </div>

    <script src="main.js"></script>


</body>

</html>