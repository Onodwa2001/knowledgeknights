<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Record</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form fields here -->
                <form action="" method="post" enctype="multipart/form-data">


                    <?php
                    if (isset($_GET['msg'])) { ?>
                        <p class="success-message">
                            <?php echo $_GET['msg']; ?>
                        </p>
                        <?php
                    }
                    ?>
                    <?php
                    if (isset($_GET['error'])) { ?>
                        <p class="error-message" id="error-message">
                            <?php echo $_GET['error']; ?>
                        </p>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label for="firstname">First name</label>
                        <input type="text" name="firstname" class="form-control" id="fname"
                            placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" class="form-control" id="lname"
                            placeholder="Enter Last Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username"
                            placeholder="Enter Username">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="DOB">DOB</label>
                        <input type="text" class="form-control" placeholder="DOB" name="dob"
                            onfocus="(this.type='date')" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="id_password" placeholder="Enter password"
                            class="form-control" required>
                        <i class="far fa-eye" id="togglePassword"></i>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="confirm_id_password" placeholder="Confirm password"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="profile-pic">Profile picture</label>
                        <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addAdmin" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>