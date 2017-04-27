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
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
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
                        <?php
                            printf("<a href=\"index.php?login=%s\" class=\"site_title\"><i class=\"glyphicon glyphicon-cog\"></i> <span>CPstudent CARE</span></a>", $_GET["login"]);
                        ?>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <?php printf("<img src=\"images/%s.jpg\" alt=\"...\" class=\"img-circle profile_img\">", TEACHER_IMAGE); ?>
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

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <?php
                                    printf("<li><a href=\"index.php?login=%s\"><i class=\"fa fa-bar-chart\"></i>HOME</a>", $_GET["login"]);
                                ?>
                                <!--<li><a href="index.php"><i class="fa fa-bar-chart"></i>HOME</a>-->
                                    <ul class="nav child_menu">
                                    </ul>
                                </li>
                                <li>
                                    <?php
                                        printf("<li><a href=\"allstudent.php?login=%s\"><i class=\"fa fa-user\"></i>STUDENTS</a>", $_GET["login"]);
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
                                        <!--<li><a href="subject.php">2301710 DATABASE</a></li>
                                        <li><a href="#">2110513 ASSISTIVE TECHNOLOGY</a></li>-->
                                    </ul>
                                </li>

                                <?php printf("<li><a href=\"alert.php?login=%s\"><i class=\"fa fa-frown-o\"></i>ALERT</a>", $_GET["login"]); ?>
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
                                    <?php printf("<img src=\"images/%s.jpg\" alt=\"\">", TEACHER_IMAGE); ?>
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
                    <div class="col-md-5  col-xs-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>All students</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form class="form-horizontal form-label-left" action="allstudent.php" method="get">
                                    <input type="hidden" name="login" value=<?php printf("\"%s\"", $_GET["login"]); ?>>

                                    <div class="form-group" style="margin-left: 260px">
                                    <label>
                                            <input type="checkbox" class="js-switch" name="adviser" /> Adviser
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">StudentID</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" placeholder="10 character" name="sid">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">First name</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" name="fname">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last name</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" name="lname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sex</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12" style="margin: 0px 0px 15px 0px">
                                            <select class="form-control" name="sex">
                                                <option value="">ALL</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="year">
                                                <option value="">ALL</option>
                                                <option value="59">CP43 (Year 1)</option>
                                                <option value="58">CP42 (Year 2)</option>
                                                <option value="57">CP41 (Year 3)</option>
                                                <option value="56">CP40 (Year 4)</option>
                                                <option value="00">Master's degree / Ph.D.</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">GPAX</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="gpax">
                                                <option value="">ALL</option>
                                                <option value="1">0.00 - 1.00</option>
                                                <option value="2">1.00 - 2.00</option>
                                                <option value="3">2.00 - 3.00</option>
                                                <option value="4">3.00 - 4.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                                            <button type="submit" class="btn btn-success">Search</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-7  col-xs-12 ">
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Profile image</th>
                                            <th class="column-title">Student ID</th>
                                            <th class="column-title">First name</th>
                                            <th class="column-title">Last name</th>
                                            <th class="column-title">GPAX</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $q="SELECT ST.studentID, A.grade, SU.credits FROM student ST, subject SU, adddrop A WHERE ST.studentID = A.studentID AND SU.subjectID = A.subjectID";
                                        $result = $mysqli->query($q);
                                        $count = 1;
                                        $total = mysqli_num_rows($result);
                                        $q2="SELECT image, studentID, firstName, lastName, teacherID, sex FROM student";
                                        $result2 = $mysqli->query($q2);
                                        $count2 = 1;
                                        $total = mysqli_num_rows($result2);
                                        while($row = $result2->fetch_assoc()) {
                                            if((strcasecmp($row["studentID"],$_GET["sid"])==0 || $_GET["sid"]=="")
                                                && (strcasecmp($row["firstName"],$_GET["fname"])==0 || $_GET["fname"]=="")
                                                && (strcasecmp($row["lastName"],$_GET["lname"])==0 || $_GET["lname"]=="")
                                                && (strcasecmp($row["sex"], $_GET["sex"]) == 0 || $_GET["sex"] == "")
                                                && (strcasecmp(substr($row["studentID"], 0, -8), $_GET["year"]) == 0 || $_GET["year"]=="")
                                                && (!$_GET["adviser"] || ($_GET["adviser"] && $row["teacherID"] == TEACHER_ID))) {
                                                $gpax = 0;
                                                $credits = 0;
                                                $result->data_seek(0);
                                                while($row2 = $result->fetch_assoc()) {
                                                    if ($row["studentID"] == $row2["studentID"]) {
                                                        $grade = -1;
                                                        if ($row2["grade"] == "A")
                                                            $grade = 4;
                                                        else if ($row2["grade"] == "B+")
                                                            $grade = 3.5;
                                                        else if ($row2["grade"] == "B")
                                                            $grade = 3;
                                                        else if ($row2["grade"] == "C+")
                                                            $grade = 2.5;
                                                        else if ($row2["grade"] == "C")
                                                            $grade = 2;
                                                        else if ($row2["grade"] == "D+")
                                                            $grade = 1.5;
                                                        else if ($row2["grade"] == "D")
                                                            $grade = 1;
                                                        else if ($row2["grade"] == "F")
                                                            $grade = 0;
                                                        if ($grade != -1) {
                                                            $gpax += $grade * $row2["credits"];
                                                            $credits += $row2["credits"];
                                                        }
                                                    }
                                                }
                                                if ($credits != 0)
                                                    $gpax /= $credits;

                                                if (($_GET["gpax"] - $gpax <= 1 && $_GET["gpax"] - $gpax >= 0) || $_GET["gpax"] == "") {
                                                    if($count%2==0){
                                                    printf("<tr class=\"even pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
                                                    printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                    printf("<td >%s</td>
                                                        <td >%s</td>
                                                        <td >%s</td>
                                                        <td >%.2f</td>
                                                        </td>",$row["studentID"],$row["firstName"],$row["lastName"],$gpax);
                                                    echo"</tr>";
                                                    }
                                                    else{
                                                    printf("<tr class=\"odd pointer\" onclick=\"window.document.location='student.php?login=%s&studentID=%s';\">", $_GET["login"], $row["studentID"]);
                                                    printf("<td ><img src=\"images/%s.jpg\" style=\"width:60px;height:60px;\"></td>",$row["image"]);
                                                    printf("<td >%s</td>
                                                            <td >%s</td>
                                                            <td >%s</td>
                                                            <td >%.2f</td>
                                                            </td>",$row["studentID"],$row["firstName"],$row["lastName"],$gpax);
                                                    echo"</tr>";
                                                    }
                                                    $count++;
                                                }
                                            }
                                        }
                                        if ($count == 1)
                                            print("<td><td><td>NOT FOUND<td><td></td></td></td></td></td>");
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
            <!-- bootstrap-progressbar -->
            <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
            <!-- iCheck -->
            <script src="vendors/iCheck/icheck.min.js"></script>
            <!-- bootstrap-daterangepicker -->
            <script src="vendors/moment/min/moment.min.js"></script>
            <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
            <!-- bootstrap-wysiwyg -->
            <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
            <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
            <script src="vendors/google-code-prettify/src/prettify.js"></script>
            <!-- jQuery Tags Input -->
            <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
            <!-- Switchery -->
            <script src="vendors/switchery/dist/switchery.min.js"></script>
            <!-- Select2 -->
            <script src="vendors/select2/dist/js/select2.full.min.js"></script>
            <!-- Parsley -->
            <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
            <!-- Autosize -->
            <script src="vendors/autosize/dist/autosize.min.js"></script>
            <!-- jQuery autocomplete -->
            <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
            <!-- starrr -->
            <script src="vendors/starrr/dist/starrr.js"></script>
            <!-- Custom Theme Scripts -->
            <script src="build/js/custom.js"></script>

</body>

</html>
