
<nav class="navbar navbar-expand-sm navbar-light changeColor">
  <div class="container-fluid">
    <a class="navbar-brand navbar-title" href="../home/home.php">ourDeal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../home/home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../search/search.php">Shopping</a>
        </li>

        <?php if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]):  ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Hi, <?php echo $_SESSION["username"];?>!
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="../login/profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="../sell/sell-form.php">Sell My Goods</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../login/logout.php">Log Out</a></li>
          </ul>
        </li>

        <?php else: ?>

        <li class="nav-item">
          <a class="nav-link" href="../login/login.php">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../register/register-form.php">Sign Up</a>
        </li>

        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>