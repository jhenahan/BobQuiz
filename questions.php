<?php
include 'top.php';
$category = $_POST[ 'category' ];
$name = $_SESSION[ 'name' ];
?>
<style>
    .container
    {
        margin-top : 110px;
    }

    .error
    {
        color : #B94A48;
    }

    .form-horizontal
    {
        margin-bottom : 0px;
    }

    .hide
    {
        display : none;
    }
</style>

<div class="container question">
    <div
        class="col-xs-12 col-sm-8 col-md-8 col-xs-offset-4 col-sm-offset-3 col-md-offset-3">
        <form class="form-horizontal" role="form" id='login' method="post"
              action="result.php">
            <?php
            $query = <<<SQL
                  SELECT id, question, answer1, answer2, answer3, answer4
                  FROM questionview
                  WHERE category = :category
                  ORDER BY RAND()
SQL;
            $result = $db->prepare( $query );
            $result->bindValue( ':category', $category );
            $result->execute();
            $rows = $result->rowCount();
            $i = 1;
            while ( $row = $result->fetch( PDO::FETCH_ASSOC ) )
            {
                ?>

                <?php if ( $i == 1 )
            { ?>
                <div id='question<?php echo $i; ?>' class='cont'>
                    <p class='questions'
                       id="qname<?php echo $i; ?>"> <?php echo $i ?>
                        .<?php echo $row[ 'question' ]; ?></p>
                    <input type="radio" value="1"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer1' ]; ?>
                    <br/>
                    <input type="radio" value="2"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer2' ]; ?>
                    <br/>
                    <input type="radio" value="3"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer3' ]; ?>
                    <br/>
                    <input type="radio" value="4"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer4' ]; ?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none'
                           value="5" id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/>
                    <br/>
                    <button id='next<?php echo $i; ?>'
                            class='next btn btn-success' type='button'>Next
                    </button>
                </div>

            <?php }
            elseif ( $i < 1 || $i < $rows )
            { ?>

                <div id='question<?php echo $i; ?>' class='cont'>
                    <p class='questions'
                       id="qname<?php echo $i; ?>"><?php echo $i ?>
                        .<?php echo $row[ 'question' ]; ?></p>
                    <input type="radio" value="1"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer1' ]; ?>
                    <br/>
                    <input type="radio" value="2"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer2' ]; ?>
                    <br/>
                    <input type="radio" value="3"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer3' ]; ?>
                    <br/>
                    <input type="radio" value="4"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer4' ]; ?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none'
                           value="5" id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/>
                    <br/>
                    <button id='pre<?php echo $i; ?>'
                            class='previous btn btn-success' type='button'>
                        Previous
                    </button>
                    <button id='next<?php echo $i; ?>'
                            class='next btn btn-success' type='button'>Next
                    </button>
                </div>

            <?php }
            elseif ( $i == $rows )
            { ?>
                <div id='question<?php echo $i; ?>' class='cont'>
                    <p class='questions'
                       id="qname<?php echo $i; ?>"><?php echo $i ?>
                        .<?php echo $row[ 'question' ]; ?></p>
                    <input type="radio" value="1"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer1' ]; ?>
                    <br/>
                    <input type="radio" value="2"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer2' ]; ?>
                    <br/>
                    <input type="radio" value="3"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer3' ]; ?>
                    <br/>
                    <input type="radio" value="4"
                           id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/><?php echo $row[ 'answer4' ]; ?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none'
                           value="5" id='radio1_<?php echo $row[ 'id' ]; ?>'
                           name='<?php echo $row[ 'id' ]; ?>'/>
                    <br/>

                    <button id='pre<?php echo $i; ?>'
                            class='previous btn btn-success' type='button'>
                        Previous
                    </button>
                    <button id='next<?php echo $i; ?>'
                            class='next btn btn-success' type='submit'>Finish
                    </button>
                </div>
            <?php }
                $i++;
            } ?>

        </form>
    </div>
</div>
<?php

if ( isset( $_POST[ 1 ] ) )
{
    $keys  = array_keys( $_POST );
    $order = join( ",", $keys );


    $answers = <<<ANSWERS
            SELECT id, correct_answer
            FROM questionview
            WHERE correct_answer
            IN(:ord)
            ORDER BY FIELD(correct_answer, :ord)
ANSWERS;

    $response = $db->prepare( $answers );
    $response->bindValue( ':ord', $order );
    $response->execute();

    $right_answer = 0;
    $wrong_answer = 0;
    $unanswered   = 0;
    while ( $result = $response->fetch( PDO::FETCH_ASSOC ) )
    {
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

    echo "right_answer : " . $right_answer . "<br>";
    echo "wrong_answer : " . $wrong_answer . "<br>";
    echo "unanswered : " . $unanswered . "<br>";
}
?>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script>
    $('.cont').addClass('hide');
    count = $('.questions').length;
    $('#question' + 1).removeClass('hide');

    $(document).on('click', '.next', function () {
        element = $(this).attr('id');
        last = parseInt(element.substr(element.length - 1));
        nex = last + 1;
        $('#question' + last).addClass('hide');

        $('#question' + nex).removeClass('hide');
    });

    $(document).on('click', '.previous', function () {
        element = $(this).attr('id');
        last = parseInt(element.substr(element.length - 1));
        pre = last - 1;
        $('#question' + last).addClass('hide');

        $('#question' + pre).removeClass('hide');
    });

</script>

</div>
</body>
</html>
