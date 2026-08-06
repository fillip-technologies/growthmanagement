-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2026 at 09:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Database: `growthmanegemant`
--
-- --------------------------------------------------------
--
-- Table structure for table `account_accesses`
--

CREATE TABLE `account_accesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `text_password` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `add_tasks`
--

CREATE TABLE `add_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `progress` varchar(255) DEFAULT '0',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_tasks`
--

INSERT INTO `add_tasks` (`id`, `project_id`, `created_at`, `updated_at`, `progress`, `employee_id`) VALUES
(11, 17, '2026-07-16 06:09:33', '2026-07-16 09:36:46', NULL, 29),
(12, 18, '2026-07-31 04:33:49', '2026-07-31 04:33:49', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assing_tasks`
--

CREATE TABLE `assing_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `addtask_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assing_tasks`
--

INSERT INTO `assing_tasks` (`id`, `employee_id`, `addtask_id`, `created_at`, `updated_at`, `assigned_by`) VALUES
(46, 29, 11, '2026-07-16 09:35:48', '2026-07-16 09:35:48', 25);

-- --------------------------------------------------------
--
-- Table structure for table `attendance_infos`
--

CREATE TABLE `attendance_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `start_work` time DEFAULT NULL,
  `end_work` time DEFAULT NULL,
  `lunch_start` time DEFAULT NULL,
  `lunch_out` time DEFAULT NULL,
  `total_hours` time DEFAULT NULL,
  `status` enum('present','absent','half_day','leave') NOT NULL DEFAULT 'present',
  `today_works` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_count` varchar(255) NOT NULL DEFAULT '0',
  `lunch_count` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_infos`
--

INSERT INTO `attendance_infos` (`id`, `employee_id`, `project_id`, `date`, `day`, `start_work`, `end_work`, `lunch_start`, `lunch_out`, `total_hours`, `status`, `today_works`, `created_at`, `updated_at`, `event_count`, `lunch_count`) VALUES
(2, 21, NULL, '2026-07-06', 'Monday', '16:06:59', NULL, NULL, NULL, NULL, 'present', '<p>Create Project manager role &nbsp;base access panel</p>', '2026-07-06 10:36:59', '2026-07-06 10:37:24', '1', '0');

-- --------------------------------------------------------
--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------
--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `discusses`
--


CREATE TABLE `discusses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `chatCount` varchar(255) NOT NULL,
  `textSMS` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Dumping data for table `failed_jobs`
--


INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '90903e9b-f769-4ec1-980e-fb40e7ef7274', 'database', 'default', '{\"uuid\":\"90903e9b-f769-4ec1-980e-fb40e7ef7274\",\"displayName\":\"App\\\\Listeners\\\\AssingneTaskListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\AssingneTaskListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\AssingneTaskEvent\\\":2:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\AddTask\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"project\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:4:\\\"task\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1783413869,\"delay\":null}', 'Symfony\\Component\\Mime\\Exception\\LogicException: An email must have a \"To\", \"Cc\", or \"Bcc\" header. in C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mime\\Message.php:128\nStack trace:\n#0 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mime\\Email.php(399): Symfony\\Component\\Mime\\Message->ensureValidity()\n#1 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\SentMessage.php(34): Symfony\\Component\\Mime\\Email->ensureValidity()\n#2 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(68): Symfony\\Component\\Mailer\\SentMessage->__construct(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#3 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#4 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#5 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#6 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'Emails.assingta...\', Array, Object(Closure))\n#7 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#8 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#9 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(353): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\Mailer))\n#10 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(300): Illuminate\\Mail\\Mailer->sendMailable(Object(App\\Mail\\AssingtaskMail))\n#11 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\PendingMail.php(123): Illuminate\\Mail\\Mailer->send(Object(App\\Mail\\AssingtaskMail))\n#12 C:\\xampp\\htdocs\\growthmanagement\\app\\Listeners\\AssingneTaskListener.php(27): Illuminate\\Mail\\PendingMail->send(Object(App\\Mail\\AssingtaskMail))\n#13 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Events\\CallQueuedListener.php(113): App\\Listeners\\AssingneTaskListener->handle(Object(App\\Events\\AssingneTaskEvent))\n#14 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle(Object(Illuminate\\Foundation\\Application))\n#15 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#16 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#17 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#18 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#19 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#20 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#21 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#22 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#23 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Events\\CallQueuedListener), false)\n#24 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#25 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#26 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#27 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Events\\CallQueuedListener))\n#28 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#29 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#30 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#34 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#35 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#36 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#37 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#38 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#39 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#40 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#41 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\growthmanagement\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#48 {main}', '2026-07-07 08:44:30'),
(2, '7f261d89-4e7b-4d51-89fd-ea06e5fe934d', 'database', 'default', '{\"uuid\":\"7f261d89-4e7b-4d51-89fd-ea06e5fe934d\",\"displayName\":\"App\\\\Listeners\\\\AssingneTaskListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\AssingneTaskListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\AssingneTaskEvent\\\":2:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\AddTask\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"project\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:4:\\\"task\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1783413955,\"delay\":null}', 'Symfony\\Component\\Mime\\Exception\\LogicException: An email must have a \"To\", \"Cc\", or \"Bcc\" header. in C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mime\\Message.php:128\nStack trace:\n#0 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mime\\Email.php(399): Symfony\\Component\\Mime\\Message->ensureValidity()\n#1 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\SentMessage.php(34): Symfony\\Component\\Mime\\Email->ensureValidity()\n#2 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(68): Symfony\\Component\\Mailer\\SentMessage->__construct(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#3 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#4 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#5 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#6 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'Emails.assingta...\', Array, Object(Closure))\n#7 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#8 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#9 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(353): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\Mailer))\n#10 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(300): Illuminate\\Mail\\Mailer->sendMailable(Object(App\\Mail\\AssingtaskMail))\n#11 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\PendingMail.php(123): Illuminate\\Mail\\Mailer->send(Object(App\\Mail\\AssingtaskMail))\n#12 C:\\xampp\\htdocs\\growthmanagement\\app\\Listeners\\AssingneTaskListener.php(32): Illuminate\\Mail\\PendingMail->send(Object(App\\Mail\\AssingtaskMail))\n#13 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Events\\CallQueuedListener.php(113): App\\Listeners\\AssingneTaskListener->handle(Object(App\\Events\\AssingneTaskEvent))\n#14 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Events\\CallQueuedListener->handle(Object(Illuminate\\Foundation\\Application))\n#15 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#16 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#17 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#18 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#19 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#20 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#21 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#22 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#23 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Events\\CallQueuedListener), false)\n#24 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#25 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Events\\CallQueuedListener))\n#26 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#27 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Events\\CallQueuedListener))\n#28 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#29 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#30 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#34 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#35 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#36 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#37 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#38 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#39 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#40 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#41 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\growthmanagement\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\growthmanagement\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\growthmanagement\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#48 {main}', '2026-07-07 08:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(9, 'default', '{\"uuid\":\"ea7eec6b-481d-4bd6-ad20-0b4063750fde\",\"displayName\":\"App\\\\Listeners\\\\RegistrationListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\RegistrationListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\RegistrationEvent\\\":2:{s:8:\\\"employee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:13:\\\"plainPassword\\\";s:6:\\\"123456\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1784022014,\"delay\":null}', 0, NULL, 1784022014, 1784022014),
(10, 'default', '{\"uuid\":\"0b3705f4-8c7a-426c-862f-fc455ef75e0b\",\"displayName\":\"App\\\\Listeners\\\\RegistrationListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\RegistrationListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\RegistrationEvent\\\":2:{s:8:\\\"employee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:13:\\\"plainPassword\\\";s:6:\\\"123456\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1784024652,\"delay\":null}', 0, NULL, 1784024652, 1784024652),
(11, 'default', '{\"uuid\":\"7a5513b6-acda-44e4-945c-1d431ff426ca\",\"displayName\":\"App\\\\Listeners\\\\RegistrationListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\RegistrationListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\RegistrationEvent\\\":2:{s:8:\\\"employee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:13:\\\"plainPassword\\\";s:6:\\\"123456\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1784114726,\"delay\":null}', 0, NULL, 1784114726, 1784114726),
(12, 'default', '{\"uuid\":\"d33b2a0e-90f4-472e-92b5-6ad11264250f\",\"displayName\":\"App\\\\Listeners\\\\RegistrationListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\RegistrationListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\RegistrationEvent\\\":2:{s:8:\\\"employee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:13:\\\"plainPassword\\\";s:6:\\\"123456\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1784276867,\"delay\":null}', 0, NULL, 1784276867, 1784276867),
(13, 'default', '{\"uuid\":\"1282174c-7f68-4e72-b48c-5b45ab557a2c\",\"displayName\":\"App\\\\Listeners\\\\RegistrationListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":22:{s:5:\\\"class\\\";s:34:\\\"App\\\\Listeners\\\\RegistrationListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:28:\\\"App\\\\Events\\\\RegistrationEvent\\\":2:{s:8:\\\"employee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:13:\\\"plainPassword\\\";s:6:\\\"123456\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1784789006,\"delay\":null}', 0, NULL, 1784789006, 1784789006);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `lead_creates`
--



CREATE TABLE `lead_creates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `services` varchar(255) DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `budget_type` varchar(255) DEFAULT NULL,
  `lead_source` varchar(255) DEFAULT NULL,
  `lead_status` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_creates`
--



INSERT INTO `lead_creates` (`id`, `created_by`, `client_name`, `name`, `email`, `industry`, `phone`, `company_name`, `services`, `budget`, `budget_type`, `lead_source`, `lead_status`, `start_date`, `end_date`, `message`, `country`, `city`, `pin_code`, `state`, `created_at`, `updated_at`) VALUES
(8, 28, 'Lakshya nutrition (Amit)', 'Abhishek', 'developer4.filliptechnologies@gmail.com', 'Real Estate', '09235279546', 'Company 1', 'Website Development', '3423', 'project_based', 'website', 'converted', '2026-07-24', '2026-07-30', 'Testing', 'India', 'Ballia', '800020', 'Up', '2026-07-24 11:10:54', '2026-07-24 11:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `markering_asing_tasks`
--

CREATE TABLE `markering_asing_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `mrk_project_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markering_asing_tasks`
--

INSERT INTO `markering_asing_tasks` (`id`, `employee_id`, `mrk_project_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 29, 2, 25, '2026-07-15 12:40:30', '2026-07-15 12:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_projects`
--

CREATE TABLE `marketing_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `what_be_do` longtext DEFAULT NULL,
  `attechment` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','pending','ongoing') NOT NULL,
  `priority` enum('low','medium','high') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketing_projects`
--

INSERT INTO `marketing_projects` (`id`, `created_by`, `project_name`, `task_name`, `what_be_do`, `attechment`, `start_date`, `end_date`, `status`, `priority`, `created_at`, `updated_at`) VALUES
(2, 25, 'Test Project', 'Seo', 'mrk.dragTask', 'projectfile/1784114003.pdf', '2026-07-15', '2026-07-17', 'ongoing', 'medium', '2026-07-15 11:13:23', '2026-07-15 11:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_15_065136_create_personal_access_tokens_table', 1),
(5, '2026_01_15_072000_create_tasks_table', 1),
(6, '2026_01_15_072104_create_performances_table', 1),
(7, '2026_01_15_072143_create_reports_table', 1),
(8, '2026_01_15_104047_add_login_attempts_to_users_table', 1),
(9, '2026_01_16_091212_add_task_name_to_tasks_table', 1),
(10, '2026_04_27_112536_create_projects_table', 1),
(11, '2026_04_28_081554_add_project_id_to_tasks_table', 2),
(12, '2026_04_29_054824_create_task_updates_table', 3),
(13, '2026_04_29_074401_add_progress_to_tasks_table', 4),
(14, '2026_04_30_061652_create_project_logs_table', 5),
(15, '2026_04_30_062731_create_project_logs_table', 6),
(16, '2026_05_02_034626_create_modules_table', 7),
(17, '2026_05_02_035011_add_module_id_to_project_logs', 8),
(18, '2026_05_05_053103_create_roles_table', 8),
(19, '2026_05_05_060346_add_to_colum_role_id_to_table_role', 9),
(20, '2026_05_05_060455_add_to_colum_profile_to_table_role', 10),
(21, '2026_05_05_060601_add_to_colum_designation_to_table_role', 11),
(22, '2026_05_06_115002_add_to_colum_modules_to_table', 12),
(23, '2026_05_07_080521_add_to_colum_assingmodul_to_table', 13),
(24, '2026_05_07_121642_create_add_tasks_table', 14),
(27, '2026_05_08_043221_create_assing_tasks_table', 15),
(28, '2026_05_09_044305_add_to_colum_progress_to_table', 16),
(29, '2026_05_09_064938_create_attendance_infos_table', 17),
(30, '2026_05_09_143303_add_to_colum_event_count_to_table', 18),
(31, '2026_05_11_150954_create_take_leaves_table', 19),
(32, '2026_05_11_165748_add_to_colum_status_to_table', 20),
(33, '2026_05_15_095915_add_to_colum_department_to_table', 21),
(34, '2026_05_15_120727_add_to_colum_adharphoto_to_table', 22),
(35, '2026_05_16_104018_create_discusses_table', 23),
(37, '2026_07_04_100016_add_colum_to_role_to_table', 24),
(38, '2026_07_06_105443_add_to_colum_to_assinged_by_to_table', 25),
(39, '2026_07_14_120054_create_account_accesses_table', 26),
(40, '2026_07_15_113442_create_marketing_projects_table', 27),
(41, '2026_07_15_175036_create_markering_asing_tasks_table', 28),
(42, '2026_07_16_112945_add_to_colum_to_created_by_to_table ', 29),
(43, '2026_07_16_112945_add_to_colum_to_created_by_to_table', 30),
(44, '2026_07_16_165516_create_project_infra_resources_table', 31),
(45, '2026_07_16_172856_create_project_human_resources_table', 32),
(46, '2026_07_18_124758_create_lead_creates_table', 33),
(47, '2026_07_20_140326_create_taskfor_sales_table', 34),
(48, '2026_07_24_115640_create_team_head_tasks_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `feedback` text DEFAULT NULL,
  `score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `modules` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `client_name`, `description`, `start_date`, `end_date`, `status`, `priority`, `created_at`, `updated_at`, `modules`, `created_by`) VALUES
(17, 'Testing', NULL, 'testing modul marketing', '2026-07-16 11:39:00', '2026-07-24 11:39:00', 'ongoing', 'low', '2026-07-16 06:09:33', '2026-07-28 04:46:49', '\"[\\\"Digital Marketing\\\",\\\"ADS\\\"]\"', 25),
(18, 'test', 'Client', 'ewrwrwr', '2026-07-08 10:03:00', '2026-08-07 10:03:00', 'ongoing', 'low', '2026-07-31 04:33:49', '2026-07-31 04:34:04', '\"[null]\"', 19);

-- --------------------------------------------------------

--
-- Table structure for table `project_human_resources`
--

CREATE TABLE `project_human_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_manager` varchar(255) DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `designer` varchar(255) DEFAULT NULL,
  `qa_engineer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_human_resources`
--

INSERT INTO `project_human_resources` (`id`, `project_id`, `project_manager`, `developer`, `designer`, `qa_engineer`, `created_at`, `updated_at`) VALUES
(1, 17, 'Abhishek', NULL, NULL, NULL, '2026-07-28 04:46:49', '2026-07-28 04:46:49'),
(2, 18, NULL, NULL, NULL, NULL, '2026-07-31 04:33:49', '2026-07-31 04:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `project_infra_resources`
--

CREATE TABLE `project_infra_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `domain_name` varchar(255) DEFAULT NULL,
  `domain_registrar` varchar(255) DEFAULT NULL,
  `hosting_provider` varchar(255) DEFAULT NULL,
  `hosting_account_owner` varchar(255) DEFAULT NULL,
  `ssl_certificate` varchar(255) DEFAULT NULL,
  `email_service_provider` varchar(255) DEFAULT NULL,
  `dns_management` varchar(255) DEFAULT NULL,
  `cdn_provider` varchar(255) DEFAULT NULL,
  `third_party_apis` text DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `responsible_team_member` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_infra_resources`
--

INSERT INTO `project_infra_resources` (`id`, `project_id`, `domain_name`, `domain_registrar`, `hosting_provider`, `hosting_account_owner`, `ssl_certificate`, `email_service_provider`, `dns_management`, `cdn_provider`, `third_party_apis`, `renewal_date`, `responsible_team_member`, `created_at`, `updated_at`) VALUES
(1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-28 04:46:49', '2026-07-28 04:46:49'),
(2, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-31 04:33:49', '2026-07-31 04:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `total_tasks` int(11) NOT NULL DEFAULT 0,
  `completed_tasks` int(11) NOT NULL DEFAULT 0,
  `average_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `growth_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','employee','hr','intern') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Fj1SiTNdYFrCGk1pnhgBslquzC3ZqdtOAQmrbxcp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieW5jTU9vMExzOGVrRm5OUTlTVFU1dWZYbXFzYzEwTURoNHY2U1U4QiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS90YXNrIjtzOjU6InJvdXRlIjtzOjEzOiJlbXBsb3llZS50YXNrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NToibG9naW5fZW1wbG95ZWVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxODt9', 1778926201),
('Hua6Ws2vyiyBz3692XlyZVzFLdfslN62hd2uzahq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWTVJa1l4VU91SUttRU9ERnV6WUppMXIwaTRSd29tOWpMamNKNU01NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hbGwvcmVwb3J0IjtzOjU6InJvdXRlIjtzOjY6InJlcG9ydCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7fQ==', 1778926046);

-- --------------------------------------------------------

--
-- Table structure for table `take_leaves`
--

CREATE TABLE `take_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` longtext NOT NULL,
  `status` enum('pending','approved','reject') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taskfor_sales`
--

CREATE TABLE `taskfor_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leaddata_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assing_by` bigint(20) UNSIGNED NOT NULL,
  `task_des` longtext DEFAULT NULL,
  `due_date` date NOT NULL,
  `priority` enum('medium','high','low') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `attachments` text NOT NULL,
  `assigned_to` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `assingmodul` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_head_tasks`
--

CREATE TABLE `team_head_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','completed','ongoing','testing','live') NOT NULL DEFAULT 'pending',
  `priority` enum('medium','low','high','urgent') NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_head_tasks`
--

INSERT INTO `team_head_tasks` (`id`, `lead_id`, `user_id`, `status`, `priority`, `due_date`, `created_by`, `description`, `created_at`, `updated_at`) VALUES
(1, 8, 24, 'pending', 'high', '2026-07-25', 28, 'test', '2026-07-24 12:35:03', '2026-07-24 12:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `lock_until` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `joinig_date` varchar(255) NOT NULL,
  `employeeID` varchar(255) NOT NULL,
  `adhar_card` varchar(255) DEFAULT NULL,
  `pan_card` varchar(255) DEFAULT NULL,
  `10th_certificate` varchar(255) DEFAULT NULL,
  `12th_certificate` varchar(255) DEFAULT NULL,
  `graduation` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','hr_manager','marketing_manager','project_manager','team_leader','account_manager','employee','sales_manager') NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `profile`, `designation`, `email`, `phone`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `login_attempts`, `lock_until`, `role_id`, `department`, `joinig_date`, `employeeID`, `adhar_card`, `pan_card`, `10th_certificate`, `12th_certificate`, `graduation`, `role`) VALUES
(19, 'Vikash', '', 'CEO', 'admin@gmail.com', '', '', NULL, '$2y$12$xgvNv3mLfh85HyWZmIjjmOt7ZNPhDiyKlw8dJdDYXgG/uj15gbyny', NULL, '2026-07-04 08:26:32', '2026-07-04 08:26:32', 0, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, 'super_admin'),
(21, 'Abhishek Prajapati', NULL, 'Backend Developer', 'developer4.filliptechnologies@gmail.com', '919235279546', 'active', NULL, '$2y$12$Wj7iUenEV7iKMJ.o27JZJeu7kzKy0eoNIfEZ7TwByZO7oWMA91nQW', NULL, '2026-07-04 09:49:04', '2026-07-04 09:49:04', 0, NULL, NULL, 'IT Department', '2025-09-01', '5299', NULL, NULL, NULL, NULL, NULL, 'employee'),
(23, 'Rishav', NULL, 'Project Manager', 'rishav@gmail.com', '09235279545', 'active', NULL, '$2y$12$8JnjGXgSVLDJ3vhV9rEo5Ok/4apXwm/qASZdwx.xSdywtj/5nt/l2', NULL, '2026-07-06 08:57:05', '2026-07-07 06:38:35', 0, NULL, NULL, 'IT Department', '2026-07-04', '5005', NULL, NULL, NULL, NULL, NULL, 'project_manager'),
(24, 'Shruti Shinha', NULL, 'Sr.Backend Developer', 'developer2.filliptechnologies@gmail.com', '9235279546', 'active', NULL, '$2y$12$NQdM.el/ywDJRyCe4ghgGOxUwVk0g7mJsydDoZk60ai4rcyV0jJDG', NULL, '2026-07-06 10:24:34', '2026-07-06 10:24:34', 0, NULL, NULL, 'IT Department', '2026-07-04', '5289', NULL, NULL, NULL, NULL, NULL, 'team_leader'),
(25, 'Payal Kumari', NULL, 'Digital Marketing Manager', 'seo1.filliptechnologies@gmail.com', '8210369640', 'active', NULL, '$2y$12$YyYD.hApIn7BC0OkD1zbC.19wF3jksSAhmd7KygxPM.raBAjqPRB6', NULL, '2026-07-07 06:08:29', '2026-07-15 04:10:48', 0, NULL, NULL, 'Marketing Department', '2026-07-02', '6005', NULL, NULL, NULL, NULL, NULL, 'marketing_manager'),
(26, 'Prince Kumar', NULL, 'Frontend Developer', 'developer5.filliptechnologies@gmail.com', '0000000000', 'active', NULL, '$2y$12$EtFTfQfL4lUPEhCp6akdFuXUy0IfGEbk5cnQherQnI3YaxrFbOBfC', NULL, '2026-07-07 06:32:42', '2026-07-07 06:32:42', 0, NULL, NULL, 'IT Department', '2026-05-01', '6012', NULL, NULL, NULL, NULL, NULL, 'employee'),
(27, 'Khushi Bharti', NULL, 'HR Manager', 'khushihr@gmail.com', '1234567890', 'active', NULL, '$2y$12$dRFHJdEnOAwTH9x6OZFy6.ilLWxf5683Qhg0AsoGKciLkTojJXnXe', NULL, '2026-07-14 09:40:13', '2026-07-14 09:40:13', 0, NULL, NULL, 'Hr Department', '2024-10-04', '3456', NULL, NULL, NULL, NULL, NULL, 'hr_manager'),
(28, 'Rishav Kumar', NULL, 'Account Manager', 'acmanager@gmail.com', '2323232323', 'active', NULL, '$2y$12$og6vRiquF4SGDH94Yn/eeedtOjoNxwRzKgoWpVAXbg8EQ3ww62FgK', NULL, '2026-07-14 10:24:12', '2026-07-14 10:24:12', 0, NULL, NULL, 'Sales Department', '2026-07-01', '4444', NULL, NULL, NULL, NULL, NULL, 'account_manager'),
(29, 'Aman Kumar Sharma', NULL, 'SEO', 'seo2.filliptechnologies@gmail.com', '8210369640', 'active', NULL, '$2y$12$.r/N2S49enT6SaPyvet3uu.KZFTbcXQXciFHO.YDIekvV/u9PvI.a', NULL, '2026-07-15 11:25:24', '2026-07-15 11:25:24', 0, NULL, NULL, 'Marketing Department', '2025-08-01', '45678', NULL, NULL, NULL, NULL, NULL, 'employee'),
(30, 'Sales Manager', NULL, 'Sales Manager', 'sales@gmail.com', '2323232323', 'active', NULL, '$2y$12$4n.wgSsB9C1P90JOLCPHAOH4Xmcbaf1WC8WeM4aw9jp4cip.Pp/Xi', NULL, '2026-07-17 08:27:46', '2026-07-17 08:27:46', 0, NULL, NULL, 'Sales Department', '2026-07-17', '5000', NULL, NULL, NULL, NULL, NULL, 'sales_manager'),
(31, 'Rani Kumari', NULL, 'Business Development', 'rani@gmail.com', '3456789897', 'active', NULL, '$2y$12$Fk0BXCkGtC4TkA51FaOUI.3zWFRx0Hm8zo5dx52YI13yqXvGBm4Ea', NULL, '2026-07-23 06:43:24', '2026-07-23 06:43:24', 0, NULL, NULL, 'Sales Department', '2026-07-23', '6767', NULL, NULL, NULL, NULL, NULL, 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_accesses`
--
ALTER TABLE `account_accesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_accesses_created_by_foreign` (`created_by`);

--
-- Indexes for table `add_tasks`
--
ALTER TABLE `add_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_tasks_project_id_foreign` (`project_id`);

--
-- Indexes for table `assing_tasks`
--
ALTER TABLE `assing_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assing_tasks_employee_id_foreign` (`employee_id`),
  ADD KEY `assing_tasks_addtask_id_foreign` (`addtask_id`),
  ADD KEY `assing_tasks_assigned_by_foreign` (`assigned_by`);

--
-- Indexes for table `attendance_infos`
--
ALTER TABLE `attendance_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_infos_employee_id_foreign` (`employee_id`),
  ADD KEY `attendance_infos_project_id_foreign` (`project_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `discusses`
--
ALTER TABLE `discusses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discusses_employee_id_foreign` (`employee_id`),
  ADD KEY `discusses_project_id_foreign` (`project_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_creates`
--
ALTER TABLE `lead_creates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_creates_created_by_foreign` (`created_by`);

--
-- Indexes for table `markering_asing_tasks`
--
ALTER TABLE `markering_asing_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `markering_asing_tasks_employee_id_foreign` (`employee_id`),
  ADD KEY `markering_asing_tasks_mrk_project_id_foreign` (`mrk_project_id`),
  ADD KEY `markering_asing_tasks_created_by_foreign` (`created_by`);

--
-- Indexes for table `marketing_projects`
--
ALTER TABLE `marketing_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marketing_projects_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_project_id_foreign` (`project_id`),
  ADD KEY `modules_assigned_to_foreign` (`assigned_to`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performances_employee_id_foreign` (`employee_id`),
  ADD KEY `performances_task_id_foreign` (`task_id`),
  ADD KEY `performances_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_human_resources`
--
ALTER TABLE `project_human_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_human_resources_project_id_foreign` (`project_id`);

--
-- Indexes for table `project_infra_resources`
--
ALTER TABLE `project_infra_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_infra_resources_project_id_foreign` (`project_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `take_leaves`
--
ALTER TABLE `take_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `take_leaves_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `taskfor_sales`
--
ALTER TABLE `taskfor_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskfor_sales_leaddata_id_foreign` (`leaddata_id`),
  ADD KEY `taskfor_sales_user_id_foreign` (`user_id`),
  ADD KEY `taskfor_sales_assing_by_foreign` (`assing_by`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tasks_project_id_foreign` (`project_id`);

--
-- Indexes for table `team_head_tasks`
--
ALTER TABLE `team_head_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_head_tasks_lead_id_foreign` (`lead_id`),
  ADD KEY `team_head_tasks_user_id_foreign` (`user_id`),
  ADD KEY `team_head_tasks_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_accesses`
--
ALTER TABLE `account_accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `add_tasks`
--
ALTER TABLE `add_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `assing_tasks`
--
ALTER TABLE `assing_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `attendance_infos`
--
ALTER TABLE `attendance_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discusses`
--
ALTER TABLE `discusses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lead_creates`
--
ALTER TABLE `lead_creates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `markering_asing_tasks`
--
ALTER TABLE `markering_asing_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marketing_projects`
--
ALTER TABLE `marketing_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `project_human_resources`
--
ALTER TABLE `project_human_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_infra_resources`
--
ALTER TABLE `project_infra_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `take_leaves`
--
ALTER TABLE `take_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taskfor_sales`
--
ALTER TABLE `taskfor_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `team_head_tasks`
--
ALTER TABLE `team_head_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_accesses`
--
ALTER TABLE `account_accesses`
  ADD CONSTRAINT `account_accesses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `add_tasks`
--
ALTER TABLE `add_tasks`
  ADD CONSTRAINT `add_tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assing_tasks`
--
ALTER TABLE `assing_tasks`
  ADD CONSTRAINT `assing_tasks_addtask_id_foreign` FOREIGN KEY (`addtask_id`) REFERENCES `add_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assing_tasks_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assing_tasks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_infos`
--
ALTER TABLE `attendance_infos`
  ADD CONSTRAINT `attendance_infos_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_infos_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `discusses`
--
ALTER TABLE `discusses`
  ADD CONSTRAINT `discusses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discusses_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_creates`
--
ALTER TABLE `lead_creates`
  ADD CONSTRAINT `lead_creates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `markering_asing_tasks`
--
ALTER TABLE `markering_asing_tasks`
  ADD CONSTRAINT `markering_asing_tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `markering_asing_tasks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `markering_asing_tasks_mrk_project_id_foreign` FOREIGN KEY (`mrk_project_id`) REFERENCES `marketing_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marketing_projects`
--
ALTER TABLE `marketing_projects`
  ADD CONSTRAINT `marketing_projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `modules_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `performances_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `performances_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_human_resources`
--
ALTER TABLE `project_human_resources`
  ADD CONSTRAINT `project_human_resources_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_infra_resources`
--
ALTER TABLE `project_infra_resources`
  ADD CONSTRAINT `project_infra_resources_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `take_leaves`
--
ALTER TABLE `take_leaves`
  ADD CONSTRAINT `take_leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taskfor_sales`
--
ALTER TABLE `taskfor_sales`
  ADD CONSTRAINT `taskfor_sales_assing_by_foreign` FOREIGN KEY (`assing_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `taskfor_sales_leaddata_id_foreign` FOREIGN KEY (`leaddata_id`) REFERENCES `lead_creates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `taskfor_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_head_tasks`
--
ALTER TABLE `team_head_tasks`
  ADD CONSTRAINT `team_head_tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_head_tasks_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `lead_creates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_head_tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
