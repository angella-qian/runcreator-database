<?php

	define('DB_HOST', '300.itpwebdev.com');
	define('DB_USER', 'aqian_db_user');
	define('DB_PASS', 'uscitp2018');
	define('DB_NAME', 'aqian_routes_db');

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql = "SELECT *
					FROM route
					LEFT JOIN surface
						ON surface.surface_id = route.surface_id
					LEFT JOIN skill_level
						ON skill_level.skill_level_id = route.skill_level_id
					LEFT JOIN city
						ON city.city_id = route.city_id
					WHERE 1 = 1";

	if ( isset($_GET['surface_id']) && !empty($_GET['surface_id']) ) {
		$surface_id = $_GET['surface_id'];
		$sql = $sql . " AND surface.surface_id = $surface_id";
	}

	if ( isset( $_GET['skill_id'] ) && !empty( $_GET['skill_id'] ) ) {
		$skill_id = $_GET['skill_id'];
		$sql = $sql . " AND skill_level.skill_level_id = $skill_id";
	}

	if ( isset( $_GET['city_id'] ) && !empty( $_GET['city_id'] ) ) {
		$city_id = $_GET['city_id'];
		$sql = $sql . " AND city.city_id = $city_id";
	}

	$sql = $sql . " LIMIT 0, 10";

	$sql = $sql . ";";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$results_encoded = json_encode( $results->fetch_all(MYSQLI_ASSOC) );

	echo $results_encoded;

	$mysqli->close();


?>