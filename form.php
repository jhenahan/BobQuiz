<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-xs-10 col-sm-5 col-lg-5">
            <form role="form" id="addForm" action="add.php" method="post">
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea class="form-control required" id="question"
                              name="question"
                              placeholder="Enter question"
                              rows="3"><?php alt( $question,
                                                  "" ) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="Answer 1">Answer 1</label>
                    <input type="text" class="form-control required"
                           id="answer1" name="answer1"
                           placeholder="First Answer"
                           value="<?php alt( $answer1, "" ) ?>">
                </div>
                <div class="form-group">
                    <label for="Answer 2">Answer 2</label>
                    <input type="text" class="form-control required"
                           id="answer2" name="answer2"
                           placeholder="Second Answer"
                           value="<?php alt( $answer2, "" ) ?>">
                </div>
                <div class="form-group">
                    <label for
                           ="Answer 3">Answer 3</label>
                    <input type="text" class="form-control required"
                           id="answer3" name="answer3"
                           placeholder="Third Answer"
                           value="<?php alt( $answer3, "" ) ?>">
                </div>
                <div class="form-group">
                    <label for="Answer 4">Answer 4</label>
                    <input type="text" class="form-control required"
                           id="answer4" name="answer4"
                           placeholder="Fourth Answer"
                           value="<?php alt( $answer4, "" ) ?>">
                </div>
                <div class="form-group">
                    <label for="correct">Correct Answer</label>

                    <div class="radio-inline required">
                        <label>
                            <input type="radio" name="correct" id="correct1"
                                   value="1" <?php check( $correct, 1 ) ?>
                                   class="required">
                            1
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="correct" id="correct2"
                                   value="2" <?php check( $correct, 2 ) ?>>
                            2
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="correct" id="correct3"
                                   value="3" <?php check( $correct, 3 ) ?>>
                            3
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="correct" id="correct4"
                                   value="4" <?php check( $correct, 4 ) ?>>
                            4
                        </label>
                    </div>
                    <p class="help-block">Choose the correct answer.</p>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control required" name="category"
                            id="category">
                        <option value="">Choose your category</option>
                        <?php
                        $option = <<<OPTIONS
SELECT id, category FROM Category
OPTIONS;

                        $options = $db->prepare( $option );
                        $options->execute();
                        while ( $row = $options->fetch( PDO::FETCH_ASSOC ) )
                        {
                            if ( $category == $row[ 'id' ] )
                            {
                                $sel = ' selected';
                            }
                            else
                            {
                                $sel = '';
                            }
                            $output = <<<HTML
<option value="{$row['id']}" {$sel}>
{$row['category']}
</option>
HTML;
                            echo $output;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit
                    </button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
