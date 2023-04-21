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
    <title>Higher Authority PLO Achievement Stats</title>
    <link rel="stylesheet" href="main.css">
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
        <li class="list active">
            <a href="#">
            <span class="icon">
                <i class="fa-solid fa-thumbtack fa-beat-fade fa-xl"></i>
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
        <h1>Higher Authority PLO Achievement Stats</h1>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
    
        Why do we use it?
        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
    
        Where does it come from?
        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
    
        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
    
        Where can I get some?
        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
        
    </div>

    <script src="main.js" ></script>
</body>
</html>