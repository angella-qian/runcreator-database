<?php

    session_start();

    if ( !isset($_GET['id']) || empty($_GET['id']) ) {
    	$error = "Invalid Route ID.";
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

    	$route_id = $_GET['id'];


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


        // Grab access levels info
        $sql_access = "SELECT accessLevelID
                        FROM users
                        WHERE id = $user_id;";

        $results_access = $mysqli->query($sql_access);
        if ( !$results_access ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $row_access = $results_access->fetch_assoc();


        // Grab route info
    	$sql = "SELECT route_name, distance, elevation_gain, skill_level, city, surface, id
    					FROM route
    					LEFT JOIN skill_level
    						ON route.skill_level_id = skill_level.skill_level_id
    					LEFT JOIN city
    						ON route.city_id = city.city_id
                        LEFT JOIN surface
                            ON route.surface_id = surface.surface_id
    					WHERE id = $route_id;";

    	$results = $mysqli->query($sql);
    	if ( !$results ) {
    		echo $mysqli->error;
    		$mysqli->close();
    		exit();
    	}

    	$row = $results->fetch_assoc();


        // Grab reviews info
        $sql_reviews = "SELECT username, comments, rating, reviewedOn, reviews.id as rev_id
                        FROM reviews
                        LEFT JOIN users
                        ON reviews.userID = users.id
                        WHERE routeID = $route_id;";

        $results_reviews = $mysqli->query($sql_reviews);
        if ( !$results_reviews ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

    	$mysqli->close();
    }

?>

<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | Route Details </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <!-- Bootstrapious Sidebar Custom CSS + External CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <link href="https://drive.google.com/uc?id=1VKcKNMoTGj6Jn2SPysUxtsNzj5Ou4xH2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  

    <style>
        .header {
            margin-top: 10px;
            padding-left: 0px;
        }
        .review-button {
            margin: 0% 0% 1% 73%;
        }
        .btn {
            font-size: 1em;
        }
    </style>
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
        </ul>
    </nav>

     <div id="content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <br/><br/>

        <div id="DataTables_Table_0_wrapper" class="form-inline">

            <h2 class="header"><?php echo $row['route_name']; ?></h2>

            <table class="table table-hover" id="DataTables_Table_0" role="grid">
                <thead>
                    <tr role="row">
                        <th class="text-center">
                            Skill Level
                        </th>
                        <th class="text-center">
                            Distance (mi)
                        </th>
                        <th class="text-center">
                            Elevation Gain (ft)
                        </th>
                        <th class="text-center">
                            Surface
                        </th>

                        <th class="text-center">
                            City
                        </th>
                        
                    </tr>
                </thead>
                <tbody class="text-center">
                    
                    <tr role="row">
                        <td><?php echo $row['skill_level']; ?></td>
                        <td><?php echo $row['distance']; ?></td>
                        <td><?php echo $row['elevation_gain']; ?></td>
                        <td><?php echo $row['surface']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                    </tr>

                </tbody>
            </table>

        </div>

        <h2>Route Reviews</h2>

        <div id="DataTables_Table_0_wrapper" class="form-inline">

            <span>This route has <?php echo $results_reviews->num_rows; ?> reviews.</span>
            <div class="review-button">
                <a href="add_review.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Review this route</a>
            </div>

            <div id=reviews">

                <?php while ($row_reviews = $results_reviews->fetch_assoc()) : ?>

                    <div class="rev">
                        <h3><?php echo $row_reviews['username']; ?></h3>
                        <div><?php echo $row_reviews['comments']; ?></div>
                        <div><i>Rating:</i> &nbsp;&nbsp;&nbsp; <?php echo $row_reviews['rating']; ?></div>
                        <div><i>Posted:</i> &nbsp;&nbsp;&nbsp; <?php echo $row_reviews['reviewedOn']; ?></div>

                        <?php $rev_id = $row_reviews['rev_id']; ?>

                        <!-- Allows admin to edit/delete -->
                        <?php if ( $row_access['accessLevelID'] == 2 ) : ?>
                        <div>
                            <br/><a href="edit_form.php?rev_id=<?php echo $rev_id; ?>&route_id=<?php echo $route_id; ?>" class="btn btn-outline-warning">
                                        Edit
                                    </a>
                            &nbsp;<a href="delete.php?rev_id=<?php echo $rev_id; ?>&route_id=<?php echo $route_id; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this review on \'<?php echo $row['route_name']; ?>\'?');">
                                        Delete
                             </a>
                         </div>
                        <?php endif ?>

                    </div>

                <?php endwhile; ?>

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

</body>
</html>