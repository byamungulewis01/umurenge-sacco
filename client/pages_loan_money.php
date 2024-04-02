<?php
session_start();
include '../conf/config.php';
include 'conf/checklogin.php';
check_login();
$client_id = $_SESSION['client_id'];

//register new account

if (isset($_POST['loan'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $tr_type = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $transaction_amt = $_POST['transaction_amt'];
    $sacco_id = $_POST['sacco_id'];

    //Insert Captured information to a database table
    $query = "INSERT INTO transactions (tr_code, account_id, tr_type, tr_status, transaction_amt,sacco_id ,client_id) VALUES (?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($query);
    $stmt->execute([$tr_code, $account_id, $tr_type, $tr_status, $transaction_amt, $sacco_id, $_GET['client_id']]);

    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Loan Requested Successfully";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
?>
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
        <?php
$account_id = $_GET['account_id'];
$ret = "SELECT * FROM  bankaccounts WHERE account_id = ? ";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $account_id);
$stmt->execute(); //ok
$res = $stmt->get_result();
$cnt = 1;
while ($row = $res->fetch_object()) {

    $stmt2 = $mysqli->prepare("SELECT * FROM  acc_types WHERE acctype_id = $row->acc_type");
    $stmt2->execute(); //ok
    $res2 = $stmt2->get_result();
    while ($data = $res2->fetch_object()) {
        $rate = $data->rate;
        $acc_type = $data->name;
    }

    $stmt3 = $mysqli->prepare("SELECT * FROM  clients WHERE client_id = $row->client_id");
    $stmt3->execute(); //ok
    $res3 = $stmt3->get_result();
    while ($data3 = $res3->fetch_object()) {
        $name = $data3->name;
        $national_id = $data3->national_id;
        $phone = $data3->phone;
        $sacco_id = $data3->sacco_id;
    }

    ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Request Loan</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_deposits">iBank Finances</a></li>
                                    <li class="breadcrumb-item"><a href="pages_deposits">Loan</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->acc_name; ?></li>
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
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Client Name</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Client National ID No.</label>
                                                    <input type="text" readonly value="<?php echo $national_id; ?>" name="client_national_id" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Client Phone Number</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Account Name</label>
                                                    <input type="text" readonly name="acc_name" value="<?php echo $row->acc_name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Account Number</label>
                                                    <input type="text" readonly value="<?php echo $row->account_number; ?>" name="account_number" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Account Type | Category</label>
                                                    <input type="text" readonly name="acc_type" value="<?php echo $acc_type; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Transaction Code</label>
                                                    <?php
//PHP function to generate random account number
    $length = 20;
    $_transcode = substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
    ?>
                                                    <input type="text" name="tr_code" readonly value="<?php echo $_transcode; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Amount</label>
                                                    <input type="number" min="1" autofocus autocomplete="off" name="transaction_amt" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Type</label>
                                                    <input type="text" name="tr_type" value="Loan" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Status</label>
                                                    <input type="text" name="tr_status" value="Request" required class="form-control" id="exampleInputEmail1">
                                                    <input type="hidden" name="sacco_id" value="<?=$sacco_id?>" />
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="loan" class="btn btn-success">Loan</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
        <?php }?>
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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>