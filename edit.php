<?php
require_once 'connect.php';

$get_questions_sql = <<<SQL
  SELECT id, question, answer1,
         answer2, answer3, answer4,
         correct_answer, category
  FROM questionview
SQL;

if ( isset( $_GET[ 'del' ] ) )
{
    $delete              = $_GET[ 'del' ];
    $delete_question_sql = <<<DELETE
        DELETE FROM Question
        WHERE id = :id
DELETE;
    $delete_question     = $db->prepare( $delete_question_sql );
    $delete_question->bindValue( ':id', $delete );
    $delete_question->execute();
    header( 'Location: edit.php' );
    exit;
}
include 'top.php';


$get_questions = $db->prepare( $get_questions_sql );
$get_questions->execute();

?>

<div class="container">
    <div class="row">
        <div class="col-xs-10 col-sm-5 col-lg-5">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer 1</th>
                    <th>Answer 2</th>
                    <th>Answer 3</th>
                    <th>Answer 4</th>
                    <th>Correct Answer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ( $row = $get_questions->fetch( PDO::FETCH_ASSOC ) )
                {
                    $output = <<<HTML
                   <tr>
                   <td>{$row['question']}</td>
                   <td>{$row['answer1']}</td>
                   <td>{$row['answer1']}</td>
                   <td>{$row['answer1']}</td>
                   <td>{$row['answer1']}</td>
                   <td>{$row['correct_answer']}</td>
                   <td><a href="edit.php?edit={$row['id']}" class="btn btn-primary btn-lg" role="button" alt="Edit!">Edit</a></td>
                   <td><a href="edit.php?del={$row['id']}" class="btn btn-danger btn-lg" role="button" alt="Delete!">x</a></td>
                   </tr>
HTML;
                    echo $output;

                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>