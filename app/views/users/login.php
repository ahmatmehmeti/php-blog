<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('register_success'); ?>
                <?php flash('reset_pass_message');?>
                <?php flash('login_err_message');?>
                <h2>Login</h2>
                <form action="<?php echo URLROOT; ?>/users/loginUser" method="post">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; }?>">
                                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php  if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <input type="submit" value="Submit" class="btn btn-success btn-block mt-2">
                        </div>
                        <div class="col mt-3">
                            <label>
                                <input  type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["email"]))  { ?> checked <?php } ?>  > Remember me
                            </label>
                        </div>
                        <div class="col mt-2">
                            <a href="<?php echo URLROOT; ?>/users/send_link_form" class="btn btn-light btn-block">Forgot password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>