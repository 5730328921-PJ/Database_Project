<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/php; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CP Admin Panel </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <?php
    DEFINE('DB_USERNAME', 'root');
    DEFINE('DB_PASSWORD', 'root');
    DEFINE('DB_HOST', 'localhost');
    DEFINE('DB_DATABASE', 'CPstudent CARE');
    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $q = sprintf("SELECT teacherID, image, pfname, plname FROM teacher WHERE login = \"%s\"", $_GET["login"]);
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);
    while ($row = $result->fetch_assoc()) {
        DEFINE('TEACHER_FIRSTNAME', $row["pfname"]);
        DEFINE('TEACHER_LASTNAME', $row["plname"]);
        DEFINE('TEACHER_IMAGE', $row["image"]);
        DEFINE('TEACHER_ID', $row["teacherID"]);
    }
   ?>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.php" class="site_title"><i class="glyphicon glyphicon-cog"></i> <span>CPstudent CARE</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <?php printf("<img src=\"images/%s.jpg\" class=\"img-circle profile_img\">", TEACHER_IMAGE); ?>
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <!--<h2>Prof.Proadpran Punyabukkana</h2>-->
                            <h2><?php
                                printf("%s %s", TEACHER_FIRSTNAME, TEACHER_LASTNAME);
                            ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br>

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-bar-chart"></i>HOME</a>
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                                <?php
                                    printf("<li><a href=\"allstudent.php?login=%s\"><i class=\"fa fa-user\"></i>STUDENTS</a>", $_GET["login"]);
                                ?>
                                <!--<li><a href="allstudent.php"><i class="fa fa-user"></i>STUDENTS</a>-->
                                </li>
                                <li><a><i class="fa fa-pencil"></i>COURSES<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <?php
                                            $q = sprintf("SELECT DISTINCT S.subjectID, S.subjectName FROM teach T, subject S WHERE T.teacherID = %s and T.subjectID = S.subjectID", $_GET["login"]);
                                            $result = $mysqli->query($q);
                                            while ($row = $result->fetch_assoc()) {
                                                printf("<li><a href=\"subject.php\">%s %s</a></li>", $row["subjectID"], $row["subjectName"]);
                                            }
                                        ?>
                                        <!--<li><a href="subject.php">2301710 DATABASE</a></li>
                                        <li><a href="#">2110513 ASSISTIVE TECHNOLOGY</a></li>-->
                                    </ul>
                                </li>

                                <li><a href="alert.php"><i class="fa fa-frown-o"></i>ALERT</a>
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php printf("<img src=\"images/%s.jpg\" alt=\"\">", TEACHER_IMAGE);?>
                                    <?php printf("%s %s", TEACHER_FIRSTNAME, TEACHER_LASTNAME); ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="login.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->
                <div class="row tile_count">
                    </br>
                    </br>
                    <h3>&nbsp;HOME</h3>
                    <div class="col-md-6">
                        <h4>Recently Event<small> &nbsp;&nbsp;( historical data 1 week )</small></h4>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Deduct</h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table " action="getJson">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Profile image </th>
                                                <th class="column-title">Student ID</th>
                                                <th class="column-title">First name</th>
                                                <th class="column-title">Last name</th>
                                                <th class="column-title">Cause</th>
                                                <th class="column-title">Score Deducted</th>
                                                <th class="column-title">Date</th>
                                                <th class="column-title">Time</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                          <?php
                                          $q="SELECT S.image, S.studentID, S.firstName, S.lastName, D.note, D.scorededuction, D.date, D.time FROM student S, deduct D WHERE S.studentID = D.studentID ORDER BY D.date, D.time ASC";
                                          $result = $mysqli->query($q);
                                          $total= mysqli_num_rows($result);
                                          $count =1;
                                          while($row = $result->fetch_assoc()) {
                                            $timediff = (strtotime(date("Y-m-d")) - strtotime($row["date"])) / (60 * 60 * 24); 
                                            if ($timediff <= 7 && $timediff >= 0) {
                                                if($count%2==0){
                                                echo "<tr class=\"even pointer\" onclick=\"window.document.location='student.php';\">";
                                                printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                printf("<td >%s</td>
                                                    <td >%s</td>
                                                    <td >%s</td>
                                                    <td >%s</td>
                                                    <td >-%s</td>
                                                    <td >%s</td>
                                                    <td >%s</td>
                                                    </td>",$row["studentID"],$row["firstName"],$row["lastName"],$row["note"],$row["scorededuction"],$row["date"],$row["time"]);
                                                echo"</tr>";
                                                $i++;
                                                }
                                                else{
                                                echo "<tr class=\"odd pointer\" onclick=\"window.document.location='student.php';\">";
                                                printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                printf("<td >%s</td>
                                                        <td >%s</td>
                                                        <td >%s</td>
                                                        <td >%s</td>
                                                        <td >-%s</td>
                                                        <td >%s</td>
                                                        <td >%s</td>
                                                        </td>",$row["studentID"],$row["firstName"],$row["lastName"],$row["note"],$row["scorededuction"],$row["date"],$row["time"]);
                                                echo"</tr>";
                                                $i++;
                                                }
                                            }
                                          }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Absent</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table ">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Profile image </th>
                                                <th class="column-title">Student ID</th>
                                                <th class="column-title">First Name</th>
                                                <th class="column-title">Last name</th>
                                                <th class="column-title">Cause</th>
                                                <th class="column-title">Date</th>
                                                <th class="column-title">Period (days)</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $q="SELECT S.image, S.studentID, S.firstName, S.lastName, A.cause, A.date, A.period FROM student S, absent A WHERE S.studentID = A.studentID ORDER BY A.date, A.period ASC";
                                            $result = $mysqli->query($q);
                                            $total= mysqli_num_rows($result);
                                            $count =1;
                                            while($row = $result->fetch_assoc()) {
                                                $timediff = (strtotime($row["date"]) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
                                                if ($timediff <= 7 && $timediff >= 0) {
                                                    if($count%2==0){
                                                        echo "<tr class=\"even pointer\" onclick=\"window.document.location='student.php';\">";
                                                        printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                        printf("<td >%s</td>
                                                            <td >%s</td>
                                                            <td >%s</td>
                                                            <td >%s</td>
                                                            <td >%s</td>
                                                            <td >%s</td>
                                                            </td>",$row["studentID"],$row["firstName"],$row["lastName"],$row["cause"],$row["date"],$row["period"]);
                                                        echo"</tr>";
                                                        $i++;
                                                    }
                                                    else{
                                                        echo "<tr class=\"odd pointer\" onclick=\"window.document.location='student.php';\">";
                                                        printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                        printf("<td >%s</td>
                                                                <td >%s</td>
                                                                <td >%s</td>
                                                                <td >%s</td>
                                                                <td >%s</td>
                                                                <td >%s</td>
                                                                </td>",$row["studentID"],$row["firstName"],$row["lastName"],$row["cause"],$row["date"],$row["period"]);
                                                        echo"</tr>";
                                                        $i++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Amount of Students</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="" style="width:100%">
                                    <tr>
                                        <td>
                                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 35px"></canvas>
                                        </td>
                                        <td>
                                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 35px"></canvas>
                                        </td>
                                        <td>
                                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 35px"></canvas>
                                        </td>
                                        <td>
                                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 35px"></canvas>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <h2>Year 1</h2>
                                        </td>
                                        <td align="center">
                                            <h2>Year 2</h2>
                                        </td>
                                        <td align="center">
                                            <h2>Year 3</h2>
                                        </td>
                                        <td align="center">
                                            <h2>Year 4</h2>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                        <div class="col-md-12 col-sm-12 col-xs-12 widget_tally_box">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>GPAX</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="GPAX_BAR" style="width:100%; height:200px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 widget_tally_box">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>AWARD</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="AWARD_BAR" style="width:100%; height:200px;"></div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- jQuery -->
                    <script src="vendors/jquery/dist/jquery.min.js"></script>
                    <!-- Bootstrap -->
                    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                    <!-- FastClick -->
                    <script src="vendors/fastclick/lib/fastclick.js"></script>
                    <!-- NProgress -->
                    <script src="vendors/nprogress/nprogress.js"></script>
                    <!-- Chart.js -->
                    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
                    <!-- jQuery Sparklines -->
                    <script src="vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
                    <!-- bootstrap-progressbar -->
                    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
                    <!-- iCheck -->
                    <script src="vendors/iCheck/icheck.min.js"></script>
                    <!-- Skycons -->
                    <script src="vendors/skycons/skycons.js"></script>
                    <!-- Flot -->
                    <script src="vendors/Flot/jquery.flot.js"></script>
                    <script src="vendors/Flot/jquery.flot.pie.js"></script>
                    <script src="vendors/Flot/jquery.flot.time.js"></script>
                    <script src="vendors/Flot/jquery.flot.stack.js"></script>
                    <script src="vendors/Flot/jquery.flot.resize.js"></script>
                    <!-- Flot plugins -->
                    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
                    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
                    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
                    <!-- DateJS -->
                    <script src="vendors/DateJS/build/date.js"></script>
                    <!-- JQVMap -->
                    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
                    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
                    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
                    <!-- bootstrap-daterangepicker -->
                    <script src="vendors/moment/min/moment.min.js"></script>
                    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
                    <!-- morris.js -->
                    <script src="vendors/raphael/raphael.min.js"></script>
                    <script src="vendors/morris.js/morris.min.js"></script>
                    <!-- gauge.js -->
                    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
                    <!-- Datatables -->
                    <script src="vendors/datatables.net/js/jquery.dataTables.js"></script>
                    <!-- Custom Theme Scripts -->
                    <script src="build/js/custom.js"></script>
    <?php
    $mysqli->close();
    ?>
</body>

</html>
