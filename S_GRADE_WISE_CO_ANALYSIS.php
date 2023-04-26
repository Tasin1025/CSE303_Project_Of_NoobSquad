<?php
session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
            <li class="list">
                <a href="S_Dashboard.php">
                    <span class="icon">
                        <i class="fa-solid fa-chart-pie fa-xl"></i>
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
                    <span class="title">Spider Chart Analysis</span>
                </a>
            </li>
            <li class="list active">
                <a href="#">
                    <span class="icon">
                        <i class="fa-solid fa-chart-line fa-beat-fade fa-xl"></i>
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


        <h1>GRADE WISE CO ANALYSIS</h1>
        <form method="POST">
            <div class="bg-primary-subtle  p-5 d-flex flex-column align-items-center rounded">
                <div class="input w-25 ">
                    <label class="input-text" for="inputGroupSelect01">Enrolled Course: </label>
                    <select name="courseID" class="form-select bg-info-subtle" id="inputGroupSelect02">
                        <option value="CSE101" selected>CSE101</option>
                        <option value="EEE131">EEE131</option>
                        <option value="ENG101">ENG101</option>
                    </select>
                </div>
                <button name="submit" class="btn btn-primary w-25 mx-0 mt-4" >Submit
                </button>
                <br><br>
        </form>
        
        <?php

        if (isset($_POST['submit'])) {
            $studentID =  $_SESSION["id"];
            $courseID = $_POST['courseID'];
            $gradeWiseCoQuery = "SELECT q.coNum,
                    AVG((ans.markObtained/q.markPerQuestion)*100) AS percent
                    FROM registration_t AS r, answer_t AS ans, question_t AS q, 
                    co_t AS co, po_t AS po
                    WHERE r.registrationID=ans.registrationID 
                    AND ans.examID=q.examID
                    AND ans.answerNum=q.questionNum AND q.coNum=co.coNum
                    AND r.studentID= '$studentID'
                    and q.courseID = '$courseID'
                    Group by q.coNum";
            $gradeWiseCoTable = mysqli_query($conn, $gradeWiseCoQuery);
        }
        ?>



        <div>
            <canvas id="myChart" width="1200" height="400"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            <?php
            foreach ($gradeWiseCoTable as $data) {
                $co[] = "CO " . $data['coNum'];
                $percent1[] = $data['percent'];
            }

            ?>

            new Chart(ctx, {
                type: 'bar',
                data: {


                    labels: <?php echo json_encode($co) ?>,
                    datasets: [{
                        label: '<?php echo $courseID ?>',
                        data: <?php echo json_encode($percent1) ?>,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.4)',
                            // 'rgba(75, 192, 192, 0.6)',
                            // 'rgba(255, 99, 132, 0.6)',
                            // 'rgba(255, 159, 64, 0.6)',
                            // 'rgba(255, 205, 86, 0.6)',

                            //  'rgba(54, 162, 235, 0.6)',

                            // 'rgba(201, 203, 207, 0.6)'
                        ],
                        borderColor: [
                            // 'rgb(255, 99, 132)',
                            // 'rgb(255, 159, 64)',
                            // 'rgb(255, 205, 86)',
                            // 'rgb(75, 192, 192)',
                            // 'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            // 'rgb(201, 203, 207)'
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

    </div>

    <script src="main.js"></script>
</body>

</html>