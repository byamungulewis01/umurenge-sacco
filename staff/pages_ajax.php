<?php
include('../conf/pdoconfig.php');
if (!empty($_POST["iBankAccountType"])) {
    //get bank account rate
    $id = $_POST['iBankAccountType'];
    $stmt = $DB_con->prepare("SELECT * FROM acc_types WHERE  acctype_id = :id");
    $stmt->execute(array(':id' => $id));
    ?>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <?php echo htmlentities($row['rate']); ?>
    <?php
    }
}

if (!empty($_POST["iBankAccNumber"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM bankaccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));
    ?>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <?php echo htmlentities($row['acc_name']); ?>
    <?php
    }
}

if (!empty($_POST["iBankAccHolder"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccHolder'];
    $stmt = $DB_con->prepare("SELECT * FROM bankaccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));
    ?>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $client_id = $row['client_id'];
        $stmt1 = $DB_con->prepare("SELECT * FROM clients WHERE client_id=:id");
        $stmt1->execute(array(':id' => $client_id));
        while ($data = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $name = $data['name'];
        }
        // ;    

        ?>
        <?php echo htmlentities($name); ?>
    <?php
    }
}

?>