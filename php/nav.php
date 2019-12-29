<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><h1 class="nav">applyist</h1></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto "></ul>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle small-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="img/<?=$user['profile_img']?>" class="profile"> <span style="font-weight: 600"><?=ucwords($user['username'])?></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 5px">
                        <a class="dropdown-item" href="profile.php">Update Profile</a>
                        <div class="dropdown-divider"></div>
                        <form action="php/logout.php" method="post">
                            <button class="btn-block btn btn-danger">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
