<?php

    require "config.php";

    // Establish MySQL Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check for any Connection Errors.
    if ( $mysqli->connect_errno ) {
        echo $mysqli->connect_error;
        exit();
    }

    // Retrieve all routes from the DB
    $sql = "SELECT route_name, skill_level, distance, elevation_gain, surface, city, id 
                    FROM route
                    LEFT JOIN skill_level
                        ON route.skill_level_id = skill_level.skill_level_id
                    LEFT JOIN surface
                        ON surface.surface_id = route.surface_id
                    LEFT JOIN city
                        ON city.city_id = route.city_id
                    WHERE 1 = 1;";

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

    // Close MySQL Connection
    $mysqli->close();

?>

<!DOCTYPE html>
<html lang ="en">
<head>

    <title>Run Creator | Search Routes </title>

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
            margin: 5px 0px 8px 0px;
            font-size: 0.9em;
        }


        select {
            width: 100px !important;
            margin-right: 10px;
            float: left;
        }

        label {
            width: 80px !important;
            margin-top: 8px;
            float: left;
        }

        .clearfloat {
            clear: both;
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
            <li class="active selected">
                <a href="home.php"><img height="13" src="https://drive.google.com/uc?id=1FFtKh_q_zQxzg6UzcLf6Ot7czrPR_n7Z" alt="Search Routes">Search Routes</a>
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
        
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="navbar-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div>
            <h2>Search for Routes</h2>
        </div>

         <div id="DataTables_Table_0_wrapper">

            <div id="search">
                <form id="search-form" class="text-sm-right">
                    <label for="skill-id">Skill Level:&nbsp;&nbsp;</label>
                    <select name="skill_id" id="skill-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <option value='1'>Beginner</option>
                        <option value='2'>Intermediate</option>
                        <option value='3'>Advanced</option>
                        
                    </select>

                    <label for="surface-id">Surface:&nbsp;&nbsp;</label>
                    <span>
                        <select name="surface_id" id="surface-id" class="form-control">
                            <option value="" selected>-- All --</option>

                            <option value='1'>Concrete</option>
                            <option value='2'>Dirt</option>
                            <option value='3'>Grass</option>
                            
                        </select>
                    </span>
    
                    <label for="city-id">City:&nbsp;&nbsp;</label>
                    <span>
                        <select name="city_id" id="city-id" class="form-control">
                            <option value="" selected>-- All --</option>

                            <option value='1'>Los Angeles</option>
                            <option value='2'>San Jose</option>
                            <option value='3'>San Francisco</option>
                            
                        </select>
                    </span>

                    <div class="clearfloat"></div>

                    <div class="text-sm-right">
                    
                        <button type="submit" class="btn submit">Search</button>&nbsp;&nbsp;
                        <button type="reset" class="btn reset">Reset</button>

                    </div>
 
                </form>

                <input type="hidden" name="user_id" value="<?php echo $username; ?>">
            </div>

        </div>

        
        <div id="DataTables_Table_0_wrapper" class="form-inline">

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
                            Distance (mi)
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Elevation Gain (ft)
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Surface
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            City
                        </th>
                        <th class="text-center" rowspan="1" colspan="1">
                            Details
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">

                    <?php while ( $row = $results->fetch_assoc() ): ?>
                        <tr>
                            <td><?php echo $row['route_name']; ?></td>
                            <td><?php echo $row['skill_level']; ?></td>
                            <td><?php echo $row['distance']; ?></td>
                            <td><?php echo $row['elevation_gain']; ?></td>
                            <td><?php echo $row['surface']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td class="review-button">
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                Reviews
                            </a>
                        </td> 

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


        // AJAX code
        document.querySelector('#search-form').onsubmit = function(){

            var skill_id = document.querySelector('#skill-id').value.trim();
            var surface_id = document.querySelector('#surface-id').value.trim();
            var city_id = document.querySelector('#city-id').value.trim();

            var url = 'backend.php?skill_id=' + skill_id + '&surface_id=' + surface_id + '&city_id=' + city_id;

            ajax( url, function(response){
                console.log(response);

                var data = JSON.parse(response);

                console.log(data);

                // Deletes old results.
                document.querySelector('tbody').innerHTML = '';

                for ( var i = 0; i < data.length; i++ ) {
                    var tr = document.createElement('tr');
                    var tdName = document.createElement('td');
                    var tdSkill = document.createElement('td');
                    var tdDistance = document.createElement('td');
                    var tdElevation = document.createElement('td');
                    var tdSurface = document.createElement('td');
                    var tdCity = document.createElement('td');
                    var tdReviews = document.createElement('td');

                    tdReviews.setAttribute('class', 'review-button');

                    var routeID = data[i].id;

                    // Making the reviews button link                    
                    var aReviewsLink = document.createElement('a');
                    aReviewsLink.innerHTML = 'Reviews';
                    aReviewsLink.setAttribute('class', 'btn btn-primary');
                    aReviewsLink.setAttribute('href', "details.php?id=" + routeID);

                    tdReviews.appendChild(aReviewsLink);

                    tdName.innerHTML = data[i].route_name;
                    tdSkill.innerHTML = data[i].skill_level;
                    tdDistance.innerHTML = data[i].distance;
                    tdElevation.innerHTML = data[i].elevation_gain;
                    tdSurface.innerHTML = data[i].surface;
                    tdCity.innerHTML = data[i].city;

                    tr.appendChild(tdName);
                    tr.appendChild(tdSkill);
                    tr.appendChild(tdDistance);
                    tr.appendChild(tdElevation);
                    tr.appendChild(tdSurface);
                    tr.appendChild(tdCity);
                    tr.appendChild(tdReviews);

                    document.querySelector('tbody').appendChild(tr);
                }

            } );

            return false;
        }

        function ajax(endpointUrl, callbackFunction){
            var xhr = new XMLHttpRequest();
            xhr.open('GET', endpointUrl, true);
            xhr.onreadystatechange = function(){
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        callbackFunction( xhr.responseText );
                    } else {
                        alert('AJAX Error.');
                        console.log(xhr);
                    }
                }
            }
            xhr.send();
        };

        function ajaxPost(endpointUrl, postData, callbackFunction){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', endpointUrl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function(){
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        callbackFunction( xhr.responseText );
                    } else {
                        alert('AJAX Error.');
                        console.log(xhr);
                    }
                }
            }
            xhr.send(postData);
        };

    </script>
</body>
</html>