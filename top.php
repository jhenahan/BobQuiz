<?php
session_start();
require_once 'connect.php';
if ( getenv( 'REMOTE_USER' ) )
{
    $username = getenv( 'REMOTE_USER' );
}
else
{
    $username = 'Anonymous';
}

$_SESSION[ 'name' ] = checkName( $db, $username );
$name = $_SESSION[ 'name' ];

$adding = '';
$editing = '';
$location = basename( $_SERVER[ 'PHP_SELF' ] );

if ( $location == "add.php" )
{
    $adding = ' class="active"';
}
elseif ( $location == "edit.php" )
{
    $editing = ' class="active"';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>BobQuiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>


<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home.php">BobQuiz</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li <?php echo $adding ?>><a href="add.php">Add Question</a></li>
            <li <?php echo $editing ?>><a href="edit.php">Edit Question</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle"
                   data-toggle="dropdown"><?php echo $name ?> <b
                        class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

