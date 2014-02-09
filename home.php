<?php
include 'top.php';
?>

<header class="jumbotron">
    <h1>Hello, Bob!</h1>

    <p>This huge box is how you know that this is yet another Bootstrap site.
       Yawn.</p>

    <p><a class="btn btn-primary btn-lg" role="button" href="spec.pdf">Learn
                                                                       more</a>
    </p>
</header>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-sm-5 col-lg-5">
            <div class="intro">
                <form class="form-signin" method="post" id='signin'
                      name="signin" action="questions.php">
                    <div class="form-group">
                        <select class="form-control" name="category"
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
                                $output = <<<HTML
<option value="{$row['id']}">
{$row['category']}
</option>
HTML;
                                echo $output;
                            }
                            ?>
                        </select>
                        <span class="help-block"></span>
                    </div>

                    <br>
                    <button class="btn btn-success btn-block" type="submit">
                        Begin Quiz
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        var form = $("#signin");
        form.validate({
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                category: {
                    required: true
                }
            },
            messages: {
                category: {
                    required: "Please choose your category to start Quiz"
                }
            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.help-block').html(error.html());
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element, lab) {
                var messages = ["That's Great!", "Looks good!", "You got it!", "Great Job!", "Smart!", "That's it!"];
                var num = Math.floor(Math.random() * 6);
                $(lab).closest('.form-group').find('.help-block').text(messages[num]);
                $(lab).addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        });
    });
</script>

</body>
</html>