<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="./img/fav.png">
<div class="container mobile-padding">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="dashboard.php"><h1 class="nav">applyist</h1></a>
                        <div class="dropdown show">
                            <a class="nav-link dropdown-toggle small-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- <img src="img/<?=$user['profile_img']?>" class="profile"> --> <span style="font-weight: 600"><?=ucwords($user['username'])?></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="profile.php">Update Profile</a>
                                <div class="dropdown-divider"></div>
                                <form action="php/logout.php" method="post">
                                    <button class="btn-block btn btn-danger">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </nav>
</div>
