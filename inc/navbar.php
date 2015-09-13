<nav class="navbar navbar-default">
<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">
            <i class="glyphicon glyphicon-home"></i>
            <strong>OSMW</strong>
        </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li <?php if ($_GET['a'] == 1) {echo 'class="active"';} ?>>
                <a href="index.php?a=1"><i class="glyphicon glyphicon-th-large"></i> <?php echo $osmw_menu_top_1;?> </a>
            </li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-hdd"></i> <?php echo $osmw_menu_top_2;?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li <?php if ($_GET['a'] == 2) {echo 'class="active"';} ?>>
                        <a href="index.php?a=2"><i class="glyphicon glyphicon-th-large"></i> <?php echo $osmw_menu_top_2a;?></a>
                    </li>
                    <li <?php if ($_GET['a'] == 3) {echo 'class="active"';} ?>>
                        <a href="index.php?a=3"><i class="glyphicon glyphicon-th"></i> <?php echo $osmw_menu_top_2b;?></a>
                    </li>
                    <li <?php if ($_GET['a'] == 4) {echo 'class="active"';} ?>>
                        <a href="index.php?a=4"><i class="glyphicon glyphicon-user"></i> <?php echo $osmw_menu_top_2c;?></a>
                    </li>
                </ul>
            </li>

            <li <?php if ($_GET['a'] == 10) {echo 'class="active"';} ?>>
                <a href="index.php?a=10"><i class="glyphicon glyphicon-download-alt"></i> <?php echo $osmw_menu_top_3;?></a>
            </li>
			
			<li <?php if ($_GET['a'] == 22) {echo 'class="active"';} ?>>
                <a href="index.php?a=22"><i class="glyphicon glyphicon-globe"></i> <?php echo $osmw_menu_top_4;?></a>
            </li>
			<li <?php if ($_GET['a'] == 21) {echo 'class="active"';} ?>>
                <a href="index.php?a=21"><i class="glyphicon glyphicon-link"></i> <?php echo $osmw_menu_top_5;?></a>
            </li>
			
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                   <i class="glyphicon glyphicon-info-sign"></i> <?php echo $osmw_menu_top_6;?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li <?php if ($_GET['a'] == 7) {echo 'class="active"';} ?>>
                        <a href="index.php?a=7"> <i class="glyphicon glyphicon-th-list"></i> <?php echo $osmw_menu_top_6a;?></a>
                    </li>
                    <li <?php if ($_GET['a'] == 13) {echo 'class="active"';} ?>>
                        <a href="index.php?a=13"><i class="glyphicon glyphicon glyphicon-book"></i> <?php echo $osmw_menu_top_6b;?></a>
                    </li>
                    <li <?php if ($_GET['a'] == 14) {echo 'class="active"';} ?>>
                        <a href="index.php?a=14"><i class="glyphicon glyphicon-info-sign"></i> <?php echo $osmw_menu_top_6c;?></a>
                    </li>
                    <li <?php if ($_GET['a'] == 9) {echo 'class="active"';} ?>>
                        <a href="index.php?a=9"><i class="glyphicon glyphicon-phone-alt"></i> <?php echo $osmw_menu_top_6d;?></a>
                    </li>
                </ul>
            </li>
			
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-user"></i> <strong><?php echo $_SESSION['login']; ?></strong> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
					 <li><a href="index.php?a=8"><i class="glyphicon glyphicon-check"></i> <?php echo $osmw_menu_top_7;?></a></li>
					 <li><a href="index.php?a=logout"><i class="glyphicon glyphicon-log-out"></i> <?php echo $osmw_menu_top_8;?></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>
