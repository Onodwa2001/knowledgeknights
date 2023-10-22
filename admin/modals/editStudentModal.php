<div class="modal fade" id="editModal_<?= $row["username"] ?>" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

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
                        <input type="hidden" value="<?= $row['username'] ?>" name="username" class="form-control"
                            id="username" placeholder="Enter Username">
                        <label for="firstname">First name</label>
                        <input type="text" name="firstname" class="form-control" value="<?= $row['firstName'] ?>"
                            id="fname" placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text" value="<?= $row['lastName'] ?>" name="lastname" class="form-control"
                            id="lname" placeholder="Enter Last Name">
                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?= $row['email'] ?>" name="email" class="form-control" id="email"
                            placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="DOB">DOB</label>
                        <input type="text" value="<?= $row['dateOfBirth'] ?>" class="form-control" placeholder="DOB"
                            name="dob" onfocus="(this.type='date')">
                    </div>
                    <div class="form-group">
                        <label>Grade</label>
                        <select class="form-control" name="grade" id="grade">
                            <?php
                            selectGrade($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="id_password" placeholder="Enter password"
                            class="form-control">
                        <i class="far fa-eye" id="togglePassword"></i>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="confirm_id_password" placeholder="Confirm password"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="profile-pic">Profile picture</label>
                        <input type="file" name="update_image" class="form-control"
                            accept="image/jpg, image/jpeg, image/png">
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="updateStudent" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>