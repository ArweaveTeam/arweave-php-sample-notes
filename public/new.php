<?php require __DIR__ . '/../bootstrap.php';?>
<?php require __DIR__ . '/inc/header.php';?>


<?php

$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (trim(@$_POST['subject']) && trim(@$_POST['body'])) {

        saveNote($_POST['subject'], $_POST['body']);
        return header('Location: notes?posted=true');

    } else {

        $missing_field = [];

        if (!@$_POST['subject']) {
            $missing_field[] = 'subject';
        }

        if (!@$_POST['body']) {
            $missing_field[] = 'body';
        }

        $error = 'Missing required field(s): ' . implode(', ', $missing_field);
    }
}

?>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

        <div class="header-navigation">

            <div class="controls">
                <div class="left">
                    <div class="message">
                        New note
                    </div>
                </div>

                <div class="right">
                    <a href="notes" class="button submit" title="Go back">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a id="button-submit-note" class="button submit" title="Save note">
                        <i class="fas fa-check"></i>
                    </a>
                </div>
            </div>

            <div class="controls warning confirm">
                <div class="left">
                    <div class="message">
                        Are you sure? Remember, all notes are public and permanent.
                    </div>
                </div>
                <div class="right">
                    <a class="button" id="button-submit-confirm">
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="button" id="button-submit-cancel">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="controls warning error <?php echo $error ? 'visible' : ''; ?>">
                <div class="left">
                    <div class="message">
                        <?php echo $error; ?>
                    </div>
                </div>
                <div class="right">
                    <a class="button" id="button-error-dismiss">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="note new-note">
                <form  method="POST" id="form-new-note">
                    <input onkeypress="return event.keyCode != 13;" name="subject" type="text" class="subject new-subject" placeholder="Subject..." value="<?php echo @$_POST['subject']; ?>">
                    <textarea name="body" id="" cols="30" rows="20" class="new-body" placeholder="Write something..."><?php echo @$_POST['body']; ?></textarea>
                </form>
        </div>

    </div>
</div>


<script>
    $('#button-submit-note,#button-submit-cancel').click(function(){
        $('.warning.confirm').toggleClass('visible');
    });

    $('#button-error-dismiss').click(function(){
        $('.warning.error').removeClass('visible');
    });

    $('#button-submit-confirm').click(function(){
        $('#form-new-note').submit();
    });
</script>

<?php require __DIR__ . '/inc/footer.php';?>
