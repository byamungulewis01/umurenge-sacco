<?php
session_start();
include('../conf/config.php');
include('../conf/pdoconfig.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//register new account
if (isset($_POST['create_staff_account'])) {
    //Register  Staff
    $name = $_POST['name'];
    $post = 'manager';
    $staff_number = $_POST['staff_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password']));
    $sex = $_POST['sex'];
    $sacco_id = $_POST['sacco_id'];

    $profile_pic = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "dist/img/" . $_FILES["profile_pic"]["name"]);

    try {
        //Insert Captured information to a database table
        $query = "INSERT INTO staff (post,name, staff_number, phone, email, password, sex, profile_pic,sacco_id) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param('ssssssssi',$post, $name, $staff_number, $phone, $email, $password, $sex, $profile_pic, $sacco_id);
        $stmt->execute();

        if ($stmt) {
            $success = "Staff Account Created";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } catch (\Throwable $th) {
        //throw $th;
        $err = $th->getMessage();
    }
}

?>
<!DOCTYPE html>
<html><!-- Log on to alphacodecamp.com.ng for more projects! -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Create Manager Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="pages_add_staff.php">iBanking Staff</a></li>
                                <li class="breadcrumb-item active">Add</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h3 class="card-title">Fill All Fields</h3>
                                </div>
                                <!-- form start -->
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Manager Name</label>
                                                <input type="text" name="name" required class="form-control"
                                                    id="exampleInputEmail1">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Sacco</label>
                                                <?php
                                                $ret = "SELECT * FROM  sacco";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                ?>
                                                <select class="form-control" name="sacco_id">
                                                    <option value="" selected disabled>Select Sacco</option>
                                                    <?php while ($row = $res->fetch_object()) { ?>
                                                        <option value="<?= $row->id ?>">
                                                            <?= $row->name ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="inputPhone">Manager Phone Number</label>
                                                <input type="text" minlength="10" maxlength="10" name="phone" required
                                                    class="form-control phone" id="inputPhone">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="gender">Manager Gender</label>
                                                <select class="form-control" id="gender" name="sex">
                                                    <option>Select Gender</option>
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Manager Email</label>
                                                <input type="email" name="email" required class="form-control"
                                                    id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">Manager Password</label>
                                                <input type="password" name="password" required class="form-control"
                                                    id="exampleInputEmail1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputFile">Manager Profile Picture</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="profile_pic" class="custom-file-input"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Manager Number</label>
                                                <?php
                                                //PHP function to generate random passenger number
                                                $stmt = $DB_con->prepare("SELECT * FROM  staff");
                                                $stmt->execute();
                                                $row = $stmt->rowCount();
                                                $strleft = str_pad($row + 1, 3, '0', STR_PAD_LEFT);
                                                ?>
                                                <input type="text" readonly name="staff_number"
                                                    value="MANAGER-<?php echo $strleft; ?>" class="form-control"
                                                    id="exampleInputPassword1">
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 form-group pl-3">
                                                    <button type="submit" name="create_staff_account"
                                                        class="btn btn-success">Add
                                                        Manager</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                </form>
                            </div>
                            <!-- /.card -->
                        </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".phone").on("input", function () {
                var value = $(this).val();
                var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
                if (!decimalRegex.test(value)) {
                    $(this).val(value.substring(0, value.length - 1));
                }
            });
        });

    </script>
</body>

</html>