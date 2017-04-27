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
    if ($_GET["login"] == null)
        echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\" />";

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
    $q = "SELECT sex, entyear FROM student";
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);

    $m1 = 0;
    $f1 = 0;
    $m2 = 0;
    $f2 = 0;
    $m3 = 0;
    $f3 = 0;
    $m4 = 0;
    $f4 = 0;

    while ($row = $result->fetch_assoc()) {
        $year = (date("Y") - $row["entyear"]) + ((date("m") > 7) ? 1 : 0);
        if (strcasecmp($row["sex"], "male") == 0) {
            if ($year == 1)
                $m1++;
            else if ($year == 2)
                $m2++;
            else if ($year == 3)
                $m3++;
            else if ($year == 4)
                $m4++;
        }
        else {
            if ($year == 1)
                $f1++;
            else if ($year == 2)
                $f2++;
            else if ($year == 3)
                $f3++;
            else if ($year == 4)
                $f4++;
        }
    }

    $q = "SELECT S.entyear, A.grade, SU.credits FROM student S, adddrop A, subject SU WHERE S.studentID = A.studentID and A.subjectID = SU.subjectID";
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);

    $gpax1 = 0;
    $gpax2 = 0;
    $gpax3 = 0;
    $gpax4 = 0;
    $credits1 = 0;
    $credits2 = 0;
    $credits3 = 0;
    $credits4 = 0;

    while ($row = $result->fetch_assoc()) {
        $grade = -1;
        if ($row["grade"] == "A")
            $grade = 4;
        else if ($row["grade"] == "B+")
            $grade = 3.5;
        else if ($row["grade"] == "B")
            $grade = 3;
        else if ($row["grade"] == "C+")
            $grade = 2.5;
        else if ($row["grade"] == "C")
            $grade = 2;
        else if ($row["grade"] == "D+")
            $grade = 1.5;
        else if ($row["grade"] == "D")
            $grade = 1;
        else if ($row["grade"] == "F")
            $grade = 0;

        if ($grade != -1) {
            $year = (date("Y") - $row["entyear"]) + ((date("m") > 7) ? 1 : 0);
            if ($year == 1) {
                $gpax1 += $grade * $row["credits"];
                $credits1 += $row["credits"];
            }
            else if ($year == 2) {
                $gpax2 += $grade * $row["credits"];
                $credits2 += $row["credits"];
            }
            else if ($year == 3) {
                $gpax3 += $grade * $row["credits"];
                $credits3 += $row["credits"];
            }
            else if ($year == 4) {
                $gpax4 += $grade * $row["credits"];
                $credits4 += $row["credits"];
            }
        }
    }
    if ($credits1 != 0)
        $gpax1 /= $credits1;
    if ($credits2 != 0)
        $gpax2 /= $credits2;
    if ($credits3 != 0)
        $gpax3 /= $credits3;
    if ($credits4 != 0)
        $gpax4 /= $credits4;

    $q = "SELECT S.entyear, count(P.award) as award FROM student S, participatec P WHERE S.studentID = P.studentID GROUP BY S.entyear";
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);

    $award1 = 0;
    $award2 = 0;
    $award3 = 0;
    $award4 = 0;

    while ($row = $result->fetch_assoc()) {
        $year = (date("Y") - $row["entyear"]) + ((date("m") > 7) ? 1 : 0);
        if ($year == 1)
            $award1 = $row["award"];
        else if ($year == 2)
            $award2 = $row["award"];
        else if ($year == 3)
            $award3 = $row["award"];
        else if ($year == 4)
            $award4 = $row["award"];
    }

    //Year 1
    print("<script type=\"text/javascript\">
        window.onload = function () {
        var chart = new CanvasJS.Chart(\"chartContainer1\",
        {
        title:{
            text: \"Year1\"
        },
        exportFileName: \"Pie Chart\",
        exportEnabled: false,
                    animationEnabled: true,
        legend:{
            verticalAlign: \"bottom\",
            horizontalAlign: \"center\"
        },
        data: [
        {
            type: \"pie\",
            showInLegend: false,
            toolTipContent: \"{name}: <strong>{y}</strong>\",
            indexLabel: \"{name} {y}\",
            dataPoints: [");

            printf("{  y: %d, name: \"Male\", exploded: true}," , $m1);
            printf("{  y: %d, name: \"Female\"}", $f1);
            print("
            ]
        }
        ]
        });
        chart.render();

        var chart2 = new CanvasJS.Chart(\"chartContainer2\",
        {
        title:{
            text: \"Year2\"
        },
        exportFileName: \"Pie Chart\",
        exportEnabled: false,
                    animationEnabled: true,
        legend:{
            verticalAlign: \"bottom\",
            horizontalAlign: \"center\"
        },
        data: [
        {
            type: \"pie\",
            showInLegend: false,
            toolTipContent: \"{name}: <strong>{y}</strong>\",
            indexLabel: \"{name} {y}\",
            dataPoints: [");

            printf("{  y: %d, name: \"Male\", exploded: true}," , $m2);
            printf("{  y: %d, name: \"Female\"}", $f2);
            print("
            ]
        }
        ]
        });
        chart2.render();

        var chart3 = new CanvasJS.Chart(\"chartContainer3\",
        {
        title:{
            text: \"Year3\"
        },
        exportFileName: \"Pie Chart\",
        exportEnabled: false,
                    animationEnabled: true,
        legend:{
            verticalAlign: \"bottom\",
            horizontalAlign: \"center\"
        },
        data: [
        {
            type: \"pie\",
            showInLegend: false,
            toolTipContent: \"{name}: <strong>{y}</strong>\",
            indexLabel: \"{name} {y}\",
            dataPoints: [");

            printf("{  y: %d, name: \"Male\", exploded: true}," , $m3);
            printf("{  y: %d, name: \"Female\"}", $f3);
            print("
            ]
        }
        ]
        });
        chart3.render();

        var chart4 = new CanvasJS.Chart(\"chartContainer4\",
        {
        title:{
            text: \"Year4\"
        },
        exportFileName: \"Pie Chart\",
        exportEnabled: false,
                    animationEnabled: true,
        legend:{
            verticalAlign: \"bottom\",
            horizontalAlign: \"center\"
        },
        data: [
        {
            type: \"pie\",
            showInLegend: false,
            toolTipContent: \"{name}: <strong>{y}</strong>\",
            indexLabel: \"{name} {y}\",
            dataPoints: [");

            printf("{  y: %d, name: \"Male\", exploded: true}," , $m4);
            printf("{  y: %d, name: \"Female\"}", $f4);
            print("
            ]
        }
        ]
        });
        chart4.render();

    var columnchart = new CanvasJS.Chart(\"chartContainer5\",
        {
            theme: \"theme3\",
                        animationEnabled: true,
            title:{
                text: \"GPAX of each term\",
                fontSize: 30
            },
            toolTip: {
                shared: true
            },
            axisY: {
                title: \"GPAX\"
            },

            data: [
            {
                type: \"column\",
                name: \"GPAX\",
                showInLegend: true,
                dataPoints:[");

                    printf("{label: \"Year 1\", y: %.2f},", $gpax1);
                    printf("{label: \"Year 2\", y: %.2f},", $gpax2);
                    printf("{label: \"Year 3\", y: %.2f},", $gpax3);
                    printf("{label: \"Year 4\", y: %.2f},", $gpax4);
                    print("

                    // {label: \"Year1 Term1\", y: 3.24},
                    // {label: \"Year1 Term2\", y: 2.89},
                    // {label: \"Year2 Term1\", y: 3.15},
                    // {label: \"Year2 Term2\", y: 2.35},
                    // {label: \"Year3 Term1\", y: 2.79},
                    // {label: \"Year3 Term2\", y: 2.35},
                    // {label: \"Year4 Term1\", y: 3.07},
                    // {label: \"Year4 Term2\", y: 3.18},

                ]
            },


            ],
            legend:{
            cursor:\"pointer\",
            itemclick: function(e){
                if (typeof(e.dataSeries.visible) === \"undefined\" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
                }
                else {
                e.dataSeries.visible = true;
                }
                columnchart.render();
            }
            },
        });

    columnchart.render();

    var columnchart2 = new CanvasJS.Chart(\"chartContainer6\",
        {
            theme: \"theme3\",
                        animationEnabled: true,
            title:{
                text: \"Awards of each term\",
                fontSize: 30
            },
            toolTip: {
                shared: true
            },
            axisY: {
                title: \"Number of awards\"
            },

            data: [
            {
                type: \"column\",
                name: \"Number of award\",
                showInLegend: true,
                dataPoints:[");

                    printf("{label: \"Year 1\", y: %d},", $award1);
                    printf("{label: \"Year 2\", y: %d},", $award2);
                    printf("{label: \"Year 3\", y: %d},", $award3);
                    printf("{label: \"Year 4\", y: %d},", $award4);
                    print("

                // {label: \"Year1 Term1\", y: 3},
                // {label: \"Year1 Term2\", y: 2},
                // {label: \"Year2 Term1\", y: 2},
                // {label: \"Year2 Term2\", y: 4},
                // {label: \"Year3 Term1\", y: 5},
                // {label: \"Year3 Term2\", y: 4},
                // {label: \"Year4 Term1\", y: 3},
                // {label: \"Year4 Term2\", y: 6},

                ]
            },


            ],
            legend:{
            cursor:\"pointer\",
            itemclick: function(e){
                if (typeof(e.dataSeries.visible) === \"undefined\" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
                }
                else {
                e.dataSeries.visible = true;
                }
                columnchart2.render();
            }
            },
        });

    columnchart2.render();
    }
    </script>");
    ?>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <?php
                            printf("<a href=\"index.php?login=%s\" class=\"site_title\"><i class=\"glyphicon glyphicon-cog\"></i>", $_GET["login"]);
                        ?>
                            <span>CPstudent CARE</span>
                        </a>
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
                                <li>
                                    <?php
                                        printf("<a href=\"index.php?login=%s\"><i class=\"fa fa-bar-chart\"></i>HOME</a>", $_GET["login"]);
                                    ?>
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                                <?php
                                    printf("<li><a href=\"allstudent.php?login=%s\"><i class=\"fa fa-user\"></i>STUDENTS</a></li>", $_GET["login"]);
                                ?>
                                <!--<li><a href="allstudent.php"><i class="fa fa-user"></i>STUDENTS</a>-->
                                <li><a><i class="fa fa-pencil"></i>COURSES<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <?php
                                            $q = sprintf("SELECT DISTINCT S.subjectID, S.subjectName, T.sectionNo FROM teach T, subject S WHERE T.teacherID = %s and T.subjectID = S.subjectID", TEACHER_ID);
                                            $result = $mysqli->query($q);
                                            while ($row = $result->fetch_assoc()) {
                                                printf("<li><a href=\"subject.php?login=%s&subjectID=%s&subjectName=%s&sectionNo=%s\">%s %s (SEC %s)</a></li>", $_GET["login"], $row["subjectID"], $row["subjectName"], $row["sectionNo"], $row["subjectID"], $row["subjectName"], $row["sectionNo"]);
                                            }
                                        ?>
                                        <!--<li><a href="subject.php">2301710 DATABASE</a></li>
                                        <li><a href="#">2110513 ASSISTIVE TECHNOLOGY</a></li>-->
                                    </ul>
                                </li>

                                <li>
                                    <?php printf("<a href=\"alert.php?login=%s\"><i class=\"fa fa-frown-o\"></i>ALERT</a>", $_GET["login"]); ?>
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
                                            $total = mysqli_num_rows($result);
                                            $count = 1;
                                            while($row = $result->fetch_assoc()) {
                                                $timediff = (strtotime(date("Y-m-d")) - strtotime($row["date"])) / (60 * 60 * 24);
                                                if ($timediff <= 7 && $timediff >= 0) {
                                                    if($count%2==0){
                                                    printf("<tr class=\"even pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
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
                                                    }
                                                    else{
                                                    printf("<tr class=\"odd pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
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
                                                    }
                                                    $count++;
                                                }
                                            }
                                            if ($count == 1)
                                                printf("<td><td><td><td>NO RECENT DEDUCTED STUDENT<td><td><td><td></td></td></td></td></td></td></td></td>");
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
                                          $count = 1;
                                          while($row = $result->fetch_assoc()) {
                                              $timediff = (strtotime(date("Y-m-d")) - strtotime($row["date"])) / (60 * 60 * 24);
                                              if ($timediff <= 7 && $timediff >= 0) {
                                                  if($count%2==0){
                                                      printf("<tr class=\"even pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
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
                                                      printf("<tr class=\"odd pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
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
                                                  $count++;
                                              }
                                          }
                                          if ($count == 1)
                                              printf("<td><td><td><td>NO RECENT ABSENTED STUDENT<td><td><td></td></td></td></td></td></td></td>");
                                          ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel tile fixed_height_330 overflow_hidden">
                            <div class="x_title">
                                <h2>Amount of Students</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="" style="width:100%">
                                    <tr>
                                        <td>
                                            <div id="chartContainer1" style="height: 200px; width: 100%;"></div>
                                        </td>
                                        <td>
                                            <div id="chartContainer2" style="height: 200px; width: 100%;"></div>
                                        </td>
                                        <td>
                                            <div id="chartContainer3" style="height: 200px; width: 100%;"></div>
                                        </td>
                                        <td>
                                            <div id="chartContainer4" style="height: 200px; width: 100%;"></div>
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
                                    <div id="chartContainer5" style="height: 300px; width: 100%;">
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
                                    <div id="chartContainer6" style="height: 300px; width: 100%;">
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
