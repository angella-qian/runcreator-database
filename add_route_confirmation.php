<?php
    session_start();

    // Check for required data.
    if ( !isset($_POST['route_name']) || empty($_POST['route_name'])
     || !isset($_POST['skill_level']) || empty($_POST['skill_level'])
     || !isset($_POST['distance']) || empty($_POST['distance'])
     || !isset($_POST['elevation_gain']) || empty($_POST['elevation_gain'])
     || !isset($_POST['surface']) || empty($_POST['surface'])
     || !isset($_POST['city']) || empty($_POST['city'])
    ) {
        $error = "Please fill out all required fields.";

    } else {

        $host = "300.itpwebdev.com";
        $user = "aqian_db_user";
        $pass = "uscitp2018";
        $db = "aqian_routes_db";

        // DB Connection.
        $mysqli = new mysqli($host, $user, $pass, $db);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $route_name = $_POST['route_name'];
        $skill_level = $_POST['skill_level'];
        $distance = $_POST['distance'];
        $elevation_gain = $_POST['elevation_gain'];
        $surface = $_POST['surface'];
        $city = $_POST['city'];

        $sql = "INSERT INTO route (skill_level_id, route_name, distance, elevation_gain, surface_id, city_id)
                VALUES ($skill_level, '$route_name', $distance, $elevation_gain, $surface, $city);";

        $results = $mysqli->query($sql);

        if ( !$results ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        // Close MySQL Connection
        $mysqli->close();

    }

?>
<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | Confirmation </title>

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
            width: 500px;
            background-color: #FFF;
            border: 1px solid #D0D3D4;
        }

        button {
            padding: 10px 20px;
            margin: 3px;
            border-radius: 5px;
            font-size: 1.05em;
        }

        #rating-id, #comments-id {
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
            <li>
                <a href="add_route.php"><img height="16" src="https://drive.google.com/uc?id=1zLPCAlvGj3r4i56mns61rO5fjvUofZko" alt="New Route">New Route</a>
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
            <h2>Add Route Confirmation Status</h2>
        </div>
        
        <div id="DataTables_Table_0_wrapper">
            <?php if ( isset($error) && !empty($error) ) : ?>

            <div class="text-danger">
                <?php echo $error; ?>
            </div>

            <?php else : ?>

                <div class="text-success">
                    <span class="font-italic"><?php echo $_POST['route_name']; ?> was successfully added.</span>
                </div>

                <div>
                    To see your route and/or others, click <a href="home.php">here</a>
                </div>

            <?php endif; ?>
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