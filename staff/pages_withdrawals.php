<?php
session_start();
include('../conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];
$ret = "SELECT * FROM ib_staff where staff_id = ?";
$stmt = $mysqli->prepare($ret);
$stmt->execute([$staff_id]); //ok
$res = $stmt->get_result();
while ($row = $res->fetch_object()) {
    $staff_sacco = $row->sacco_id; //staff
}

?>

<!DOCTYPE html>
<html>
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
              <h1>Withdrawals</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_deposits">iBank Finances</a></li>
                <li class="breadcrumb-item active">Withdrawals</li>
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
                <h3 class="card-title">Select on any account to withdrawal money</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Account No.</th>
                      <th>Rate</th>
                      <th>Acc. Type</th>
                      <th>Acc. Owner</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //fetch all iB_Accs
                    $ret = "SELECT * FROM  iB_bankAccounts WHERE sacco_id = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute([$staff_sacco]); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      //Trim Timestamp to DD-MM-YYYY : H-M-S
                      $dateOpened = $row->created_at;
                      $stmt2 = $mysqli->prepare("SELECT * FROM  ib_acc_types WHERE acctype_id = $row->acc_type");
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
                        <td><?php echo $row->account_number; ?></td>
                        <td><?php echo $rate; ?>%</td>
                        <td><?php echo $acc_type; ?></td>
                        <td><?php
                            $stmt2 = $mysqli->prepare("SELECT * FROM  ib_clients WHERE client_id = $row->client_id");
                            $stmt2->execute(); //ok
                            $res2 = $stmt2->get_result();
                            while ($data = $res2->fetch_object()) {
                              echo $data->name;
                            }
                            ?></td>
                        <td>
                          <a class="btn btn-danger btn-sm" href="pages_withdraw_money.php?account_id=<?php echo $row->account_id; ?>&account_number=<?php echo $row->account_number; ?>&client_id=<?php echo $row->client_id; ?>">
                            <i class="fas fa-money-bill-alt"></i>
                            <i class="fas fa-download"></i>
                            Withdraw
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