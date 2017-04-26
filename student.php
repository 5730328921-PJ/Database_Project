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
    <link href="vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
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

    $q = sprintf("SELECT *, S.image as studentImage FROM student S, major M, teacher T WHERE S.studentID = %s and S.majorID = M.majorID and S.teacherID = T.teacherID", $_GET["studentID"]);
    $result = $mysqli->query($q);
    $count = 1;
    $total = mysqli_num_rows($result);
    while ($row = $result->fetch_assoc()) {
        DEFINE('STUDENT_IMAGE', $row["studentImage"]);
        DEFINE('STUDENT_ID', $row["studentID"]);
        DEFINE('STUDENT_FIRSTNAME', $row["firstName"]);
        DEFINE('STUDENT_LASTNAME', $row["lastName"]);
        DEFINE('STUDENT_PHONENO', $row["phoneNO"]);
        DEFINE('STUDENT_EMAIL', $row["email"]);
        DEFINE('STUDENT_ADDRESS', $row["address"]);
        DEFINE('STUDENT_DATEOFBIRTH', $row["dateOfBirth"]);
        DEFINE('STUDENT_STATUS', $row["status"]);
        DEFINE('STUDENT_ENTYEAR', $row["entyear"]);
        DEFINE('STUDENT_MAJORID', $row["majorID"]);
        DEFINE('STUDENT_MAJORNAME', $row["name"]);
        DEFINE('STUDENT_TEACHERID', $row["teacherID"]);
        DEFINE('STUDENT_UNIVERSITY', $row["university"]);
        DEFINE('STUDENT_SEX', $row["sex"]);
        DEFINE('STUDENT_ADVISETEACHER_FIRSTNAME', $row["pfname"]);
        DEFINE('STUDENT_ADVISETEACHER_LASTNAME', $row["plname"]);
        DEFINE('STUDENT_YEAR', substr(STUDENT_ID, 0, -8));
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
                                <li><a><i class="fa fa-user"></i>STUDENTS<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <?php
                                            printf("<li><a href=\"allstudent.php?login=%s\">ALL</a></li>", $_GET["login"]);
                                        ?>
                                        <li><a href="#">ADVISED</a></li>
                                    </ul>
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
                <div class="">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Student Profile</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left" style="margin: 25px 0px 0px 0px">
                                        <div class="profile_img">
                                            <div id="crop-avatar">
                                                <!-- Current avatar -->
                                                <?php
                                                    printf("<img class=\"img-responsive avatar-view\" src=\"images/%s.jpg\" alt=\"Avatar\" title=\"Change the avatar\">", STUDENT_IMAGE);
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-sm-3 col-xs-12" style="margin: 10px 0px 0px 15px">
                                        <h3>
                                            <?php
                                                printf("%s %s", STUDENT_FIRSTNAME, STUDENT_LASTNAME);
                                            ?>
                                        </h3>
                                        <!--<h3>Terapap Apiparakoon</h3>-->
                                        <ul class="list-unstyled user_data">
                                            <div class="col-md-6 col-sm-7 col-xs-12" style="margin: 10px 0px 0px 0px">
                                                <p>
                                                    <?php
                                                        printf("Status: %s<br>Sex: %s<br>Student ID: %s<br>Birthday: %s<br>", STUDENT_STATUS, STUDENT_SEX, STUDENT_ID, date("j F Y", strtotime(STUDENT_DATEOFBIRTH)));
                                                        printf("Phone No: %s<br>Email: %s<br>Address: %s<br>", STUDENT_PHONENO, STUDENT_EMAIL, STUDENT_ADDRESS);
                                                        printf("Advise Teacher: %s %s<br>", STUDENT_ADVISETEACHER_FIRSTNAME, STUDENT_ADVISETEACHER_LASTNAME);
                                                    ?>
                                                </p>
                                                <!--<p>National ID: 1101402074066<br> Sex: Male<br> Birthday: 8 August 1995<br>Country:
                                                    Thailand
                                                    <br> Email: mixtelecom8@gmail.com<br> Father name: Krit Apiparakoon
                                                    <br> Mother name: Montip Karnjanamai<br> Status: Single<br> Blood group:
                                                    B
                                                    <br>Tel: 080-080-3827<br>
                                                </p>-->
                                            </div>
                                            <div class="col-md-6 col-sm-5 col-xs-12" style="margin: 10px 0px 0px 0px">
                                                <p>
                                                    <?php
                                                        printf("University: %s<br>Faculty: %s<br>", STUDENT_UNIVERSITY, STUDENT_MAJORNAME);
                                                        printf("Entrance Year: %s<br>", STUDENT_ENTYEAR);
                                                        printf( "Year: %s<br>", (date("Y") - STUDENT_ENTYEAR) + ((date("m") > 7) ? 1 : 0));
                                                    ?>
                                                    <!--University: Chulalongkorn<br> Faculty: Engineering<br> Entrance Day: 31 June
                                                    2014
                                                    <br> Day: 31 June 2018<br> Major: Computer Engineering<br> Year: 3
                                                    <br>-->
                                                </p>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0px 0px 0px">
                                                <!--<li>
                                                    <i class="fa fa-map-marker user-profile-icon"></i> 2004 Prachasongkhro Rd, DinDang, Bangkok 10400 Thailand.
                                                </li>-->

                                                <li>
                                                    <i class="fa fa-briefcase user-profile-icon"></i> Computer Engineering
                                                </li>

                                                <!--<li class="m-top-xs">
                                                    <i class="fa fa-external-link user-profile-icon"></i>
                                                    <a href="www.terakale8.wordpress.com" target="_blank">www.terakale8.wordpress.com</a>
                                                </li>-->
                                        </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                            <strong>Warning ! </strong> Your behavioral-score was crisis because your score
                                            is under 50.<br> Please contact adviser as soon as possible.<br>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px 0px 0px 0px">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Overview</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content2" role="tab" class="profile-tab2" data-toggle="tab" aria-expanded="false">Activities</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content3" role="tab" class="profile-tab3" data-toggle="tab" aria-expanded="false">Awards</a>
                                                </li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                    <!-- start recent activity -->
                                                    <ul class="messages">
                                                        <li>
                                                            <div class="message_wrapper">
                                                                <div class="x_panel">
                                                                    <div class="x_title">
                                                                        <h2> GPA <small>( IN EACH TERM )</small></h2>
                                                                        <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 4px 0px 5px 60px">
                                                                            <button type="button" class="btn btn-success btn-sm">Status: normal</button>
                                                                        </div>
                                                                        <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 4px 0px 5px 60px">
                                                                            <button type="button" class="btn btn-info btn-sm">Year 3: Major subject was clear</button>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div id="chart_plot_02" class="demo-placeholder"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <!-- end recent activity -->

                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                                    <!-- start user projects -->
                                                    <table class="data table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Activity Name</th>
                                                                <th>Place</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $q = sprintf("SELECT A.*, P.* FROM activity A, participatea P WHERE P.studentID = %s and A.activityName = P.activityName", STUDENT_ID);
                                                                $result = $mysqli->query($q);
                                                                $count = 1;
                                                                $total = mysqli_num_rows($result);
                                                                while ($row = $result->fetch_assoc()) {
                                                                    printf("<tr>");
                                                                    printf("<td>%s</td>", $count);
                                                                    printf("<td>%s</td>", $row["activityName"]);
                                                                    printf("<td>%s</td>", $row["place"]);
                                                                    printf("<td>%s</td>", $row["date"]);
                                                                    printf("</tr>");
                                                                    $count++;
                                                                }
                                                            ?>
                                                            <!--<tr>
                                                                <td>1</td>
                                                                <td>New Company Takeover Review</td>
                                                                <td>Deveint Inc</td>
                                                                <td class="hidden-phone">18</td>
                                                                <td class="vertical-align-mid">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-success" data-transitiongoal="35"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>-->
                                                        </tbody>
                                                    </table>
                                                    <!-- end user projects -->

                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                    <table class="data table table-striped no-margin">
                                                            <thread>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Competition Name</th>
                                                                <th>Award</th>
                                                                <th>Place</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thread>
                                                        <tbody>
                                                            <?php
                                                                $q = sprintf("SELECT C.*, P.* FROM competition C, participatec P WHERE P.studentID = %s and C.competitionName = P.competitionName", STUDENT_ID);
                                                                $result = $mysqli->query($q);
                                                                $count = 1;
                                                                $total = mysqli_num_rows($result);
                                                                while ($row = $result->fetch_assoc()) {
                                                                    printf("<tr>");
                                                                    printf("<td>%s</td>", $count);
                                                                    printf("<td>%s</td>", $row["competitionName"]);
                                                                    printf("<td>%s</td>", $row["award"]);
                                                                    printf("<td>%s</td>", $row["place"]);
                                                                    printf("<td>%s</td>", $row["competitionDate"]);
                                                                    printf("</tr>");
                                                                    $count++;
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 1 Term 1</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                    <!--<a class="btn btn-primary"></i>ENG DRAW</a>
                                                    <a class="btn btn-primary"></i>CALCULUS I</a>
                                                    <a class="btn btn-primary"></i>GEN CHEM</a>
                                                    <a class="btn btn-primary"></i>GEN CHEM LAB</a>
                                                    <a class="btn btn-primary"></i>GEN PHY I</a>
                                                    <a class="btn btn-primary"></i>GEN PHY LAB I</a>
                                                    <a class="btn btn-primary"></i>EXP ENG I</a>-->
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 1 Term 2</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 2 Term 1</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 1
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 1
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 2 Term 2</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 1
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 1
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 3 Term 1</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 2
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 2
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 3 Term 2</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 2
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 2
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 4 Term 1</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 3
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 3
                                                                && $semester == 1)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 40px 0px 0px 0px">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Year 4 Term 2</h2>
                                            </div>
                                        </div>
                                        <ul class="messages">
                                            <li>
                                                <div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) != false
                                                                && $year == STUDENT_ENTYEAR + 3
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <div class="message_wrapper">
                                                        <blockquote>|</blockquote>
                                                    </div>
                                                </div><div class="col-md-5 col-sm-12 col-xs-12" style="margin: 20px 0px 0px 0px">
                                                    <?php
                                                        $q = sprintf("SELECT DISTINCT ST.studentID, SU.subjectName, A.semester, A.grade FROM student ST, adddrop A, subject SU WHERE ST.studentID = %s and A.subjectID = SU.subjectID", STUDENT_ID);;
                                                        $result = $mysqli->query($q);
                                                        $count = 1;
                                                        $total = mysqli_num_rows($result);
                                                        while ($row = $result->fetch_assoc()) {
                                                            list($year, $semester) = explode("/", $row["semester"]);
                                                            if (strpos(" A+B+C+D+", $row["grade"]) == false
                                                                && $year == STUDENT_ENTYEAR + 3
                                                                && $semester == 2)
                                                                printf("<a class=\"btn btn-primary\"></i>%s: %s</a>", $row["subjectName"], $row["grade"]);
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- /page content -->

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
