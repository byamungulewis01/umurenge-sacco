<?php
session_start();
include '../conf/config.php';
include 'conf/checklogin.php';
check_login();
$staff_id = $_SESSION['staff_id'];
$ret = "SELECT * FROM staff where staff_id = ?";
$stmt = $mysqli->prepare($ret);
$stmt->execute([$staff_id]); //ok
$res = $stmt->get_result();
while ($row = $res->fetch_object()) {
    $staff_sacco = $row->sacco_id; //staff
}
//fire staff
if (isset($_GET['deleteBankAcc'])) {
    $id = intval($_GET['deleteBankAcc']);
    $adn = "DELETE FROM  bankaccounts  WHERE account_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $info = "iBanking Account Closed";
    } else {
        $err = "Try Again Later";
    }
}
if (isset($_GET['activeBankAcc'])) {
    $id = intval($_GET['activeBankAcc']);
    $adn = "UPDATE bankaccounts SET acc_status = 'Active' WHERE account_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $info = "iBanking Account Activated";
    } else {
        $err = "Try Again Later";
    }
}
?>
<!-- Log on to alphacodecamp.com.ng for more projects! -->
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include "dist/_partials/head.php";?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include "dist/_partials/nav.php";?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "dist/_partials/sidebar.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Manage iBanking Accounts</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_manage_acc_openings.php">iBank Accounts</a></li>
                <li class="breadcrumb-item active">Manage Accounts</li>
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
                <h3 class="card-title">Select on any action options to manage your accounts</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Acc Number</th>
                      <th>Rate</th>
                      <th>Acc Type</th>
                      <th>Acc Owner</th>
                      <th>Date Opened</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
//fetch all iB_Accs
$ret = "SELECT * FROM  bankaccounts WHERE sacco_id = ? ORDER BY account_id DESC";
$stmt = $mysqli->prepare($ret);
$stmt->execute([$staff_sacco]); //ok
$res = $stmt->get_result();
$cnt = 1;
while ($row = $res->fetch_object()) {
    //Trim Timestamp to DD-MM-YYYY : H-M-S
    $dateOpened = $row->created_at;

    $stmt2 = $mysqli->prepare("SELECT * FROM  acc_types WHERE acctype_id = $row->acc_type");
    $stmt2->execute(); //ok
    $res2 = $stmt2->get_result();
    while ($data = $res2->fetch_object()) {
        $rate = $data->rate;
        $acc_type = $data->name;
    }

    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->acc_name; ?></td>
                        <td><?= $row->account_id ?><?php echo $row->account_number; ?></td>
                        <td><?=$rate?></td>
                        <td><?=$acc_type?></td>
                        <td>
                          <?php
$stmt2 = $mysqli->prepare("SELECT * FROM  clients WHERE client_id = $row->client_id");
    $stmt2->execute(); //ok
    $res2 = $stmt2->get_result();
    while ($data = $res2->fetch_object()) {
        echo $data->name;
    }
    ?>
                        </td>
                        <td><?php echo date("d-M-Y", strtotime($dateOpened)); ?></td>
                        <td>
                        <?php if ($row->acc_status == 'Inactive') {?>
                          <a class="btn btn-warning btn-sm text-light" href="pages_manage_acc_openings.php?activeBankAcc=<?php echo $row->account_id; ?>">
                            <i class="fas fa-plus"></i>
                            <!-- <i class="fas fa-briefcase"></i> -->
                            Active Acc
                          </a>
                          <?php } else {?>
                            <a class="btn btn-success btn-sm" href="pages_update_client_accounts.php?account_id=<?php echo $row->account_id; ?>">
                            <i class="fas fa-cogs"></i>
                            Manage
                          </a>
                            <?php }?>


                          <a class="btn btn-danger btn-sm" href="pages_manage_acc_openings.php?deleteBankAcc=<?php echo $row->account_id; ?>">
                            <i class="fas fa-times"></i>
                            <!-- <i class="fas fa-briefcase"></i> -->
                            Close Account
                          </a>


                        </td>

                      </tr>
                    <?php $cnt = $cnt + 1;
}?>
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
    <?php include "dist/_partials/footer.php";?>

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
  <!-- page script -->
  <script>
    $(function() {
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