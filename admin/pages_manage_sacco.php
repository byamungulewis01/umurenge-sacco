<?php
session_start();
include('../conf/config.php');
include 'conf/checklogin.php';
check_login();
$admin_id = $_SESSION['admin_id'];
//fire staff
if (isset($_GET['saccoId'])) {
    try {
        $id = intval($_GET['saccoId']);
        $adn = "DELETE FROM  ib_sacco  WHERE id = ?";
        $stmt = $mysqli->prepare($adn);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        if ($stmt) {
            $info = "Sacco Deleted Succesfully";
        } else {
            $err = "Try Again Later";
        }
    } catch (\Throwable $th) {
        if ($th->getCode() == 1451) {
            $err = "Sacco you want to delete Arleady token by Clients";
        } else {
            $err = "Something went wrong , please try again later";

        }

    }
}
if (isset($_POST['create_sacco'])) {
    //Register  Staff
    $name = $_POST['name'];
    $location = $_POST['location'];

    //Insert Captured information to a database table
    try {
        $query = "INSERT INTO ib_sacco (`name`, `location`) VALUES (?,?)";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param("ss", $name, $location);
        $stmt->execute();

        //declare a varible which will be passed to alert function
        if ($stmt) {
            $success = "Sacco Account Created";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } catch (\Throwable $th) {
        //throw $th;
        $err = $th->getMessage();
    }

}
if (isset($_POST['update_sacco'])) {
    //Register  Staff
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];

    //Insert Captured information to a database table
    try {
        $query = "UPDATE ib_sacco SET `name` = ?, `location`= ? WHERE `id` =?";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param("ssi", $name, $location, $id);
        $stmt->execute();

        //declare a varible which will be passed to alert function
        if ($stmt) {
            $success = "Sacco Update Successfully";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } catch (\Throwable $th) {
        //throw $th;
        $err = $th->getMessage();
    }

}

?>
<!-- Log on to alphacodecamp.com.ng for more projects! -->
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include "dist/_partials/head.php"; ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include "dist/_partials/nav.php"; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include "dist/_partials/sidebar.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>iBanking Sacco
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="pages_manage_staff.php">iBank Staffs</a></li>
                                <li class="breadcrumb-item active">Manage Staffs</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="card-title">All Umurenge SACCO's List</h1>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm float-sm-right"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Add New
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">SACCO Registration
                                                </h1>
                                            </div>
                                            <form method="post" class="p-2">
                                                <div class="modal-body">
                                                    <div class="mb-3 form-group">
                                                        <label for="saccoName">Sacco Name</label>
                                                        <input type="text" name="name" placeholder="Provide socco name"
                                                            required autofocus autocomplete="off" class="form-control"
                                                            id="saccoName">
                                                    </div>
                                                    <div class="mb-3 form-group">
                                                        <label for="loacation">Location</label>
                                                        <input type="text" name="location"
                                                            placeholder="Provide sacco location" required
                                                            autocomplete="off" class="form-control" id="loacation">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button name="create_sacco" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sacco Name</th>
                                            <th>Location</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //fetch all iBank staffs
                                        $ret = "SELECT * FROM  iB_sacco ORDER BY RAND() ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        $cnt = 1;
                                        while ($row = $res->fetch_object()) {

                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $cnt; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->location; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->created_at; ?>
                                                </td>
                                                <td>
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#updateModel<?= $row->id ?>"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-cogs"></i>
                                                        <!-- <i class="fas fa-user-tie"></i> -->
                                                        Manage
                                                    </button>
                                                    <div class="modal fade" id="updateModel<?= $row->id ?>" tabindex="-1"
                                                        aria-labelledby="updateModel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="updateModel">
                                                                        SACCO Modification
                                                                    </h1>
                                                                </div>
                                                                <form method="post" class="p-2">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3 form-group">
                                                                            <label for="saccoName">Sacco Name</label>
                                                                            <input type="hidden" name="id"
                                                                                value="<?= $row->id ?>">
                                                                            <input type="text" name="name"
                                                                                value="<?= $row->name ?>" autofocus
                                                                                autocomplete="off" class="form-control"
                                                                                id="saccoName">
                                                                        </div>
                                                                        <div class="mb-3 form-group">
                                                                            <label for="loacation">Location</label>
                                                                            <input type="text" name="location"
                                                                                value="<?= $row->location ?>" required
                                                                                autocomplete="off" class="form-control"
                                                                                id="loacation">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button name="update_sacco"
                                                                            class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a class="btn btn-danger btn-sm"
                                                        href="?saccoId=<?php echo $row->id; ?>">
                                                        <i class="fas fa-trash"></i>
                                                        <!-- <i class="fas fa-user-tie"></i> -->
                                                        Delete
                                                    </a>


                                                </td>

                                            </tr>
                                            <?php $cnt = $cnt + 1;
                                        } ?>
                                        </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include "dist/_partials/footer.php"; ?>

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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <!-- page script -->
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
</body>

</html>