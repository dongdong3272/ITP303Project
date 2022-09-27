<?php
	$test_array = [
		"first_name" => "Tommy",
		"last_name" => "Trojan",
		"age" => 21,
		"phone" => [
			"cell" => "123-123-1234",
			"home" => "456-456-4567"
		],
	];

	
	// json_encode() is a function that will convert an array into a JSON string
	//echo json_encode($test_array);

    
	//var_dump($_GET);

    $search_term = $_GET["search_term"];
    $product_type_id = $_GET["product_type_id"];
    $price_range_id = $_GET["price_range_id"];
    $allow_bargain_id = $_GET["allow_bargain_id"];

	require '../config/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT * FROM products WHERE 1 = 1";

    // Handle search_term
    if(!empty($search_term)){
        $sql = $sql . " AND name like '%" . $search_term . "%'";
    }

    // Handle product_type_id
    if($product_type_id > 0){
        $sql = $sql . " AND type_id = " . $product_type_id;
    }

    // Handle price_range_id
    if($price_range_id == 2){
        $sql = $sql . " AND price < 50";
    }
    else if($price_range_id == 3){
        $sql = $sql . " AND price < 100";
    }
    else if($price_range_id == 4){
        $sql = $sql . " AND price < 300";
    }

    // Handle allow_bargain_id
    if($allow_bargain_id == 1){
        $sql = $sql . " AND allow_bargain = 1";
    }
    else if($allow_bargain_id == 2){
        $sql = $sql . " AND allow_bargain = 2";
    }
    // Finish the SQL statement
    $sql = $sql . ";";

	//echo $sql;

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

    $mysqli->close();

	// Create an array that will be filled with results which will be sent to the front-end 
	$results_array = [];

	while($row = $results->fetch_assoc()){
	    array_push($results_array, $row);
	}

    //var_dump($results_array)
	//Convert the results into a string and return it to the front_end
	echo json_encode($results_array);
?>