<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Reset your password</h2>
                <form action="<?php echo URLROOT; ?>/users/reset_pass" method="post">
                    <div class="form-group">
                        <input type="hidden" name="email" class="form-control form-control-lg<?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $_GET['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password: </label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
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