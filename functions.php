<?php


function buildConnectionString( $engine = "mysql"
    , $hostname = "localhost"
    , $database = "bob" )
{
    return "{$engine}:host={$hostname};dbname=${database}";
}

function checkedConnection( $engine
    , $hostname
    , $database
    , $user
    , $password )
{
    $connection = buildConnectionString( $engine, $hostname, $database );
    $db         = new PDO( $connection, $user, $password );

    return $db;
}

function checkName (PDO $db, $username)
{
    $query = <<<COUNT
      SELECT COUNT(*) FROM User
      WHERE username = :username
COUNT;
    $count = $db->prepare($query);
    $count->bindValue(':username',$username);
    $count->execute();

    if (!$count->fetchColumn())
    {
        $add = <<<ADD
            INSERT INTO User
            SET username = :username
ADD;
        $newUser = $db->prepare($add);
        $newUser->bindValue(':username', $username);
        $newUser->execute();
    }
    return $username;
}

function getPost( $field )
{
    if ( isset( $_POST[ $field ] ) )
    {
        return htmlentities($_POST[ $field ]);
    }
    else
    {
        return "";
    }
}

function alt( $var, $fallback )
{
    if ( empty( $var ) )
    {
        echo $fallback;
    }
    else
    {
        echo $var;
    }
}

function check( $var, $num )
{
    if ( $var == $num )
    {
        echo ' checked';
    }
    else
    {
        echo '';
    }
}