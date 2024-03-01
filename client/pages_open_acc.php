<?php
session_start();
include('../conf/config.php');

include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
//register new account
if (isset($_POST['open_account'])) {
    $acc_name = $_POST['acc_name'];
    $account_number = $_POST['account_number'];
    $acc_type = $_POST['acc_type'];
    $acc_status = $_POST['acc_status'];
    $acc_amount = $_POST['acc_amount'];
    $sacco = $_POST['sacco'];

    try {
        //Insert Captured information to a database table
        $query = "INSERT INTO bankaccounts (acc_name, account_number, acc_type, acc_status, acc_amount, client_id,sacco_id) VALUES (?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $stmt->execute([$acc_name, $account_number, $acc_type, $acc_status, $acc_amount, $client_id, $sacco]);

        //declare a varible which will be passed to alert function
        if ($stmt) {
            $success = "Sacco Account Opened";
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
        <?php
        $client_id = $_SESSION['client_id'];
        $ret = "SELECT * FROM  clients WHERE client_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $client_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Open <?php echo $row->name; ?> iBanking Account</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">iBanking Accounts</a></li>
                                    <li class="breadcrumb-item"><a href="pages_open_acc.php">Open </a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
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
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Name</label>
                                                    <input type="text" readonly name="client_name"
                                                        value="<?php echo $row->name; ?>" required class="form-control"
                                                        id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Client Number</label>
                                                    <input type="text" readonly name="client_number"
                                                        value="<?php echo $row->client_number; ?>" class="form-control"
                                                        id="exampleInputPassword1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Phone Number</label>
                                                    <input type="text" readonly name="client_phone"
                                                        value="<?php echo $row->phone; ?>" required class="form-control"
                                                        id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Client National ID No.</label>
                                                    <input type="text" readonly value="<?php echo $row->national_id; ?>"
                                                        name="client_national_id" required class="form-control"
                                                        id="exampleInputEmail1">
                                                    <input type="hidden" value="<?php echo $row->sacco_id; ?>" name="sacco" class="form-control">

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client Email</label>
                                                    <input type="email" readonly name="client_email"
                                                        value="<?php echo $row->email; ?>" required class="form-control"
                                                        id="exampleInputEmail1">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="sacco">Sacco</label>


                                                    <?php
                                                    $ret1 = "SELECT * FROM  sacco";
                                                    $stmt1 = $mysqli->prepare($ret1);
                                                    $stmt1->execute(); //ok
                                                    $res1 = $stmt1->get_result();
                                                    ?>
                                                    <select disabled class="form-control" name="sacco_id">
                                                        <?php while ($row1 = $res1->fetch_object()) { ?>
                                                            <option <?php
                                                            if ($row1->id == $row->sacco_id) {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?> value="<?= $row1->id ?>">
                                                                <?= $row1->name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- ./End Personal Details -->

                                            <!--Bank Account Details-->
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Type</label>
                                                    <select class="form-control" onChange="getiBankAccs(this.value);"
                                                        name="acc_type">
                                                        <option disabled selected>Select Any Account types</option>
                                                        <?php
                                                        //fetch all acc_types
                                                        $ret = "SELECT * FROM  acc_types ORDER BY name ASC";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($row = $res->fetch_object()) {

                                                            ?>
                                                            <option value="<?php echo $row->acctype_id; ?> ">
                                                                <?php echo $row->name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Type Rates (%)</label>
                                                    <input type="text" name="acc_rates" readonly required
                                                        class="form-control" id="AccountRates">
                                                </div>

                                                <div class=" col-md-6 form-group" style="display:none">
                                                    <label for="exampleInputEmail1">Account Status</label>
                                                    <input type="text" name="acc_status" value="Inactive" readonly required
                                                        class="form-control">
                                                </div>

                                                <div class=" col-md-6 form-group" style="display:none">
                                                    <label for="exampleInputEmail1">Account Amount</label>
                                                    <input type="text" name="acc_amount" value="0" readonly required
                                                        class="form-control">

                                                </div>

                                            </div><!-- Log on to alphacodecamp.com.ng for more projects! -->
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Name</label>
                                                    <input type="text" name="acc_name" required class="form-control"
                                                        id="exampleInputEmail1">
                                                </div>

                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Account Number</label>
                                                    <?php
                                                    //PHP function to generate random account number
                                                    $length = 12;
                                                    $_accnumber = substr(str_shuffle('0123456789'), 1, $length);
                                                    ?>
                                                    <input type="text" name="account_number"
                                                        value="<?php echo $_accnumber; ?>" required class="form-control"
                                                        id="exampleInputEmail1">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="open_account" class="btn btn-success">Open iBanking Account</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
        <?php } ?>
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
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>