<?php require __DIR__ . '/../bootstrap.php';?>
<?php require __DIR__ . '/inc/header.php';?>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
        <div class="header-navigation">
            <div class="controls">
                <div class="left">
                    <div class="message">
                        <?php echo count(listNotes()); ?> Notes
                    </div>
                </div>
                <div class="right">
                    <a href="new" class="button">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>



            <div class="controls warning success <?php echo @$_GET['posted'] ? 'visible' : ''; ?>">
                <div class="left">
                    <div class="message">
                        Note saved! It may take a few minutes to be comitted to the Arweave network.
                    </div>
                </div>
                <div class="right">
                    <a class="button" id="button-success-dismiss">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>

        </div>

        <?php foreach (array_reverse(listNotes()) as $note): ?>

            <div class="notes">

                <div class="note">
                    <p class="body">
                        <a href="view?id=<?php echo $note['id']; ?>"><?php echo $note['subject']; ?></a>
                    </p>
                    <div class="meta">
                        <?php echo $note['date']; ?>
                    </div>
                </div>

            </div>

        <?php endforeach;?>


    </div>
</div>


<script>
    $('#button-success-dismiss').click(function(){
        $('.warning.success').removeClass('visible');
    });
</script>

<?php require __DIR__ . '/inc/footer.php';?>
