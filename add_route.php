<?php

    require "config.php";
    
    if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
        header('Location: login.php');
    }

    // Establish MySQL Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ( $mysqli->connect_errno ) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');

    // Retrieve all Skill Levels from DB
    $sql_skill_level = "SELECT * FROM skill_level;";
    $results_skill_level = $mysqli->query( $sql_skill_level );
    // Check for SQL Errors.
    if ( !$results_skill_level ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    // Retrieve all Surface types from DB
    $sql_surface = "SELECT * FROM surface;";
    $results_surface = $mysqli->query( $sql_surface );
    // Check for SQL Errors.
    if ( !$results_surface ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    // Retrieve all Cities from DB
    $sql_city = "SELECT * FROM city;";
    $results_city = $mysqli->query( $sql_city );
    // Check for SQL Errors.
    if ( !$results_city ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $mysqli->close();

?>
<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | New Route </title>

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

        select {
            height: 30px;
            width: 580px;
            background-color: #FFF;
            border: 1px solid #D0D3D4;
        }

        button {
            padding: 10px 20px;
            margin: 3px;
            border-radius: 5px;
            font-size: 1.05em;
        }

        #title-id, #distance-id, #elevation-gain-id, #city-id {
            padding: 8px 5px;
            border-radius: 5px;
            border: 1px solid #D0D3D4;
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
            <li class="active selected">
                <a href="add_route.php"><img height="16" src="https://drive.google.com/uc?id=1ibXHEH7fH-ExEPWuIPul43gq0kSyEJRA" alt="New Route">New Route</a>
            </li>
            <li>
                <a href="myreviews.php"><img height="14" src="https://drive.google.com/uc?id=129B9z_hYKs_5zDGAQDffYLHDWw_vKWC0" alt="My Reviews">My Reviews</a>
            </li>

                    
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        </ul>
    </nav>

     <div id="content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div><br/><br/>
        <div>
            <h2>Add New Route</h2>
        </div>

        <div id="DataTables_Table_0_wrapper">
            <form action="add_route_confirmation.php" method="POST">
                <div class="form-question">
                    <label for="title-id">Route Name:</label><br/>
                    <input type="text" id="route-id" name="route_name" placeholder="Enter route name" size="80">
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="skill-level-id">Skill Level:</label><br/>
                    <select name="skill_level" id="skill-level-id">
                        <option value="" selected>-- All --</option>

                        <?php while ( $row_skill = $results_skill_level->fetch_assoc() ) : ?>

                        <option value="<?php echo $row_skill['skill_level_id']; ?>"><?php echo $row_skill['skill_level']; ?></option>

                        <?php endwhile; ?>
                    </select>
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="distance-id">Distance (mi):</label><br/>
                    <input type="text" id="distance-id" name="distance" placeholder="Enter route distance" size="80">
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="elevation-gain-id">Elevation Gain (ft):</label><br/>
                    <input type="text" id="elevation-gain-id" name="elevation_gain" placeholder="Enter elevation gain" size="80">
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="surface-id">Surface:</label><br/>
                    <select name="surface" id="surface-id">
                        <option value="" selected>-- All --</option>
                        <?php while ( $row_surface = $results_surface->fetch_assoc() ) : ?>

                        <option value="<?php echo $row_surface['surface_id']; ?>"><?php echo $row_surface['surface']; ?></option>

                        <?php endwhile; ?>
                    </select>
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="city-id">City:</label><br/>
                    <select name="city" id="city-id">
                        <option value="" selected>-- All --</option>
                        <?php while ( $row_city = $results_city->fetch_assoc() ) : ?>

                        <option value="<?php echo $row_city['city_id']; ?>"><?php echo $row_city['city']; ?></option>

                        <?php endwhile; ?>
                    </select>
                </div> <!-- .form-question -->


                <div class="form-question">
                    <button type="submit" class="submit">Add Route</button>
                    <button type="reset" class="reset">Reset</button>
                </div> <!-- .form-question -->

            </form>
        </div>

    </div> <!-- .content -->

    <!-- Footer -->
    <div class="footer">
        <div class="text-center">
            <strong>Copyright RunCreator © 2018</strong>
        </div>
    </div>

</div> <!-- .wrapper -->

</body>
</html>