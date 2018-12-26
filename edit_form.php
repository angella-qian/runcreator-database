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

    $route_id = $_GET['route_id'];
    $rev_id = $_GET['rev_id'];

    $sql = "SELECT comments, rating, route_name, routeID
                    FROM reviews
                    LEFT JOIN route
                    ON reviews.routeID = route.id
                    WHERE reviews.id = $rev_id;";

    $results = $mysqli->query($sql);

    if ( !$results ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $row = $results->fetch_assoc();

    $mysqli->close();

?>
<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | Edit Review </title>

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

            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        </ul>
    </nav>

     <div id="content">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <br/><br/>
        <div>
            <h2>Edit Review for <?php echo $row['route_name']; ?></h2>
        </div>

        <div id="DataTables_Table_0_wrapper">

            <form action="edit_confirmation.php" method="POST">

                <input type="hidden" name="route_id" value="<?php echo $row['routeID']; ?>">

                <input type="hidden" name="rev_id" value="<?php echo $rev_id; ?>">

                <div class="form-question">
                    <label for="comments-id">Comments on route: </label><br/>
                    <textarea id="comments-id" name="comments" rows="4" cols="146"><?php echo $row['comments']; ?></textarea>
                </div> <!-- .form-question -->

                <div class="form-question">
                    <label for="rating-id">Rating (out of 10):</label><br/>
                    <select name="rating" id="rating-id">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php for ( $i = 1; $i <= 10; $i++ ) : ?>

                            <?php if ( $i == $row['rating'] ) : ?>

                                <option value="<?php echo $i; ?>" selected>
                                    <?php echo $i; ?>
                                </option>

                            <?php else : ?>

                                <option value="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </option>

                            <?php endif; ?>

                        <?php endfor; ?>

                    </select>
                </div> <!-- .form-question -->

                <div class="form-question">
                    <button type="submit" class="submit">Update</button>
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