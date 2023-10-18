<?php
ob_start();
include 'includes/config.php';
include 'inc_functions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Knowledge Knights Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body id="page-top">

    <style>

    </style>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Knowledge Knights</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Features
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>CRUD</span>
                </a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Data</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>DOB</th>
                                            <th>Image</th>
                                            <th>Email</th>
                                            <th>Grade</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    
                                    <tbody>

                                        <?php
                                      $query = "SELECT
                                      users.username,
                                      users.firstName,
                                      users.lastName,
                                      users.dateOfBirth,
                                      users.image,
                                      users.email,
                                      grade.grade
                                      
                                      
                                      FROM
                                      users 
                                      INNER JOIN
                                      student ON users.username = student.username
                                      LEFT JOIN
                                      grade ON student.gradeID = grade.gradeID ";


                                        $result = $conn->query($query);


                                        if (!$result) {
                                            die("Query failed: " . $conn->error);
                                        }
                                        ?>
                                        <?php

                                        if ($result) {
                                            foreach ($result as $row) {

                                                ?>
                                                <tr>
                                                <td>
                                                        <?= $row["username"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['firstName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['lastName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateOfBirth'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['image'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["email"] ?>
                                                    </td>

                                                     <td>
                                                        <?= $row["grade"] ?>
                                                    </td>




                                                    <td>
                                                        <a href="#editModal_<?= $row["username"] ?>"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="modal">Edit
                                                        </a>

                                                        <a href="#deleteModal_<?= $row["username"] ?>"
                                                            class="btn btn-danger btn-sm" data-bs-toggle="modal">Delete</a>
                                                            
                                                    </td>
                                                    <?php include("modals/editStudentModal.php"); ?>
                                                    <?php include("modals/deleteModal.php"); ?>
                                                </tr>
                                                <?php
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tutor Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>DOB</th>
                                            <th>Image</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Qualification</th>
                                            <th>Is Verified</th>
                                            <th>Hourly Rate</th>
                                            <th>Years Of Experience</th>
                                            <th>StreetNumber</th>
                                            <th>Street Name</th>
                                            <th>Region</th>
                                            <th>Town</th>
                                            <th>City</th>
                                            <th>Postal Code</th>
                                            <th>Action</th>
                                            <th>Accept/Reject</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $query = "SELECT
                                                users.username,
                                                users.firstName,
                                                users.lastName,
                                                users.dateOfBirth,
                                                users.image,
                                                users.email,
                                                tutor.phoneNumber,
                                                tutor.qualification,
                                                tutor.isVerified,
                                                tutor.hourlyRate,
                                                tutor.yearsOfExperience,
                                                address.streetNumber,
                                                address.streetName,
                                                address.region,
                                                address.town,
                                                address.city,
                                                address.postalCode

                                                FROM
                                                users 
                                                INNER JOIN
                                                tutor ON users.username = tutor.username

                                                LEFT JOIN
                                                address ON users.username = address.username ";

                                        $result = $conn->query($query);


                                        if (!$result) {
                                            die("Query failed: " . $conn->error);
                                        }
                                        ?>
                                        <?php

                                        if ($result) {
                                            foreach ($result as $row) {

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $row["username"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['firstName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['lastName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateOfBirth'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['image'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["email"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["phoneNumber"] ?>
                                                    </td>

                                                    <td>
                                                        <a href="http://localhost/tutor/login/uploaded_document/<?= $row["qualification"] ?>"
                                                            title="Download document" download>
                                                            <?= $row["qualification"] ?>
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?= $row["isVerified"] ?>
                                                    </td>


                                                    <td>
                                                        <?= $row["hourlyRate"] ?>
                                                    </td>


                                                    <td>
                                                        <?= $row["yearsOfExperience"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["streetNumber"] ?>
                                                    </td>


                                                    <td>
                                                        <?= $row["streetName"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["region"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["town"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["city"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["postalCode"] ?>
                                                    </td>

                                                    <td>
                                                        <a href="#editModal_<?= $row["username"] ?>"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="modal">Edit
                                                        </a>

                                                        <a href="#deleteModal_<?= $row["username"] ?>"
                                                            class="btn btn-danger btn-sm" data-bs-toggle="modal">Delete</a>
                                                    </td>

                                                    <td>



                                                        <a href="#acceptModal_<?= $row["username"] ?>"
                                                            class="btn btn-success btn-sm " data-bs-toggle="modal">Accept
                                                        </a>

                                                        <a href="#rejectModal_<?= $row["username"] ?>"
                                                            class="btn btn-danger btn-sm " data-bs-toggle="modal">Reject
                                                        </a>


                                                    </td>
                                                    <?php include("modals/editTutorModal.php"); ?>
                                                    <?php include("modals/deleteModal.php"); ?>
                                                    <?php include("modals/acceptanceConfirmationModal.php"); ?>
                                                    <?php include("modals/rejectionConfirmationModal.php"); ?>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Admin Data</h6>
                            <?php include("modals/addAdminModal.php"); ?>

                            <a href="#addModal" class="btn btn-success" data-bs-toggle="modal">Add New
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>DOB</th>
                                            <th>Image</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>DOB</th>
                                            <th>Image</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php
                                        $query = "SELECT * FROM users WHERE userType = 'Admin'";


                                        $result = $conn->query($query);


                                        if (!$result) {
                                            die("Query failed: " . $conn->error);
                                        }
                                        ?>
                                        <?php

                                        if ($result) {
                                            foreach ($result as $row) {

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $row["username"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['firstName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['lastName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateOfBirth'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['image'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["email"] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row["userType"] ?>
                                                    </td>

                                                    <td>
                                                        <a href="#editModal_<?= $row["username"] ?>"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="modal">Edit
                                                        </a>

                                                        <a href="#deleteModal_<?= $row["username"] ?>"
                                                            class="btn btn-danger btn-sm" data-bs-toggle="modal">Delete</a>
                                                    </td>
                                                    <?php include("modals/editAdminModal.php"); ?>
                                                    <?php include("modals/deleteModal.php"); ?>
                                                </tr>
                                                <?php
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2021</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.js"></script>
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['addAdmin'])) {
    registerAdmin($conn);

}

if (isset($_POST['delete'])) {
    deleteAdmin($conn);
    deleteTutor($conn);
    deleteStudent($conn);

}


if (isset($_POST['updateTutor'])) {
    updateTutorDetails($conn);

    updateTutorUploadFiles($conn);

    updateTutorPassword($conn);


}

if (isset($_POST['updateStudent'])) {
    updateStudentDetails($conn);

    updateStudentProfileImage($conn);

    updateStudentPassword($conn);


}


if (isset($_POST['updateAdmin'])) {
    updateAdminDetails($conn);
    updateAdminPassword($conn);
    updateAdminProfileImage($conn);

}