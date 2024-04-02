-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 06:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internetbanking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_types`
--

CREATE TABLE `acc_types` (
  `acctype_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `rate` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_types`
--

INSERT INTO `acc_types` (`acctype_id`, `name`, `description`, `rate`, `code`) VALUES
(1, 'Savings', '<p>Savings accounts&nbsp;are typically the first official bank account anybody opens. Children may open an account with a parent to begin a pattern of saving. Teenagers open accounts to stash cash earned&nbsp;from a first job&nbsp;or household chores.</p><p>Savings accounts are an excellent place to park&nbsp;emergency cash. Opening a savings account also marks the beginning of your relationship with a financial institution. For example, when joining a credit union, your &ldquo;share&rdquo; or savings account establishes your membership.</p>', '20', 'ACC-CAT-4EZFO'),
(2, ' Retirement', '<p>Retirement accounts&nbsp;offer&nbsp;tax advantages. In very general terms, you get to&nbsp;avoid paying income tax on interest&nbsp;you earn from a savings account or CD each year. But you may have to pay taxes on those earnings at a later date. Still, keeping your money sheltered from taxes may help you over the long term. Most banks offer IRAs (both&nbsp;Traditional IRAs&nbsp;and&nbsp;Roth IRAs), and they may also provide&nbsp;retirement accounts for small businesses</p>', '10', 'ACC-CAT-1QYDV'),
(4, 'Recurring deposit', '<p><strong>Recurring deposit account or RD account</strong> is opened by those who want to save certain amount of money regularly for a certain period of time and earn a higher interest rate.&nbsp;In RD&nbsp;account a&nbsp;fixed amount is deposited&nbsp;every month for a specified period and the total amount is repaid with interest at the end of the particular fixed period.&nbsp;</p><p>The period of deposit is minimum six months and maximum ten years.&nbsp;The interest rates vary&nbsp;for different plans based on the amount one saves and the period of time and also on banks. No withdrawals are allowed from the RD account. However, the bank may allow to close the account before the maturity period.</p><p>These accounts can be opened in single or joint names. Banks are also providing the Nomination facility to the RD account holders.&nbsp;</p>', '15', 'ACC-CAT-VBQLE'),
(5, 'Fixed Deposit Account', '<p>In <strong>Fixed Deposit Account</strong> (also known as <strong>FD Account</strong>), a particular sum of money is deposited in a bank for specific&nbsp;period of time. It&rsquo;s one time deposit and one time take away (withdraw) account.&nbsp;The money deposited in this account can not be withdrawn before the expiry of period.&nbsp;</p><p>However, in case of need,&nbsp; the depositor can ask for closing the fixed deposit prematurely by paying a penalty. The penalty amount varies with banks.</p><p>A high interest rate is paid on fixed deposits. The rate of interest paid for fixed deposit vary according to amount, period and also from bank to bank.</p>', '40', 'ACC-CAT-A86GO'),
(7, 'Current account', '<p><strong>Current account</strong> is mainly for business persons, firms, companies, public enterprises etc and are never used for the purpose of investment or savings.These deposits are the most liquid deposits and there are no limits for number of transactions or the amount of transactions in a day. While, there is no interest paid on amount held in the account, banks charges certain &nbsp;service charges, on such accounts. The current accounts do not have any fixed maturity as these are on continuous basis accounts.</p>', '20', 'ACC-CAT-4O8QW');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `number`, `password`, `profile_pic`) VALUES
(2, 'System Admin', 'bmg@gmail.com', 'iBank-ADM-0516', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', 'admin-icn.png');

-- --------------------------------------------------------

--
-- Table structure for table `bankaccounts`
--

CREATE TABLE `bankaccounts` (
  `account_id` int(20) NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `acc_type` int(20) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `acc_amount` bigint(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sacco_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankaccounts`
--

INSERT INTO `bankaccounts` (`account_id`, `acc_name`, `account_number`, `acc_type`, `acc_status`, `acc_amount`, `client_id`, `sacco_id`, `created_at`) VALUES
(2, 'Precast Tech ', '319862705', 5, 'Active', 0, 1, 6, '2024-02-24 07:03:56.119924'),
(3, 'MUSONI Addy', '910634872', 2, 'Active', 0, 5, 4, '2024-02-10 11:43:24.414024'),
(4, 'SIMBA Ltd update', '730295614', 7, 'Active', 0, 3, 4, '2024-02-10 12:12:06.144287'),
(6, 'Second Account', '948376215', 4, 'Active', 0, 5, 4, '2024-02-14 12:30:45.822115'),
(9, 'BMG Lewis Ltd', '019783542', 5, 'Inactive', 0, 1, 6, '2024-03-23 06:38:22.020539'),
(10, 'Lebon Ltd', '154238907', 2, 'Active', 0, 14, 7, '2024-03-31 04:46:26.883599');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `national_id` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL,
  `sacco_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `national_id`, `phone`, `email`, `password`, `profile_pic`, `client_number`, `sacco_id`) VALUES
(1, 'BYAMUNGU Lewis ', '1129930029292292', '0789818378', 'byamungulewis@gmail.com', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', '', 'CLIENT-001', 6),
(3, 'ISHIMWE Gloria', '1199003939939393', '0786635355', 'ishimwegloria@gmail.com', '0dfed031f0bb0def3670aa08a1575b14ae5d1a4b', 'team-4.jpg', 'CLIENT-002', 4),
(5, 'MUSONI Addy', '1222555555555545', '0785436135', 'blewis@gmail.com', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', '', 'CLIENT-003', 4),
(14, 'Ntwari Lebon', '1129930334444444', '0724790762', 'ntwarilebon09@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '', 'iBank-CLIENT-0329', 7),
(15, 'Halla Dotson', 'Qui in reprehenderit', '+1 (137) 427-7071', 'semux@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', '', 'iBank-CLIENT-1467', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(20) NOT NULL,
  `notification_details` text NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_details`, `created_at`) VALUES
(20, 'Amanda Stiefel Has Deposited $ 2658 To Bank Account 287359614', '2023-02-16 16:17:22.592127'),
(21, 'Liam Moore Has Deposited $ 5650 To Bank Account 719360482', '2023-02-16 16:29:14.930350'),
(22, 'Liam Moore Has Withdrawn $ 777 From Bank Account 719360482', '2023-02-16 16:29:38.233567'),
(23, 'Liam Moore Has Transfered $ 1256 From Bank Account 719360482 To Bank Account 287359614', '2023-02-16 16:30:15.575946'),
(24, 'John Doe Has Deposited $ 8550 To Bank Account 724310586', '2023-02-16 16:40:49.513943'),
(25, 'Liam Moore Has Deposited $ 600 To Bank Account 719360482', '2023-02-16 16:40:57.385035'),
(26, 'Liam Moore Has Withdrawn $ 120 From Bank Account 719360482', '2023-02-16 16:41:14.885825'),
(27, 'John Doe Has Transfered $ 100 From Bank Account 724310586 To Bank Account 719360482', '2023-02-16 16:41:38.821974'),
(28, 'Harry Den Has Deposited $ 6800 To Bank Account 357146928', '2023-02-16 16:44:09.250277'),
(29, 'Christine Moore Has Transfered $ 19 From Bank Account 421873905 To Bank Account 719360482', '2023-06-28 15:30:30.786673'),
(30, 'man Has Deposited $ 123 To Bank Account 172053869', '2023-06-28 15:42:58.147800'),
(31, 'Christine Moore Has Deposited $ 12000 To Bank Account 421873905', '2024-01-11 09:06:03.003420'),
(32, 'Christine Moore Has Transfered $ 100 From Bank Account 421873905 To Bank Account 453890621', '2024-01-11 09:08:39.771087');

-- --------------------------------------------------------

--
-- Table structure for table `sacco`
--

CREATE TABLE `sacco` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sacco`
--

INSERT INTO `sacco` (`id`, `name`, `location`, `created_at`) VALUES
(4, 'Kinyinya Sacco', 'Kinyinya Sector Update', '2024-01-19 20:21:10'),
(6, 'Kanombe Sacco', 'Sacco of Kanombe', '2024-02-24 07:02:27'),
(7, 'Gisenyi Sacco', 'Rubavu Gisenyi', '2024-02-24 07:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(20) NOT NULL,
  `post` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `sacco_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `post`, `name`, `staff_number`, `phone`, `email`, `password`, `sex`, `profile_pic`, `sacco_id`) VALUES
(1, 'manager', 'BYAMUNGU Lewis', 'STAFF-001', '0785554455', 'byamungulewis@gmail.com', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', 'Male', '', 7),
(2, 'manager', 'NIYONASENZE Aliane', 'STAFF-002', '0789818378', 'niyonasenze@gmail.com', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', 'Female', '', 6),
(6, 'manager', 'Ntwari Lebon', 'STAFF-003', '0785556665', 'ntwarilebon09@gmail.com', 'fef3e9a034e95b328131eb25dd3382d1cc14bf36', 'Male', '', 4),
(7, 'manager', 'wisapo@mailinator.com', 'MANAGER-004', '+1 (973) 789-261', 'lupibenajy@mailinator.com', 'd6b963ee09e9e1f41ceec64b80d54f6895c3d363', 'Male', '', 7),
(8, 'teller', 'TEST USER', 'STAFF-005', '0785544555', 'testuser@email.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', 'Female', '', 4),
(9, 'loan_officer', 'TEST USER2 UPdate', 'STAFF-006', '0788855522', 'admin@gmail.com', '75dd9814c49dc27d99038c4ec197b92d66b195e8', 'Female', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `systemsettings`
--

CREATE TABLE `systemsettings` (
  `id` int(20) NOT NULL,
  `sys_name` longtext NOT NULL,
  `sys_tagline` longtext NOT NULL,
  `sys_logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `systemsettings`
--

INSERT INTO `systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`) VALUES
(1, 'Umurenge SACCO', 'Financial success at every service we offer.', 'ibankinglg.png');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tr_id` int(20) NOT NULL,
  `tr_code` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `tr_type` varchar(200) NOT NULL,
  `tr_status` varchar(200) NOT NULL,
  `transaction_amt` bigint(20) NOT NULL,
  `receiving_acc_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `sacco_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`tr_id`, `tr_code`, `client_id`, `account_id`, `tr_type`, `tr_status`, `transaction_amt`, `receiving_acc_id`, `phone`, `sacco_id`, `created_at`) VALUES
(1, 'Mvbfql3DkcXw6m2WSKeZ', 1, 2, 'Deposit', 'Success ', 40000, NULL, NULL, 7, '2024-02-24 09:30:57.854198'),
(2, '9t3BzADgkspa8LvCVrcO', 1, 2, 'Withdrawal', 'Success ', 1000, NULL, NULL, 6, '2024-02-24 09:31:08.730292'),
(4, 'BRTg4L3yI1Z9j5SANv7s', 3, 4, 'Deposit', 'Success ', 20000, NULL, NULL, 4, '2024-02-24 09:31:12.598864'),
(5, '4PM7qQTRbZVmHKSch1aJ', 3, 4, 'Withdrawal', 'Success ', 2000, NULL, NULL, 4, '2024-02-24 09:31:15.589372'),
(6, 'VJ3O0BQ4Fs9trjmMdUYA', 3, 4, 'Transfer', 'Success ', 2000, 910634872, NULL, 7, '2024-02-24 09:31:17.925927'),
(7, 'GiIKh9ESz5wJngtdscuZ', 5, 4, 'Transfer', 'Success ', 3000, 319862705, NULL, 4, '2024-02-24 09:31:30.862014'),
(9, 'O589DGIvUQzeZ0j47dqo', 5, 4, 'Loan', 'Success ', 7000, NULL, NULL, 4, '2024-02-24 09:31:27.197857'),
(10, '0hyzNOqmWYkxEbJoU6Q3', 5, 3, 'Deposit', 'Success ', 12000, NULL, NULL, 4, '2024-03-01 07:23:01.129756'),
(11, 'YgzvBeRT9LG8i2mUqJ4x', 5, 3, 'Withdrawal', 'Success ', 3000, NULL, NULL, 4, '2024-03-01 07:24:34.771066'),
(12, 'Vx8YDLn0cbBkTUNui2X4', 3, 4, 'Transfer', 'Success ', 4000, 910634872, NULL, 4, '2024-03-01 07:27:03.609978'),
(13, 'iVvFUM53uHp9LGXtPB2D', 5, 3, 'Loan', 'Success ', 34000, NULL, NULL, 4, '2024-03-01 07:29:59.447925'),
(14, '8aIjACoF1iuMv0hcKr9x', 1, 2, 'Deposit', 'Success ', 4000, NULL, NULL, 6, '2024-03-05 20:56:08.771355'),
(15, '2LJBu7mkUH0z1YrZlD5c', 1, 2, 'Withdrawal', 'Success ', 10000, NULL, '0785436135', 6, '2024-03-05 21:32:14.301495'),
(16, 'T02SbcyDIR7zXJhHVWfq', 1, 2, 'Transfer', 'Success ', 1000, 730295614, NULL, 6, '2024-03-06 04:59:59.740008'),
(18, 'fMVx8CsSm7jo1lIu2tkr', 1, 2, 'Loan', 'Success', 12000, NULL, NULL, 6, '2024-03-23 07:29:15.772499'),
(19, 'cUeKraY39ILlnuxJdp1s', 1, 2, 'Deposit', 'Success ', 4000, NULL, NULL, 6, '2024-03-23 06:51:01.019867');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_types`
--
ALTER TABLE `acc_types`
  ADD PRIMARY KEY (`acctype_id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `unique_account_number` (`account_number`),
  ADD UNIQUE KEY `unique_account_name` (`acc_name`),
  ADD KEY `fk_sacco_id` (`sacco_id`),
  ADD KEY `fk_client_id` (`client_id`),
  ADD KEY `fk_acc_type` (`acc_type`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `unique_national_id` (`national_id`),
  ADD UNIQUE KEY `unique_phone_id` (`phone`),
  ADD UNIQUE KEY `unique_client_number_id` (`client_number`),
  ADD UNIQUE KEY `unique_email_id` (`email`),
  ADD KEY `fk_saaco_id` (`sacco_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `sacco`
--
ALTER TABLE `sacco`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_phone` (`phone`),
  ADD UNIQUE KEY `unique_staff_number` (`staff_number`),
  ADD KEY `fk_saaco66_id` (`sacco_id`);

--
-- Indexes for table `systemsettings`
--
ALTER TABLE `systemsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tr_id`),
  ADD KEY `fk_saaco6_id` (`sacco_id`),
  ADD KEY `fk_account_id` (`account_id`),
  ADD KEY `client_id_by_foreign` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_types`
--
ALTER TABLE `acc_types`
  MODIFY `acctype_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  MODIFY `account_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sacco`
--
ALTER TABLE `sacco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `systemsettings`
--
ALTER TABLE `systemsettings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tr_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  ADD CONSTRAINT `fk_acc_type` FOREIGN KEY (`acc_type`) REFERENCES `acc_types` (`acctype_id`),
  ADD CONSTRAINT `fk_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sacco_id` FOREIGN KEY (`sacco_id`) REFERENCES `sacco` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_saaco_id` FOREIGN KEY (`sacco_id`) REFERENCES `sacco` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_saaco66_id` FOREIGN KEY (`sacco_id`) REFERENCES `sacco` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `client_id_by_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `fk_account_id` FOREIGN KEY (`account_id`) REFERENCES `bankaccounts` (`account_id`),
  ADD CONSTRAINT `fk_saaco6_id` FOREIGN KEY (`sacco_id`) REFERENCES `sacco` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
