<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../stylesheet/nav.css" />
        <link rel="stylesheet" href="../stylesheet/home.css" />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <title>ourDeal</title>
    </head>
    <body>
        <?php include '../nav/nav.php'; ?>
        <header>
            <h1 class="bigTitle">Your</h1>
            <h1 class="bigTitle">Best</h1>
            <h1 class="bigTitle">Choice</h1>
            <h2 class="slogan">
                We provide students with a secure and convenient platform to
                trade their goods.
            </h2>
        </header>

        <div id="feature-table" class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 service link1">
                    <h2 class="featureTitle">
                        Find A Good Deal
                    </h2>
                    <p class="featureDescription">
                    There are 10+ categories of goods here, including food, furniture, books, kitchenware and clothing. Lower price, higher quality is our promise.
                    </p>
                </div>
                <div class="col-12 col-md-6 service link2">
                    <h2 class="featureTitle">
                        Sell My Own Good
                    </h2>
                    <p class="featureDescription">
                    Have something not used anymore? Create an account and sell your goods on our platform. More than 2000 active student user are waiting for your goods! 
                    </p>
                </div>
            </div>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"
        ></script>

        <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]): ?>
            <script>
                $('.link1').on("click", function(){
                    location.href = '../search/search.php';
                });
                $('.link2').on("click", function(){   
                    alert("Please login first to sell your products!");
                });
            </script>
        <?php else: ?>
            <script>
                $('.link1').on("click", function(){
                    location.href = '../search/search.php';
                });
                $('.link2').on("click", function(){   
                    location.href = '../sell/sell-form.php';
                });
            </script>
        <?php endif; ?>
    </body>
</html>
