<?php

    require "config.php";

    if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
        header('Location: login.php');
    }

    // Establish MySQL Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check for any Connection Errors.
    if ( $mysqli->connect_errno ) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');


    // Grabbing user_id from username
    $username = $_SESSION['username'];
    $sql_user = "SELECT *
                FROM users
                WHERE username = '$username';";

    $results_user = $mysqli->query($sql_user);
    if ( !$results_user ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $row_user = $results_user->fetch_assoc();
    $user_id = $row_user['id'];


    // Retrieve all routes from the DB
    $sql = "SELECT route_name, skill_level, city, comments, rating, reviewedOn, route.id AS route_id, reviews.id AS reviews_id
            FROM reviews
            LEFT JOIN route
                ON route.id = reviews.routeID
            LEFT JOIN users
                ON reviews.userID = users.id
            LEFT JOIN skill_level
                ON route.skill_level_id = skill_level.skill_level_id
            LEFT JOIN city
                ON route.city_id = city.city_id
            WHERE comments IS NOT NULL
            AND rating IS NOT NULL
            AND userID = $user_id;";

     $results = $mysqli->query($sql);

    if ( !$results ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $results_per_page = 10;
    $num_records = $results->num_rows;
    $first_page = 1;
    $last_page = ceil($num_records / $results_per_page);

    if (!$num_records == 0) {

        if ( isset($_GET['page']) && !empty($_GET['page']) ) {
            $current_page = $_GET['page'];
        } else {
            $current_page = $first_page;
        }

        if ( $current_page < $first_page ) {
            $current_page = $first_page;
        } elseif ( $current_page > $last_page ) {
            $current_page = $last_page;
        }

        $start_index = ($current_page - 1) * $results_per_page;


        // Remove semi-colon ";" from the SQL statement.
        // str_replace('find', 'replace', 'string');
        $sql = str_replace(';', '', $sql);

        $sql = $sql . " LIMIT $start_index, $results_per_page;";

        $results = $mysqli->query($sql);

        if ( !$results ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }
    }

    // Close MySQL Connection
    $mysqli->close();

?>

<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | My Reviews </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <!-- Bootstrapious Sidebar Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <link href="https://drive.google.com/uc?id=1VKcKNMoTGj6Jn2SPysUxtsNzj5Ou4xH2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    <style>
        .btn {
            font-size: 1em;
        }

    </style>

</head>
<body>

<div class="wrapper">

    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="https://drive.google.com/uc?id=1ugPAZevKbXsINqOvfl8NstvLuPn1_GzQ" alt="App Icon">
            <h3>RunCreator</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="home.php"><img height="13" src="https://drive.google.com/uc?id=1nKpqosFZhjiGslSR52fAb9nhvN3znirH" alt="Search Routes">Search Routes</a>
            </li>
            <!-- <li>
                <a href="#"><img height="16" src="img/new-review-unselected.png" alt="New Review">New Review</a>
            </li> -->
            <li>
                <a href="add_route.php"><img height="16" src="https://drive.google.com/uc?id=1zLPCAlvGj3r4i56mns61rO5fjvUofZko" alt="New Route">New Route</a>
            </li>
            <li class="active selected">
                <a href="myreviews.php"><img height="14" src="https://drive.google.com/uc?id=13dQxdOjextqyfV6AEqaMal_dTNYqx2bH" alt="My Reviews">My Reviews</a>
            </li>

             
                    
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        </ul>
    </nav>

     <div id="content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>

        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="navbar-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div>
            <h2>My Reviews</h2>
        </div>

        <div id="DataTables_Table_0_wrapper" class="form-inline">
            <div class="showing-entries">
                    Showing
                <?php echo ($start_index + 1); ?>
                to
                <?php echo ($start_index + $results->num_rows); ?>
                out of 
                <?php echo $num_records; ?>
                result(s).
            </div>
            <table class="table table-hover" id="DataTables_Table_0" role="grid">
                <thead>
                    <tr role="row">
                        <th class="text-center" rowspan="1" colspan="1">
                            Route Name
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Skill Level
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            City
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Rating
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Reviewed On
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Manage Review
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php while ( $row = $results->fetch_assoc() ): ?>
                        <tr>
                            <td><?php echo $row['route_name']; ?></td>
                            <td><?php echo $row['skill_level']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <td><?php echo $row['reviewedOn']; ?></td>
                            <td><a href="edit_form.php?rev_id=<?php echo $row['reviews_id']; ?>&route_id=<?php echo $row['route_id']; ?>" class="btn btn-outline-warning">
                                        Edit
                                    </a>
                                <a href="delete.php?route_id=<?php echo $row['id']; ?>&rev_id=<?php echo $row['reviews_id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete your review on \'<?php echo $row['route_name']; ?>\'?');">
                                        Delete
                                    </a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div>
                <ul class="pagination">

                    <li class="page-item">
                        <a class="page-link" href="<?php

                            $_GET['page'] = $current_page - 1;

                            echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

                        ?>">&lt;</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href=""><?php echo $current_page; ?></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?php

                            $_GET['page'] = $current_page + 1;

                            echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

                        ?>">></a>
                    </li>
                </ul>
            </div>
        </div>
 </div> <!-- .content -->

    <!-- Footer -->
    <div class="footer">
        <div class="text-center">
            <strong>Copyright RunCreator © 2018</strong>
        </div>
    </div>

</div> <!-- .wrapper -->


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
</body>
</html>