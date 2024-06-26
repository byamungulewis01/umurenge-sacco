<?php
session_start();
include('../conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

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
        /*  Im About to do something stupid buh lets do it
         *  get the sumof all deposits(Money In) then get the sum of all
         *  Transfers and Withdrawals (Money Out).
         * Then To Calculate Balance and rate,
         * Take the rate, compute it and then add with the money in account and 
         * Deduce the Money out
         *
         */

        //get the total amount deposited
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM transactions WHERE  account_id = ? AND  tr_type = 'Deposit' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($deposit);
        $stmt->fetch();
        $stmt->close();

        //get total amount withdrawn
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM transactions WHERE  account_id = ? AND  tr_type = 'Withdrawal' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($withdrawal);
        $stmt->fetch();
        $stmt->close();

        //get total amount transfered
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM transactions WHERE  account_id = ? AND  tr_type = 'Transfer' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($Transfer);
        $stmt->fetch();
        $stmt->close();
        //get total amount Loan
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM transactions WHERE  account_id = ? AND  tr_type = 'Loan' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($Loan);
        $stmt->fetch();
        $stmt->close();



        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  bankaccounts WHERE account_id =? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {
            //compute rate
            $banking_rate = ($row->acc_rates) / 100;
            //compute Money out
            $money_out = $withdrawal + $Transfer;
            //compute the balance
            $money_in = $deposit - $money_out;
            //get the rate
            $rate_amt = $banking_rate * $money_in;
            //compute the intrest + balance 
            $totalMoney = $rate_amt + $money_in;

            $stmt2 = $mysqli->prepare("SELECT * FROM  clients WHERE client_id = $row->client_id");
            $stmt2->execute(); //ok
            $res2 = $stmt2->get_result();
            while ($data = $res2->fetch_object()) {
                $client_name = $data->name;
                $client_number = $data->client_number;
                $client_email = $data->email;
                $client_phone = $data->phone;
                $client_national_id = $data->national_id;
            }

            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    <?= $client_name ?>Account Balance
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_balance_enquiries.php">Finances</a></li>
                                    <li class="breadcrumb-item"><a href="pages_balance_enquiries.php">Balances</a></li>
                                    <li class="breadcrumb-item active">
                                        <?php echo $client_name; ?> Accs
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <!-- Main content -->
                                <div id="balanceSheet" class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-bank"></i> iBanking Corporation Balance Enquiry
                                                <small class="float-right">Date:
                                                    <?php echo date('d/m/Y'); ?>
                                                </small>
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            Account Holder
                                            <address>
                                                <strong>
                                                    <?php echo $client_name; ?>
                                                </strong><br>
                                                <?php echo $client_number; ?><br>
                                                <?php echo $client_email; ?><br>
                                                Phone:
                                                <?php echo $client_phone; ?><br>
                                                ID No:
                                                <?php echo $client_national_id; ?>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6 invoice-col">
                                            Account Details
                                            <?php 
                                            $stmt2 = $mysqli->prepare("SELECT * FROM  acc_types WHERE acctype_id = $row->acc_type");
                                            $stmt2->execute(); //ok
                                            $res2 = $stmt2->get_result();
                                            while ($data = $res2->fetch_object()) {
                                                $rate = $data->rate;
                                                $acc_type = $data->name;
                                            }
                                            ?>
                                            <address>
                                                <strong>
                                                    <?php echo $row->acc_name; ?>
                                                </strong><br>
                                                Acc No:
                                                <?php echo $row->account_number; ?><br>
                                                Acc Type:
                                                <?php echo $acc_type; ?><br>
                                                Acc Rates:
                                                <?php echo $rate; ?> %
                                            </address>
                                        </div>

                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Deposits</th>
                                                        <th>Withdrawals</th>
                                                        <th>Transfers</th>
                                                        <!-- <th>Loan</th> -->
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>
                                                            <?php echo $deposit; ?> Frw
                                                        </td>
                                                        <td>
                                                            <?php echo $withdrawal; ?> Frw
                                                        </td>
                                                        <td>
                                                            <?php echo $Transfer; ?> Frw
                                                        </td>
                                                        <!-- <td> <?php echo $Loan; ?></td> -->
                                                        <td>
                                                            <?php echo $money_in; ?> Frw
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-6">
                                            <p class="lead"></p>

                                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                                            </p>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-6">
                                            <p class="lead">Balance Checked On :
                                                <?php echo date('d-M-Y'); ?>
                                            </p>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="width:50%">Funds In:</th>
                                                        <td>
                                                            <?php echo $deposit; ?> Frw
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Funds Out</th>
                                                        <td>
                                                            <?php echo $money_out; ?> Frw
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sub Total:</th>
                                                        <td>
                                                            <?php echo $money_in; ?> Frw
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Banking Intrest:</th>
                                                        <td>
                                                            <?php echo $rate_amt; ?> Frw
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Balance:</th>
                                                        <td>
                                                            <?php echo $totalMoney; ?> Frw
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-12">

                                            <button type="button" id="print" onclick="printContent('balanceSheet');"
                                                class="btn btn-success float-right" style="margin-right: 5px;">
                                                <i class="fas fa-print"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.invoice -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
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
    <script>
        //print balance sheet
        function printContent(el) {
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
</body>

</html>