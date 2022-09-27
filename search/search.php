<?php
session_start();

// Pagamation Stuff
$page_url = preg_replace('/&page=\d*/', '', $_SERVER['REQUEST_URI']);
$results_per_page = 18;


// This page can be accessed no matter whether the user logins in
require '../config/config.php';

// DB Connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

// Product Types:
$sql_types = "SELECT * FROM types;";
$results_types = $mysqli->query($sql_types);
if ( $results_types == false ) {
	echo $mysqli->error;
	exit();
}

// At first, we get all the products
$sql_all = "SELECT * FROM products;";
$results_all = $mysqli->query($sql_all);
if ( $results_all == false ) {
    echo $mysqli->error;
    exit();
}

// Close DB Connection.
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script
            src="https://kit.fontawesome.com/f530197455.js"
            crossorigin="anonymous"
        ></script>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
        />
        <link rel="stylesheet" href="../stylesheet/nav.css" />
        <link rel="stylesheet" href="../stylesheet/search.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <title>Shopping | ourDeal</title>
        <style>
            .product-box .product-title{
                white-space: normal !important;
                overflow-wrap: break-word;
                word-wrap: break-word;
                hyphens: auto;
            }
            .product-box .product-image {
                height: 100%;
            }
            .num-Row{
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <?php include '../nav/nav.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <h1 class="col-12 mt-4 page-title">Our Store</h1>
            </div>
            <!-- .row -->

            <div class="row">
                <form action="" method="" class="col-12" id="search-form">
                    <div class="form-row">
                        <div class="col-8 mt-4 col-sm-8 col-lg-8">
                            <input
                                type="text"
                                name="search_term"
                                class="form-control input-field"
                                id="search-id"
                                placeholder="Search..."
                            />
                        </div>

                        <div class="col-3 mt-4 col-sm-2 col-lg-2">
                            <button
                                type="submit"
                                class="btn btn-primary btn-block search-btn"
                            >
                                Search
                            </button>
                        </div>
                    </div>

                    <p>
                        <a class="btn btn-primary expand-btn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Expand Options
                        </a>
                    </p>
                    <div class="collapse expand-area" id="collapseExample">
                        <div class="card card-body">

                            <!-- Info About Product Type-->
                            <div class="form-row ourRow">
                                <label for="product-type-id" class="col-sm-3 col-md-2 col-4 col-form-label text-left">
                                    Product Type: </span>
                                </label>
                                <div class="col-6">
                                    <select name="product_type" id="product-type-id" class="form-control">
                                        
                                    <option value="-1">Any</option>
                                    <?php while( $row = $results_types->fetch_assoc() ): ?>

                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['type']; ?>
                                    </option>

                                    <?php endwhile; ?>

                                    </select>
                                </div>
                            </div>

                            <!-- Info About Price-->
                            <div class="form-row ourRow">
                                <label for="price-range-id" class="col-sm-3 col-md-2 col-4 col-form-label text-left">
                                    Price Range: </span>
                                </label>
                                <div class="col-6">
                                    <select name="price_range_id" id="price-range-id" class="form-control">
                                        <option value="1">Any</option>
                                        <option value="2">Within $50</option>
                                        <option value="3">Within $100</option>
                                        <option value="4">Within $300</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Info About Bargin-->
                            <div class="form-row ourRow">
                                <label for="allow_bargain-id" class="col-sm-3 col-md-2 col-4 col-form-label text-left">
                                    Allow Bargain: </span>
                                </label>
                                <div class="col-6">
                                    <select name="allow_bargain_id" id="allow-bargain-id" class="form-control">
                                        <option value="-1">Any</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- .row -->

            <div class="row num-Row">
                <div class="col-12 mt-4 num-results">
                    Showing
                    <span id="numOfResults" class="font-weight-bold"><?php echo $results_all->num_rows; ?></span>
                    result(s).
                </div>
            </div>


            <div id="product-content">

                <?php while($row = $results_all->fetch_assoc()): ?>

                <div class="product-box">
                    <div class="product-image-box">
                        <a href="details.php?product_id=<?php echo $row["id"]?>">
                            <img
                                src="<?php echo $row["image"]?>"
                                alt="<?php echo $row["name"]?>"
                                class="product-image"
                            />
                        </a>
                    </div>
                    <div class="product-title"><strong><a href="details.php?product_id=<?php echo $row["id"]?>"><?php echo $row["name"]?></a></strong></div>
                    <div class="product-price">$<?php echo $row["price"]?></div>
                </div>

                <?php endwhile; ?>
                
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
    </body>



    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
    <script>
        $(".expand-btn").on("click", function(){
            var text = $(".expand-btn").text().trim();
            //console.log(text);
            if( text === "Expand Options"){
                //console.log("1");
                $(".expand-btn").text("Collapse Options");
            }
            else{
                //console.log("2");
                $(".expand-btn").text("Expand Options");
            }
        });
    </script>
     <script>
            // Function declaration for ajax GET requests
            function ajaxGet(endpointUrl, returnFunction) {
                var xhr = new XMLHttpRequest()
                xhr.open('GET', endpointUrl, true)
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                            // When ajax call is complete, call this function, pass a string with the response
                            returnFunction(xhr.responseText)
                        } else {
                            alert('AJAX Error.')
                            console.log(xhr.status)
                        }
                    }
                }
                xhr.send()
            }


            // ---- Form handling
            document.querySelector('form').onsubmit = function (event) {
                event.preventDefault()

                // Get the user's search term
                let searchInput = document
                    .querySelector('#search-id')
                    .value.trim();

                // Get the selected product type
                let product_id_selector = document.querySelector('#product-type-id');
                let product_id = product_id_selector.options[product_id_selector.selectedIndex].value;

                // Get the price range id
                let price_range_selector = document.querySelector('#price-range-id');
                let price_range_id = price_range_selector.options[price_range_selector.selectedIndex].value;

                // Get the allow bargain id
                let allow_bargain_selector = document.querySelector('#allow-bargain-id');
                let allow_bargain_id = allow_bargain_selector.options[allow_bargain_selector.selectedIndex].value;

                // Call the Ajax function, pass in the search input, log out results
                ajaxGet(
                    'search_backend.php?search_term=' + searchInput 
                    + "&product_type_id=" + product_id
                    + "&price_range_id=" + price_range_id
                    + "&allow_bargain_id=" + allow_bargain_id
                    ,
                    function (results) {
                        // We can get the response from backend
                        //console.log(results);

                        // convert the data into json object
                        let jsResults = JSON.parse(results);
                        console.log(jsResults);

                        document.querySelector("#numOfResults").innerHTML = jsResults.length;

                        let resultsList = document.querySelector('#product-content');

                        resultsList.replaceChildren();

                        // Run through the list of results and dynamically create a <div> tag for each of the result
                        for (let i = 0; i < jsResults.length; ++i) {

                            let row = jsResults[i];

                            // Create the <div> element
                            let htmlString = `<div class="product-box">
                                                    <div class="product-image-box">
                                                        <a href="details.php?product_id=${row["id"]}">
                                                            <img
                                                                src="${row["image"]}"
                                                                alt="${row["name"]}"
                                                                class="product-image"
                                                            />
                                                        </a>
                                                    </div>
                                                    <div class="product-title"><strong><a href="details.php?product_id=${row["id"]}">${row["name"]}</a></strong></div>
                                                    <div class="product-price">$${row["price"]}</div>
                                                </div>`;

                                                

                            // Append to the larger container
                            resultsList.innerHTML += htmlString;
                        }
                    }
                );

            }
        </script>
</html>
