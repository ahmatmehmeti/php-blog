<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('send_link_message');?>
                <form action="<?php echo URLROOT; ?>/users/send_link" method="post">
                    <div class="form-group">
                        <label for="email">Enter Email To Send You the resetting Password Link:</label>
                        <input type="email" name="email" class="form-control form-control-lg mt-2 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; }?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Submit" class="btn btn-success btn-block mt-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>