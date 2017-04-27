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
    <script type="text/javascript" src="build/js/canvasjs.min.js"></script>
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

    <?php
    //Year2015
    $q = sprintf("SELECT A.semester, A.grade, S.semesterRec FROM adddrop A, subject S WHERE A.subjectID = %s and A.sectionNO = %s and A.subjectID = S.subjectID", $_GET["subjectID"], $_GET["sectionNo"]);
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);

    $a1 = 0;
    $bp1 = 0;
    $b1 = 0;
    $cp1 = 0;
    $c1 = 0;
    $dp1 = 0;
    $d1 = 0;
    $f1 = 0;

    $a2 = 0;
    $bp2 = 0;
    $b2 = 0;
    $cp2 = 0;
    $c2 = 0;
    $dp2 = 0;
    $d2 = 0;
    $f2 = 0;

    while ($row = $result->fetch_assoc()) {
        list($yearStudy, $semesterStudy) = explode("/", $row["semester"]);
        list($yearSubject, $semesterSubject) = explode("/", $row["semesterRec"]);
        $teachYear = 2;
        if ($semesterSubject == 12)
            $teachYear = 1;
        if (($yearStudy == (date("Y") - ((date("m") <= 7) ? 1 : 0)) - ($teachYear / 2))
            && ($semesterStudy == ((date("m") > 7) ? 1 : 2) - ($teachYear % 2))) {
            if ($row["grade"] == "A")
                $a1++;
            else if ($row["grade"] == "B+")
                $bp1++;
            else if ($row["grade"] == "B")
                $b1++;
            else if ($row["grade"] == "C+")
                $cp1++;
            else if ($row["grade"] == "C")
                $c1++;
            else if ($row["grade"] == "D+")
                $dp1++;
            else if ($row["grade"] == "D")
                $d1++;
            else if ($row["grade"] == "F")
                $f1++;
        }

        else if (($yearStudy == (date("Y") - ((date("m") <= 7) ? 1 : 0)) - $teachYear)
               && ($semesterStudy == ((date("m") > 7) ? 1 : 2)) - ((2 * $teachYear) % 2)) {
            if ($row["grade"] == "A")
                $a2++;
            else if ($row["grade"] == "B+")
                $bp2++;
            else if ($row["grade"] == "B")
                $b2++;
            else if ($row["grade"] == "C+")
                $cp2++;
            else if ($row["grade"] == "C")
                $c2++;
            else if ($row["grade"] == "D+")
                $dp2++;
            else if ($row["grade"] == "D")
                $d2++;
            else if ($row["grade"] == "F")
                $f2++;
        }
    }

    print("<script type=\"text/javascript\">
    window.onload = function () {
    var chart = new CanvasJS.Chart(\"chartContainer\",
    {
                animationEnabled: true,
        data: [
        {
            type: \"doughnut\",
            startAngle: 60,
            toolTipContent: \"{legendText}: {y} - <strong>#percent% </strong>\",
            showInLegend: false,
            dataPoints: [");

                if ($a1 + $bp1 + $b1 + $cp1 + $c1 + $dp1 + $d1 + $f1 == 0)
                    print("{y: 1, indexLabel: \"NO ONE ENTER YOUR COURSE\", legendText: \"hello\"}");
                else
                    print("{y: ".$a1.", indexLabel: \"A #percent%\", legendText: \"A\" },
                    {y: ".$bp1.", indexLabel: \"B+ #percent%\", legendText: \"B+\" },
                    {y: ".$b1.", indexLabel: \"B #percent%\", legendText: \"B\" },
                    {y: ".$cp1.", indexLabel: \"C+ #percent%\", legendText: \"C+\" },
                    {y: ".$c1.", indexLabel: \"C #percent%\", legendText: \"C\" },
                    {y: ".$dp1.", indexLabel: \"D+ #percent%\", legendText: \"D+\" },
                    {y: ".$d1.", indexLabel: \"D #percent%\", legendText: \"D\" },
                    {y: ".$f1.", indexLabel: \"F #percent%\", legendText: \"F\" }");
                print("
                
            ]
        }
        ]
    });
  	chart.render();

    var chart2 = new CanvasJS.Chart(\"chartContainer2\",
 {
               animationEnabled: true,
   data: [
   {
     type: \"doughnut\",
     startAngle: 60,
     toolTipContent: \"{legendText}: {y} - <strong>#percent% </strong>\",
     showInLegend: false,
     dataPoints: [");

         if ($a2 + $bp2 + $b2 + $cp2 + $c2 + $dp2 + $d2 + $f2 == 0)
            print("{y: 1, indexLabel: \"NO ONE ENTER YOUR COURSE\", legendText: \"hello\"}");
        else
            print("{y: ".$a2.", indexLabel: \"A #percent%\", legendText: \"A\" },
            {y: ".$bp2.", indexLabel: \"B+ #percent%\", legendText: \"B+\" },
            {y: ".$b2.", indexLabel: \"B #percent%\", legendText: \"B\" },
            {y: ".$cp2.", indexLabel: \"C+ #percent%\", legendText: \"C+\" },
            {y: ".$c2.", indexLabel: \"C #percent%\", legendText: \"C\" },
            {y: ".$dp2.", indexLabel: \"D+ #percent%\", legendText: \"D+\" },
            {y: ".$d2.", indexLabel: \"D #percent%\", legendText: \"D\" },
            {y: ".$f2.", indexLabel: \"F #percent%\", legendText: \"F\" }");
        print("

     ]
   }
   ]
 });
 chart2.render();
 }
   </script>");
   ?>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <?php printf("<a href=\"index.php?login=%s\" class=\"site_title\"><i class=\"glyphicon glyphicon-cog\"></i> <span>CPstudent CARE</span></a>", $_GET["login"]); ?>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <?php
                                printf("<img src=\"images/%s.jpg\" alt=\"...\" class=\"img-circle profile_img\">", TEACHER_IMAGE);
                            ?>
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>
                                <?php
                                    printf("%s %s", TEACHER_FIRSTNAME, TEACHER_LASTNAME);
                                ?>
                            </h2>
                            <!--<h2>Prof.Proadpran Punyabukkana</h2>-->
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">

                                <li>
                                    <?php
                                        printf("<a href=\"index.php?login=%s\"><i class=\"fa fa-bar-chart\"></i>HOME</a>", $_GET["login"]);
                                    ?>
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                                <li>
                                    <?php
                                        printf("<a href=\"allstudent.php?login=%s\"><i class=\"fa fa-user\"></i>STUDENTS</a>", $_GET["login"]);
                                    ?>
                                </li>
                                <li><a><i class="fa fa-pencil"></i>COURSES<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <?php
                                            $q = sprintf("SELECT DISTINCT S.subjectID, S.subjectName, T.sectionNo FROM teach T, subject S WHERE T.teacherID = %s and T.subjectID = S.subjectID", TEACHER_ID);
                                            $result = $mysqli->query($q);
                                            while ($row = $result->fetch_assoc()) {
                                                printf("<li><a href=\"subject.php?login=%s&subjectID=%s&subjectName=%s&sectionNo=%s\">%s %s (SEC %s)</a></li>", $_GET["login"], $row["subjectID"], $row["subjectName"], $row["sectionNo"], $row["subjectID"], $row["subjectName"], $row["sectionNo"]);
                                            }
                                        ?>
                                        <!--<li><a href="#">2301710 DATABASE</a></li>
                                        <li><a href="#">2110513 ASSISTIVE TECHNOLOGY</a></li>-->
                                    </ul>
                                </li>

                                <li>
                                    <?php
                                        printf("<a href=\"alert.php?login=%s\"><i class=\"fa fa-frown-o\"></i>ALERT</a>", $_GET["login"]);
                                    ?>
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
                                    <?php
                                        printf("<img src=\"images/%s.jpg\" alt=\"\">", TEACHER_IMAGE);
                                        printf("%s %s", TEACHER_FIRSTNAME, TEACHER_LASTNAME);
                                        // Prof.Proadpran Punyabukkana
                                    ?>
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
                    <h1>
                        <?php
                            printf("&nbsp;%s %s &nbsp;(SEC %s)", $_GET["subjectID"], $_GET["subjectName"], $_GET["sectionNo"]);
                        ?>
                    </h1>
                    <!--<h1>&nbsp;2301710 DATABASE &nbsp;(SEC33)</h1>-->
                    <div class="col-md-2 col-sm-12 col-xs-12" style="margin: 5px 0px 0px 20px">
                        <a class="btn btn-info"></i>Download syllabus</a>
                    </div>

                    <!-- pie chart -->
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0px 0px 0px ">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                        <?php
                                            printf("GPA Year %s Semester %s", (date("Y") - ((date("m") <= 7) ? 1 : 0)) - ($teachYear / 2), ((date("m") > 7) ? 1 : 2) - ($teachYear % 2));
                                        ?>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                        <?php
                                            printf("GPA Year %s Semester %s", (date("Y") - ((date("m") <= 7) ? 1 : 0)) - $teachYear, ((date("m") > 7) ? 1 : 2) - ((2 * $teachYear) % 2));
                                        ?>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-10 col-md-offset-1" style="margin-top: 20px">
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">

                                        <th class="column-title">Profile image</th>
                                        <th class="column-title">Student ID</th>
                                        <th class="column-title">First name</th>
                                        <th class="column-title">Last name</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $q = sprintf("SELECT S.image, S.studentID, S.firstName, S.lastName, A.semester, A.sectionNO FROM student S, adddrop A, subject SU WHERE A.subjectID = %s and A.sectionNO = %s and SU.subjectID = A.subjectID and A.studentID = S.studentID", $_GET["subjectID"], $_GET["sectionNo"]);
                                    $result = $mysqli->query($q);
                                    $total = mysqli_num_rows($result);
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        list($year, $semester) = explode("/", $row["semester"]);
                                        if (($year == (date("Y") - ((date("m") <= 7) ? 1 : 0)))
                                            && ($semester == ((date("m") > 7) ? 1 : 2))) {
                                            if ($count%2 == 0) {
                                                printf("<tr class=\"even pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
                                                printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                printf("<td >%s</td>
                                                    <td >%s</td>
                                                    <td >%s</td>
                                                    </td>",$row["studentID"],$row["semester"],$row["sectionNO"]);
                                                echo"</tr>";
                                            }
                                            else {
                                                printf("<tr class=\"even pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
                                                printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                printf("<td >%s</td>
                                                    <td >%s</td>
                                                    <td >%s</td>
                                                    </td>",$row["studentID"],$row["semester"],$row["sectionNO"]);
                                                echo"</tr>";
                                            }
                                            $count++;
                                        }
                                    }
                                    if ($count == 1)
                                        printf("<td><td>NO STUDENT HAS STUDY YOUR CLASS<td><td></td></td></td></td>");
                                    ?>
                                </tbody>
                            </table>
                        </div>
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

</body>

</html>
