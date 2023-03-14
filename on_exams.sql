-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2022 at 07:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `on_exams`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `memberid` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `emailid` varchar(150) NOT NULL,
  `password` varchar(60) NOT NULL,
  `mobileno` int(12) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`memberid`, `name`, `emailid`, `password`, `mobileno`, `photo`) VALUES
(123, 'Mohit', 'mohit12@gmail.com', '123', 3131331, 'photos/admin/download (2).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(70) NOT NULL,
  `creationdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `creationdate`) VALUES
(1, 'Bachelor of Technology', '0000-00-00 00:00:00'),
(2, 'Bachelor of Arts', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(70) NOT NULL,
  `course_id` int(11) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`, `course_id`, `creationdate`) VALUES
(1, 'Computer Science and Engineering', 1, '2022-03-23 12:54:52'),
(3, 'Aeronautical Engineering', 1, '2022-03-24 15:32:01'),
(4, 'Mechanical Engineering', 1, '2022-03-24 15:50:13'),
(5, 'Electrical Engineering', 1, '2022-05-02 06:02:18'),
(6, 'History Honors', 2, '2022-05-03 10:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(20) NOT NULL,
  `exam_title` varchar(70) NOT NULL,
  `exam_code` varchar(6) NOT NULL,
  `course` varchar(20) NOT NULL,
  `sem` int(2) NOT NULL,
  `dept` varchar(70) NOT NULL,
  `exam_datetime` datetime DEFAULT NULL,
  `exam_duration` int(4) NOT NULL,
  `total_question` int(3) NOT NULL,
  `marks_right_answer` int(2) NOT NULL,
  `marks_wrong_answer` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_title`, `exam_code`, `course`, `sem`, `dept`, `exam_datetime`, `exam_duration`, `total_question`, `marks_right_answer`, `marks_wrong_answer`, `created_on`, `status`) VALUES
(4, 'Big Data and Analytics', '1', '1', 6, '1', '2022-05-03 13:21:54', 2, 2, 1, 1, '2022-03-24 12:44:30', 'Completed'),
(5, 'Big Data', '2', '1', 6, '1', '2022-05-03 15:53:00', 2, 10, 5, 1, '2022-05-02 11:13:28', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `questionno` int(4) NOT NULL,
  `question` varchar(100) NOT NULL,
  `option1` varchar(20) NOT NULL,
  `option2` varchar(20) NOT NULL,
  `option3` varchar(20) NOT NULL,
  `option4` varchar(20) NOT NULL,
  `correct` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `questionno`, `question`, `option1`, `option2`, `option3`, `option4`, `correct`) VALUES
(18, 5, 1, '50-2', '1', '2', '1', '48', 4),
(19, 5, 2, '4*4', '1', '23', '16', '2', 3),
(20, 5, 3, '11', '22', '11', '2', '2', 2),
(21, 4, 1, '441', 'AAw', '11', '212', '44', 2);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `resultid` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `Studentid` int(11) NOT NULL,
  `exam_datetime` datetime NOT NULL,
  `total_marks` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `percentage` double NOT NULL,
  `status` varchar(13) NOT NULL,
  `exam_declared_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`resultid`, `exam_id`, `Studentid`, `exam_datetime`, `total_marks`, `marks`, `percentage`, `status`, `exam_declared_date`) VALUES
(3, 5, 111, '2022-05-03 15:53:00', 0, 0, 0, 'Not Declared', NULL),
(4, 5, 123, '2022-05-03 15:53:00', 375, 3, 0.8, 'Not Declared', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentid` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `course` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `sem` int(2) NOT NULL,
  `specialization` char(1) NOT NULL,
  `photo` varchar(152) NOT NULL,
  `emailid` varchar(150) NOT NULL,
  `password` varchar(60) NOT NULL,
  `mobileno` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentid`, `name`, `course`, `dept_id`, `sem`, `specialization`, `photo`, `emailid`, `password`, `mobileno`, `status`) VALUES
(111, 'Ankit Ak', 1, 1, 6, '', 'photos/student/MVIMG_20211010_074512 (1).jpg', 'ankit12@gmail.com', '123', 131313131, 1),
(123, 'Pankaj', 1, 1, 6, '', 'photos/student/killhero.jpg', 'pankaj123@gmail.com', '123', 3313113, 1);

-- --------------------------------------------------------

--
-- Table structure for table `st_answers`
--

CREATE TABLE `st_answers` (
  `st_answer_id` int(11) NOT NULL,
  `Studentid` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `questionno` int(11) NOT NULL,
  `selected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `st_answers`
--

INSERT INTO `st_answers` (`st_answer_id`, `Studentid`, `exam_id`, `questionno`, `selected`) VALUES
(1, 123, 5, 1, 2),
(2, 123, 5, 2, 2),
(3, 123, 5, 3, 2),
(4, 123, 5, 4, 0),
(5, 123, 5, 5, 0),
(6, 123, 5, 6, 0),
(7, 123, 5, 7, 0),
(8, 123, 5, 8, 0),
(9, 123, 5, 9, 0),
(10, 123, 5, 10, 0),
(11, 123, 4, 1, 2),
(12, 123, 4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `st_attendence`
--

CREATE TABLE `st_attendence` (
  `attendence_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `Studentid` int(11) NOT NULL,
  `attendence` varchar(10) NOT NULL,
  `attendence_date` date NOT NULL,
  `attendence_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `st_attendence`
--

INSERT INTO `st_attendence` (`attendence_id`, `exam_id`, `Studentid`, `attendence`, `attendence_date`, `attendence_time`) VALUES
(1, 5, 111, 'Absent', '2022-05-03', '12:32:00'),
(2, 5, 123, 'Present', '2022-05-03', '15:54:44'),
(3, 4, 123, 'Present', '2022-05-03', '13:21:25'),
(4, 5, 111, 'Absent', '2022-05-03', '15:52:09'),
(5, 5, 123, 'Present', '2022-05-03', '15:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(70) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `course_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sub_id`, `sub_name`, `sub_code`, `course_id`, `dept_id`, `creationdate`) VALUES
(2, 'Big Data', 'BCSE-522', 1, 1, '2022-05-02 10:34:23'),
(3, 'CryptoGraphy', 'BCSE-411', 1, 1, '2022-05-02 11:53:25'),
(4, 'Network', 'BCSE-111', 1, 1, '2022-05-03 11:33:31'),
(5, 'Aeronautics and Space', 'BAER-123', 1, 3, '2022-05-03 11:38:36'),
(12, 'Mechanisms', 'BMEC-122', 1, 4, '2022-05-03 11:42:47'),
(13, 'Modern World', 'BA-222', 2, 6, '2022-05-03 16:31:21'),
(14, 'Javascript', 'BCSE-221', 1, 1, '2022-05-03 21:34:43'),
(15, 'Mediveal History', 'BA-231', 2, 6, '2022-05-03 21:35:33'),
(16, 'StoneAge History', 'BA-113', 2, 6, '2022-05-03 21:36:03'),
(17, 'MetalAlchemist', 'BA-115', 2, 6, '2022-05-03 21:38:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`memberid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD KEY `courseid` (`course_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`),
  ADD UNIQUE KEY `exam_title` (`exam_title`,`status`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quesforeign` (`exam_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`resultid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentid`),
  ADD KEY `dept` (`dept_id`),
  ADD KEY `course` (`course`);

--
-- Indexes for table `st_answers`
--
ALTER TABLE `st_answers`
  ADD PRIMARY KEY (`st_answer_id`);

--
-- Indexes for table `st_attendence`
--
ALTER TABLE `st_attendence`
  ADD PRIMARY KEY (`attendence_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_id`,`sub_code`),
  ADD KEY `deptforeign` (`dept_id`),
  ADD KEY `courseforeign` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `resultid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `st_answers`
--
ALTER TABLE `st_answers`
  MODIFY `st_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `st_attendence`
--
ALTER TABLE `st_attendence`
  MODIFY `attendence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `courseid` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `quesforeign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `course` FOREIGN KEY (`course`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dept` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `courseforeign` FOREIGN KEY (`course_id`) REFERENCES `department` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deptforeign` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
