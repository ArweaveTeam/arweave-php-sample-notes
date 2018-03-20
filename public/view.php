<?php require __DIR__ . '/../bootstrap.php';?>


<?php

if (!@$_GET['id']) {
    // Redirect to notes list page if no id is provided
    header('Location: notes');
    exit();
}

try {
    $note = getNote($_GET['id']);
} catch (Exception $e) {
    $note  = [];
    $error = 'Error getting data. New notes may take a few minutes to become available.';
}

?>


<?php require __DIR__ . '/inc/header.php';?>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">


        <div class="header-navigation">

            <div class="controls">
                <div class="left">
                    <div class="message">
                        <?php echo $_GET['id']; ?>
                    </div>
                </div>

                <div class="right">
                    <a href="notes" class="button submit" title="Go back">
                        <i class="fas fa-chevron-left"></i>
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
        <div class="view-note">

            <?php if ($note): ?>

                <div class="view note">
                    <div class="subject">
                        <?php echo htmlspecialchars($note['subject'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <p class="body">
                        <?php echo nl2br(htmlspecialchars($note['body'], ENT_QUOTES, 'UTF-8')); ?>
                    </p>
                    <div class="meta">
                        <?php echo $note['date']; ?>
                    </div>
                </div>

            <?php else: ?>
                <div class="view note">
                    <div class="body">
                        Note not found.
                    </div>
                </div>
            <?php endif;?>

        </div>

    </div>
</div>

<script>
    $('#button-error-dismiss').click(function(){
        $('.warning.error').removeClass('visible');
    });
</script>

<?php require __DIR__ . '/inc/footer.php';?>
