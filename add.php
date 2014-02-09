<?php
include 'top.php';

$question = getPost( 'question' );
$answer1 = getPost( 'answer1' );
$answer2 = getPost( 'answer2' );
$answer3 = getPost( 'answer3' );
$answer4 = getPost( 'answer4' );
$correct = getPost( 'correct' );
$cid = getPost( 'category' );

$form_values =
    array( $question, $answer1, $answer2, $answer3, $answer4, $correct,
           $cid );

/*
 * This is a fold which returns false if any field is empty. Since the content
 * doesn't matter, this is all we need to check for. If all the relevant fields
 * are filled in, this returns true and we proceed with the database stuff.
 */
$none_empty = array_reduce( $form_values, function ( $a, $b )
{
    return !empty( $a ) && !empty( $b );
}, true );




if ( $none_empty )
{

  $question_sql = <<<QSQL
  INSERT INTO Question
  SET question = :question
QSQL;

    $quest = $db->prepare( $question_sql );
    $quest->bindValue( ':question', $question );
    $quest->execute();
    $qid = $db->lastInsertId();

    $answer_sql = <<<ASQL
  INSERT INTO Answer
  SET answer1 = :answer1,
      answer2 = :answer2,
      answer3 = :answer3,
      answer4 = :answer4,
      correct_answer = :correct
ASQL;

    $answer = $db->prepare( $answer_sql );
    $answer->bindValue( ':answer1', $answer1 );
    $answer->bindValue( ':answer2', $answer2 );
    $answer->bindValue( ':answer3', $answer3 );
    $answer->bindValue( ':answer4', $answer4 );
    $answer->bindValue( ':correct', $correct );
    $answer->execute();
    $aid = $db->lastInsertId();

  $questionAnswer_sql = <<<QASQL
  INSERT INTO QuestionAnswer
  SET fk_question = :question,
      fk_answer = :answer
QASQL;

    $questionAnswer = $db->prepare( $questionAnswer_sql );
    $questionAnswer->bindValue( ':question', $qid );
    $questionAnswer->bindValue( ':answer', $aid );
    $questionAnswer->execute();

  $questionCategory_sql = <<<QASQL
  INSERT INTO QuestionCategory
  SET fk_question = :question,
      fk_category = :category
QASQL;

    $questionCategory = $db->prepare( $questionCategory_sql );
    $questionCategory->bindValue( ':question', $qid );
    $questionCategory->bindValue( ':category', $cid );
    $questionCategory->execute();

  $categoryName_sql = <<<NSQL
  SELECT category FROM Category
  WHERE id = :cid
NSQL;

  $categoryName = $db->prepare($categoryName_sql);
  $categoryName->bindValue(':cid', $cid);
  $categoryName->execute();
  $catName = $categoryName->fetchColumn();

    ?>
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-xs-10 col-sm-5 col-lg-5">
                <dl class="dl-horizontal">
                    <dt>Question</dt>
                    <dd><?php echo $question ?></dd>
                    <dt>Answer 1</dt>
                    <dd><?php echo $answer1 ?></dd>
                    <dt>Answer 2</dt>
                    <dd><?php echo $answer2 ?></dd>
                    <dt>Answer 3</dt>
                    <dd><?php echo $answer3 ?></dd>
                    <dt>Answer 4</dt>
                    <dd><?php echo $answer4 ?></dd>
                    <dt>Correct Answer</dt>
                    <dd><?php echo $correct ?></dd>
                    <dt>Category</dt>
                    <dd><?php echo $catName ?></dd>
                </dl>
            </div>
        </div>
    </div>
<?php
}
else
{
    include 'form.php';
}
?>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script>
    $("#addForm").validate();
</script>

</body>
</html>
