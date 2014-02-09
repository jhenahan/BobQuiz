<?php
if (empty($_POST))
{
    header('Location: home.php');
    exit;
}
include 'top.php';
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$right_answer = 0;
$wrong_answer = 0;
$unanswered = 0;

var_dump($_POST);
echo $_POST[16];

$keys = array_keys( $_POST );
$order = join( ",", $keys );

$answers = <<<ANSWERS
            SELECT id, correct_answer,category
            FROM questionview
            WHERE correct_answer
            IN($order)
            ORDER BY FIELD(correct_answer, $order)
ANSWERS;

echo $answers;


$response = $db->prepare( $answers );
$response->execute();


$category = $response->fetchColumn(6);
while ( $result = $response->fetch( PDO::FETCH_ASSOC ) )
{
    print $result;
    if ( $result[ 'correct_answer' ] == $_POST[ $result[ 'id' ] ] )
    {
        $right_answer++;
    }
    else
    {
        if ( $_POST[ $result[ 'id' ] ] == 5 )
        {
            $unanswered++;
        }
        else
        {
            $wrong_answer++;
        }
    }
}

echo $right_answer;
$name = $_SESSION[ 'name' ];
$user_sql = <<<USER
        SELECT id FROM User
        WHERE username = :username
USER;
$get_user_id = $db->prepare( $user_sql );
$get_user_id->bindValue( ':username', $name );
$get_user_id->execute();
$user_id = $get_user_id->fetchColumn();

$get_score_sql = <<<GETSCORE
        SELECT COUNT(score) FROM UserCategory
        WHERE fk_user = :user_id
        AND fk_category = :category
GETSCORE;
$get_score = $db->prepare( $get_score_sql );
$get_score->bindValue( ':user_id', $user_id );
$get_score->bindValue( ':category', $category );
$get_score->execute();

if ( $get_score->fetchColumn() )
{
    $update_score_sql = <<<UPDATE
            UPDATE UserCategory
            SET score = :score
            WHERE fk_user = :user_id
            AND   fk_category = :category
UPDATE;
    $update_score     = $db->prepare( $update_score_sql );
    $update_score->bindValue( ':user_id', $user_id );
    $update_score->bindValue( ':category', $category );
    $update_score->bindValue( ':score', $right_answer );
    $update_score->execute();
}
else
{
    $insert_score_sql = <<<INSERT
            INSERT INTO UserCategory
            SET fk_user = :user_id,
                fk_category = :category,
                score = :score
INSERT;
    $insert_score     = $db->prepare( $insert_score_sql );
    $insert_score->bindValue( ':user_id', $user_id );
    $insert_score->bindValue( ':category', $category );
    $insert_score->bindValue( ':score', $right_answer );
    $insert_score->execute();
}
?>
<div class="container result">

    <div class="col-xs-6 col-sm-3 col-lg-3">
        <a href="home.php" class='btn btn-success'>Start new Quiz!!!</a>
        <a href="logout.php" class='btn btn-success'>Logout</a>

        <div style="margin-top: 30%">
            <p>Total no. of right answers : <span
                    class="answer"><?php echo $right_answer; ?></span></p>

            <p>Total no. of wrong answers : <span
                    class="answer"><?php echo $wrong_answer; ?></span></p>

            <p>Total no. of Unanswered Questions : <span
                    class="answer"><?php echo $unanswered; ?></span></p>
        </div>

    </div>

</div>
<div class="row">

</div>
</div>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

</body>
</html>

