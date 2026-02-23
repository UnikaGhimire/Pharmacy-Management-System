-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 04:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `25123854`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, NULL, 'Login Failed', 'Failed login attempt for email: admin@sunway.com', '::1', '2026-01-13 03:29:27'),
(2, NULL, 'Login Failed', 'Failed login attempt for email: admin@sunway.com', '::1', '2026-01-13 03:29:49'),
(3, NULL, 'Login Failed', 'Failed login attempt for email: admin@sunway.com', '::1', '2026-01-13 03:30:01'),
(4, NULL, 'Login Failed', 'Failed login attempt for email: staff@sunway.com', '::1', '2026-01-13 03:30:12'),
(5, NULL, 'Login Failed', 'Failed login attempt for email: admin@sunway.com', '::1', '2026-01-13 03:30:23'),
(6, NULL, 'Login Failed', 'Failed login attempt for non-existent email: admin@gmail.com', '::1', '2026-01-13 03:34:28'),
(7, NULL, 'Login Failed', 'Failed login attempt for non-existent email: fkf@gmail.com', '::1', '2026-01-13 03:34:42'),
(8, 1, 'Login', 'User logged in successfully', '::1', '2026-01-13 03:36:04'),
(9, 1, 'Add Staff', 'Added new staff: Shreya Bhatta', '::1', '2026-01-13 03:46:03'),
(10, 1, 'Logout', 'User logged out', '::1', '2026-01-13 03:46:37'),
(11, 2, 'Login', 'User logged in successfully', '::1', '2026-01-13 03:46:47'),
(12, 2, 'Create Bill', 'Created bill #1 for John Doe', '::1', '2026-01-13 03:47:43'),
(13, 2, 'Logout', 'User logged out', '::1', '2026-01-13 03:48:04'),
(14, 3, 'Login', 'User logged in successfully', '::1', '2026-01-13 03:49:03'),
(15, 3, 'Logout', 'User logged out', '::1', '2026-01-13 03:50:34'),
(16, 1, 'Login', 'User logged in successfully', '::1', '2026-01-13 03:50:47'),
(17, 1, 'Logout', 'User logged out', '::1', '2026-01-13 13:40:05'),
(18, 3, 'Login', 'User logged in successfully', '::1', '2026-01-13 13:40:32'),
(19, 3, 'Logout', 'User logged out', '::1', '2026-01-13 13:41:25'),
(20, 1, 'Login', 'User logged in successfully', '::1', '2026-01-13 13:49:51'),
(21, 1, 'Add Staff', 'Added new staff: Unika Ghimire', '::1', '2026-01-13 13:50:18'),
(22, 1, 'Logout', 'User logged out', '::1', '2026-01-13 13:50:32'),
(23, 3, 'Login', 'User logged in successfully', '::1', '2026-01-13 14:07:15'),
(24, 3, 'Password Change', 'Changed account password.', '::1', '2026-01-13 15:10:17'),
(25, 3, 'Profile Update', 'Updated profile info.', '::1', '2026-01-13 15:11:14'),
(26, 3, 'Profile Update', 'Updated profile info.', '::1', '2026-01-13 15:13:59'),
(27, 1, 'Login', 'User logged in successfully', '::1', '2026-01-17 04:40:30'),
(28, 1, 'Logout', 'User logged out', '::1', '2026-01-17 05:03:55'),
(29, 2, 'Login', 'User logged in successfully', '::1', '2026-01-17 05:04:06'),
(30, 2, 'Create Bill', 'Created bill #2 for Samikshya Dhamala', '::1', '2026-01-17 05:17:03'),
(31, 2, 'Logout', 'User logged out', '::1', '2026-01-17 05:17:39'),
(32, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-17 05:18:00'),
(33, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-17 05:18:15'),
(34, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-17 05:18:22'),
(35, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-17 05:18:28'),
(36, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-17 05:18:35'),
(37, 3, 'Login', 'User logged in successfully', '::1', '2026-01-17 10:27:51'),
(38, 3, 'Logout', 'User logged out', '::1', '2026-01-17 10:28:18'),
(39, 3, 'Login', 'User logged in successfully', '::1', '2026-01-17 11:07:39'),
(40, 3, 'Logout', 'User logged out', '::1', '2026-01-17 11:52:28'),
(41, 1, 'Login', 'User logged in successfully', '::1', '2026-01-17 11:52:39'),
(42, 1, 'Logout', 'User logged out', '::1', '2026-01-17 12:50:14'),
(43, 2, 'Login', 'User logged in successfully', '::1', '2026-01-17 12:50:21'),
(44, NULL, 'Password Reset', 'Password reset for unikaghimire11@gmail.com', '::1', '2026-01-19 02:29:40'),
(45, 5, 'Login', 'User logged in successfully', '::1', '2026-01-19 02:30:08'),
(46, 5, 'Logout', 'User logged out', '::1', '2026-01-19 02:30:12'),
(47, NULL, 'Password Reset', 'Password reset for unikaghimire11@gmail.com', '::1', '2026-01-19 02:51:04'),
(48, NULL, 'Password Reset', 'Password reset for unikaghimire11@gmail.com', '::1', '2026-01-19 02:54:43'),
(49, NULL, 'Password Reset', 'Password reset for unikaghimire11@gmail.com', '::1', '2026-01-19 02:58:14'),
(50, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:58:36'),
(51, 5, 'Login', 'User logged in successfully', '::1', '2026-01-19 02:58:50'),
(52, 5, 'Logout', 'User logged out', '::1', '2026-01-19 02:58:55'),
(53, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:59:02'),
(54, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:59:07'),
(55, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:59:12'),
(56, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:59:16'),
(57, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-19 02:59:20'),
(58, 5, 'Login', 'User logged in successfully', '::1', '2026-01-19 03:00:29'),
(59, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-19 03:00:42'),
(60, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-19 03:00:48'),
(61, 5, 'Logout', 'User logged out', '::1', '2026-01-19 03:01:01'),
(62, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-19 03:01:13'),
(63, NULL, 'Login Failed', 'Failed login attempt for email: patient@example.com', '::1', '2026-01-19 03:01:30'),
(64, 5, 'Login', 'User logged in successfully', '::1', '2026-01-19 03:02:20'),
(65, 5, 'Profile Update', 'Updated profile info.', '::1', '2026-01-19 03:12:29'),
(66, 5, 'Profile Update', 'Updated profile info.', '::1', '2026-01-19 03:13:24'),
(67, 5, 'Profile Update', 'Updated profile info.', '::1', '2026-01-19 03:13:29'),
(68, 5, 'Profile Update', 'Updated profile info.', '::1', '2026-01-19 03:13:39'),
(69, 5, 'Profile Update', 'Updated profile info.', '::1', '2026-01-19 03:13:49'),
(70, 5, 'Password Change', 'Changed account password.', '::1', '2026-01-19 03:14:23'),
(71, 5, 'Logout', 'User logged out', '::1', '2026-01-19 03:14:46'),
(72, 2, 'Login', 'User logged in successfully', '::1', '2026-01-19 03:19:59'),
(73, 2, 'Delete Medicine', 'Deleted medicine: Warfarin 5mg', '::1', '2026-01-19 03:20:26'),
(74, 2, 'Logout', 'User logged out', '::1', '2026-01-19 03:21:26'),
(75, 1, 'Login', 'User logged in successfully', '::1', '2026-01-19 03:21:35'),
(76, 1, 'Logout', 'User logged out', '::1', '2026-01-19 03:21:56'),
(77, 2, 'Login', 'User logged in successfully', '::1', '2026-01-19 03:54:35'),
(78, 1, 'Login', 'User logged in successfully', '::1', '2026-01-21 06:31:51'),
(79, 1, 'Logout', 'User logged out', '::1', '2026-01-21 06:33:17'),
(80, NULL, 'Login Failed', 'Failed login attempt for email: unikaghimire11@gmail.com', '::1', '2026-01-28 15:25:06'),
(81, 5, 'Login', 'User logged in successfully', '::1', '2026-01-28 15:25:21'),
(82, 5, 'Logout', 'User logged out', '::1', '2026-01-28 15:25:37'),
(83, 3, 'Login', 'User logged in successfully', '::1', '2026-01-28 15:25:47'),
(84, 3, 'Logout', 'User logged out', '::1', '2026-01-28 15:26:22'),
(85, 2, 'Login', 'User logged in successfully', '::1', '2026-01-28 15:28:06'),
(86, 2, 'Logout', 'User logged out', '::1', '2026-01-28 15:36:01'),
(87, 1, 'Login', 'User logged in successfully', '::1', '2026-01-28 15:39:27'),
(88, 1, 'Logout', 'User logged out', '::1', '2026-01-28 15:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('paid','unpaid') DEFAULT 'paid',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `user_id`, `customer_name`, `customer_phone`, `total_amount`, `payment_status`, `created_by`, `created_at`) VALUES
(1, 3, 'John Doe', '9841234569', 25.00, 'unpaid', 2, '2026-01-13 03:47:43'),
(2, NULL, 'Samikshya Dhamala', '', 68.00, 'paid', 2, '2026-01-17 05:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `bill_id`, `medicine_id`, `medicine_name`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 7, 'Azithromycin 500mg', 1, 25.00, 25.00),
(2, 2, 2, 'Amoxicillin 250mg', 4, 15.00, 60.00),
(3, 2, 3, 'Cetirizine 10mg', 1, 8.00, 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `attempt_time`, `ip_address`) VALUES
(6, 'admin@gmail.com', '2026-01-13 03:34:28', '::1'),
(7, 'fkf@gmail.com', '2026-01-13 03:34:42', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `category`, `price`, `stock_quantity`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol 500mg', 'Pain Relief', 5.00, 500, '2026-12-31', '2026-01-13 03:28:02', '2026-01-13 03:28:02'),
(2, 'Amoxicillin 250mg', 'Antibiotic', 15.00, 196, '2026-06-30', '2026-01-13 03:28:02', '2026-01-17 05:17:03'),
(3, 'Cetirizine 10mg', 'Antihistamine', 8.00, 299, '2026-09-15', '2026-01-13 03:28:02', '2026-01-17 05:17:03'),
(4, 'Omeprazole 20mg', 'Antacid', 12.00, 150, '2026-08-20', '2026-01-13 03:28:02', '2026-01-13 03:28:02'),
(5, 'Vitamin C 500mg', 'Supplement', 10.00, 400, '2027-01-31', '2026-01-13 03:28:02', '2026-01-13 03:28:02'),
(6, 'Ibuprofen 400mg', 'Pain Relief', 7.00, 250, '2026-11-10', '2026-01-13 03:28:02', '2026-01-13 03:28:02'),
(7, 'Azithromycin 500mg', 'Antibiotic', 25.00, 99, '2026-05-25', '2026-01-13 03:28:02', '2026-01-13 03:47:43'),
(8, 'Metformin 500mg', 'Diabetes', 18.00, 180, '2026-10-15', '2026-01-13 03:28:02', '2026-01-13 03:28:02'),
(9, 'Ibuprofen 200mg', 'Pain Relief', 6.00, 500, '2026-09-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(10, 'Naproxen 250mg', 'Pain Relief', 7.50, 150, '2026-10-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(11, 'Doxycycline 100mg', 'Antibiotic', 22.00, 50, '2025-12-20', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(12, 'Cefixime 200mg', 'Antibiotic', 25.00, 4, '2026-07-25', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(13, 'Amoxicillin 500mg', 'Antibiotic', 30.00, 200, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(14, 'Loratadine 10mg', 'Antihistamine', 9.50, 100, '2026-02-28', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(15, 'Fexofenadine 120mg', 'Antihistamine', 10.00, 300, '2026-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(16, 'Ranitidine 150mg', 'Antacid', 11.00, 70, '2026-03-10', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(17, 'Famotidine 20mg', 'Antacid', 12.50, 180, '2026-12-20', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(18, 'Vitamin D 1000IU', 'Supplement', 8.00, 400, '2027-01-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(19, 'Calcium Citrate 500mg', 'Supplement', 9.00, 2, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(20, 'Metformin 850mg', 'Diabetes', 18.50, 160, '2026-10-10', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(21, 'Glibenclamide 5mg', 'Diabetes', 16.00, 90, '2026-08-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(22, 'Salbutamol Inhaler', 'Respiratory', 32.00, 150, '2026-12-05', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(23, 'Montelukast 10mg', 'Respiratory', 20.00, 80, '2026-02-25', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(24, 'Prednisone 20mg', 'Anti-inflammatory', 15.00, 50, '2025-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(25, 'Hydrocortisone Cream 1%', 'Anti-inflammatory', 12.00, 180, '2026-12-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(26, 'Omega-3 Capsules', 'Supplement', 20.00, 300, '2027-01-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(27, 'Levocetirizine 5mg', 'Antihistamine', 12.00, 200, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(28, 'Pantoprazole 40mg', 'Antacid', 14.00, 180, '2026-12-20', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(29, 'Paracetamol 650mg', 'Pain Relief', 5.50, 500, '2026-10-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(30, 'Cough Syrup 100ml', 'Respiratory', 12.00, 60, '2026-02-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(31, 'Clarithromycin 500mg', 'Antibiotic', 28.00, 10, '2026-06-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(32, 'Benzonatate 100mg', 'Respiratory', 18.00, 90, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(33, 'Prednisolone 5mg', 'Anti-inflammatory', 14.00, 50, '2025-12-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(34, 'Dextromethorphan Syrup 100ml', 'Respiratory', 11.00, 120, '2026-10-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(35, 'Clopidogrel 75mg', 'Cardiovascular', 25.00, 80, '2026-03-05', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(36, 'Atorvastatin 20mg', 'Cardiovascular', 30.00, 200, '2026-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(37, 'Amlodipine 5mg', 'Cardiovascular', 15.00, 180, '2026-12-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(38, 'Insulin Glargine 100IU/ml', 'Diabetes', 50.00, 90, '2026-10-20', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(39, 'Insulin Lispro 100IU/ml', 'Diabetes', 48.00, 5, '2026-09-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(40, 'Levothyroxine 50mcg', 'Endocrine', 12.00, 200, '2026-12-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(41, 'Thyroxine 100mcg', 'Endocrine', 14.00, 180, '2026-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(42, 'Furosemide 40mg', 'Cardiovascular', 10.00, 100, '2026-12-10', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(43, 'Hydrochlorothiazide 25mg', 'Cardiovascular', 9.00, 80, '2026-03-01', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(45, 'Levobunolol Eye Drops', 'Ophthalmic', 20.00, 40, '2026-08-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(46, 'Timolol Eye Drops', 'Ophthalmic', 22.00, 50, '2025-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(47, 'Latanoprost Eye Drops', 'Ophthalmic', 25.00, 90, '2026-10-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(48, 'Artificial Tears', 'Ophthalmic', 10.00, 200, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(49, 'Ceftriaxone 1g', 'Antibiotic', 30.00, 120, '2026-09-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(50, 'Gentamicin 80mg', 'Antibiotic', 18.00, 15, '2026-07-20', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(51, 'Insulin Human 100IU/ml', 'Diabetes', 45.00, 80, '2026-12-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(52, 'Diclofenac 50mg', 'Pain Relief', 6.00, 5, '2026-10-05', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(53, 'Calcium Carbonate 500mg', 'Supplement', 8.50, 2, '2026-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(54, 'Vitamin B12 1000mcg', 'Supplement', 15.00, 180, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(55, 'Magnesium 250mg', 'Supplement', 14.00, 90, '2026-10-15', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(56, 'Captopril 25mg', 'Cardiovascular', 12.00, 150, '2026-12-31', '2026-01-19 03:19:45', '2026-01-19 03:19:45'),
(57, 'Enalapril 10mg', 'Cardiovascular', 10.50, 120, '2026-11-30', '2026-01-19 03:19:45', '2026-01-19 03:19:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `email`, `token`, `created_at`, `expires_at`) VALUES
(1, 'user@example.com', '123456', '2026-01-13 03:28:02', '2026-01-13 09:43:02'),
(2, 'shreyabhatta17@gmail.com', '060399', '2026-01-13 03:48:21', '2026-01-13 04:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','patient') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@sunway.com', '9841234567', '$2y$10$70t7ANmjgN87D2FEyzC6duEbcylNeKfI.RtGtCcIBbrM8qb3O1GkK', 'admin', '2026-01-13 03:35:31', '2026-01-13 03:35:31'),
(2, 'Staff Member', 'staff@sunway.com', '9841234568', '$2y$10$2ljZhAeXsUAE6NGdzvki7.4X49D3g38ZSwofZxsU99jF.1v0DqCIu', 'staff', '2026-01-13 03:35:31', '2026-01-13 03:35:31'),
(3, 'Miraj Dhamala', 'patient@example.com', '9841234569', '$2y$10$KAJQGYl/C42tK.lL309thOIX2quhvUhxmFgsTUxaASrDfWMOkreL6', 'patient', '2026-01-13 03:35:31', '2026-01-13 15:11:14'),
(4, 'Shreya Bhatta', 'shreyabhatta17@gmail.com', '9852715093', '$2y$10$OcfcTn/BxXqP1wGMuI9LyetvH/NDywgEj19YMxTWsZKnpNbzDZIdi', 'staff', '2026-01-13 03:46:03', '2026-01-13 03:46:03'),
(5, 'Unika Ghimire', 'unikaghimire11@gmail.com', '9876538195', '$2y$10$YDHjpxZS7EeQJ.klKGy3Oe7ILmWRDCDiEt2wDaHU4wo07CJKHy5R.', 'patient', '2026-01-13 13:50:18', '2026-01-19 03:14:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bill_items_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
