-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 23, 2026 at 09:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pic_volunteer_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `activity_id` int DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donor_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `donated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `activity_id`, `amount`, `payment_method`, `payment_proof`, `donor_name`, `message`, `status`, `donated_at`, `verified_at`) VALUES
(1, 3, 2, '50000.00', 'cash', NULL, 'Siswa Contoh', NULL, 'verified', '2026-03-04 13:12:02', NULL),
(2, NULL, 2, '100000.00', 'transfer', NULL, 'Orang Tua Siswa A', NULL, 'pending', '2026-03-04 13:12:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `description` text,
  `target_donation` decimal(15,2) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `image_url`, `date`, `description`, `target_donation`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Pulse Career & Job Expo 2026', '/assets/images/event/pulse-career-and-job-expo.png', '2026-04-15', 'Pulse Career & Job Expo 2025 is a vibrant event hosted by Pontianak International School (PIC), bringing together a diverse community of international students from various cultural and academic backgrounds. With the theme \"Discover Your Future: Connect ??? Grow ??? Achieve,\" the expo provides opportunities to explore global career pathways, connect with international and local employers, and develop essential skills through CV reviews and interview preparation sessions. The event highlights cross-cultural collaboration and prepares students to succeed in a competitive global environment.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(2, 'Mangrove Restoration Project', '/assets/images/event/mangrove-restoration-project.png', '2026-03-21', 'Pontianak, March 21, 2026 ??? A collaborative effort to restore coastal ecosystems took place today, as a large group of students from Pontianak International College teamed up with members of the local community for a \"Community Eco-Restoration Project.\" The initiative, officially captured in this image, focused on planting mangrove saplings along a muddy riverbank with the Pontianak city skyline and river traffic as a backdrop.\n\nThe photograph captures the scale and spirit of the event. Dozens of students, identifiable by their dark blue school collared shirts and khaki shorts or skirts, are shown working alongside diverse community members. A prominent banner in the center explicitly defines the project: \"MANGROVE PARTNERSHIP WITH LOCAL COMMUNITY,\" with the Pontianak International College crest. A central moment features a community elder in traditional batik clothing mentoring a student on the correct planting technique for a young sapling, exemplifying the intergenerational and collaborative spirit of the partnership.', '5000000.00', 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(3, 'Heart to Heart: PIC Student Visit to Senior Care Home', '/assets/images/event/senior-care-home.png', '2025-04-12', 'This meaningful community service event involves international students from PIC visiting a local senior care home to spend quality time with the elderly residents. Through activities such as storytelling, games, music, and shared meals, students aim to build emotional connections and bring joy to the seniors. The program promotes empathy, cultural exchange, and social responsibility, allowing students to learn valuable life lessons while m', '7500000.00', 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(4, 'Innovation & Impact Seminar 2025 ??? The Future is Yours', '/assets/images/event/seminar-by-Dr.Sophia.png', '2025-05-09', 'The Innovation & Impact Seminar 2025 is a flagship academic event hosted by Pontianak International School (PIC), designed to inspire and empower its diverse community of international students. Centered around the theme \"Innovation & Impact: The Future is Yours,\" this seminar brings together students, educators, and a distinguished guest speaker to explore how innovation can shape a better global future.\n\nThe event will feature a keynote session delivered by a Dr. Sophia Williams, an experienced professional in the field of innovation and leadership, who will share real-world insights, personal experiences, and forward-thinking ideas. Students will gain exposure to global perspectives on entrepreneurship, technology, sustainability, and problem-solving in an ever-evolving world.\n\nIn addition to the keynote, the seminar includes an interactive Q&A session, allowing students to engage directly with the speaker, ask meaningful questions, and deepen their understanding. The program aims to foster critical thinking, creativity, and confidence among students, encouraging them to take initiative and become impactful leaders in their respective fields.\n\nThrough this seminar, PIC continues its commitment to nurturing globally minded individuals who are prepared to face future challenges, embrace innovation, and contribute positively to society.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(5, 'Green Impact: E-Waste Collection & Recycling Drive 2025', '/assets/images/event/electronics-and-e-waste.png', '2025-05-03', 'Green Impact: E-Waste Collection & Recycling Drive 2025 is an environmental initiative led by the Environmental Club of Pontianak International School (PIC), aimed at promoting sustainability and responsible waste management among its international student community. This event focuses on collecting and sorting electronic waste such as old laptops, phones, cables, and other devices to ensure they are properly recycled and do not harm the environment.\n\nThrough this hands-on activity, students will work alongside teachers and local partners to learn about the impact of electronic waste on ecosystems and human health. The program also highlights the importance of reducing digital waste in a rapidly advancing technological world. Participants will engage in sorting, basic dismantling, and categorizing electronic components, gaining practical knowledge about recycling processes.\n\nWith students coming from diverse global backgrounds, the event encourages cross-cultural collaboration in addressing environmental challenges. It aims to instill a sense of responsibility, environmental awareness, and proactive action, empowering students to become environmentally conscious global citizens.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(6, 'Kunjungan Kasih & Berbagi: PIC Community Outreach 2026', '/assets/images/event/kunjungan-kasih-and-berbagi.png', '2026-04-18', 'Kunjungan Kasih & Berbagi is a community outreach program organized by students of Pontianak International College (PIC) to connect with and support children from a local orphanage. Through this event, students engage in meaningful activities such as interactive learning sessions, creative play, and sharing educational materials. The program aims to create a joyful and supportive environment where children feel valued, while also fostering empathy and social responsibility among PIC students.\n\nIn addition to spending quality time together, the event includes donation drives where students contribute essential items such as books, stationery, clothes, and toys. These contributions are carefully prepared and distributed during the visit. Beyond material support, the event emphasizes human connection???building friendships, sharing stories, and creating memorable experiences that leave a lasting positive impact on both the children and the volunteers.', '15000000.00', 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(7, 'Industrial Insight Visit: Exploring Modern Manufacturing', '/assets/images/event/kalimantan-tech-facility.png', '2026-03-28', 'The Industrial Insight Visit is an educational field trip designed to introduce students of Pontianak International College (PIC) to real-world industrial environments. During this visit, students are guided through a modern manufacturing facility where they observe production lines, machinery operations, and safety procedures. The experience allows students to connect classroom knowledge with practical applications, especially in fields such as engineering, technology, and business operations.\n\nIn addition to the tour, students participate in an interactive session with industry professionals who share insights about career pathways, workplace expectations, and technological advancements in manufacturing. This exposure helps students better understand future career opportunities while encouraging them to develop critical thinking and adaptability in a rapidly evolving industrial world.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(8, 'Eco Exploration Project: Mangrove Research & Conservation', '/assets/images/event/eco-exploration-project.png', '2026-05-10', 'The Eco Exploration Project is a hands-on environmental program where students of Pontianak International College (PIC) participate in mangrove research and conservation activities. Set in a coastal ecosystem, students engage in fieldwork such as soil sampling, plant identification, and basic ecological surveys. Guided by environmental experts, they learn about the importance of mangroves in protecting coastlines, supporting biodiversity, and combating climate change.\n\nThroughout the program, students also take part in mangrove planting initiatives, contributing directly to environmental restoration efforts. The experience not only enhances their scientific understanding but also builds a sense of responsibility toward nature. By combining education with action, this event encourages students to become active contributors to sustainable environmental solutions in their local community.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(9, 'Flood Relief Mission: PIC Emergency Response', '/assets/images/event/flood-relief-mission.png', '2026-03-22', 'The Flood Relief Mission is a humanitarian initiative organized by students of Pontianak International College (PIC) to provide immediate assistance to communities affected by severe flooding. This program focuses on distributing essential supplies such as food, clean water, clothing, and hygiene kits to families in need. Students work together with local organizations to ensure that aid is delivered efficiently and reaches the most impacted areas.\n\nBeyond material support, the mission also emphasizes compassion and community solidarity. Volunteers engage directly with residents, helping with evacuation support, organizing temporary shelters, and offering emotional encouragement during difficult times. Through this experience, students not only contribute to meaningful relief efforts but also develop a deeper understanding of social responsibility and crisis response.', '25000000.00', 1, '2026-05-05 02:15:51', '2026-05-05 02:15:51'),
(10, 'PIC Summer Enrichment Program 2026', '/assets/images/event/summer-enrichment-program.png', '2026-05-12', 'The PIC Summer Enrichment Program 2026 is a dynamic and engaging learning experience designed to help students explore their interests beyond the traditional classroom setting. This program offers a variety of interactive modules, including robotics and coding, creative arts and media, eco-science fieldwork, music production, and sustainability innovation. Each activity is carefully structured to encourage creativity, critical thinking, and collaboration among students from diverse backgrounds.\r\n\r\nThrough hands-on projects and guided mentorship, participants will have the opportunity to build technical skills, express artistic talents, and develop a deeper understanding of real-world challenges. The program aims to create a supportive and inspiring environment where students can discover new passions, enhance their abilities, and grow both academically and personally during the summer period.', NULL, 1, '2026-05-05 02:15:51', '2026-05-05 07:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `event_donations`
--

CREATE TABLE `event_donations` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `donor_name` varchar(255) NOT NULL,
  `donor_class` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_donations`
--

INSERT INTO `event_donations` (`id`, `event_id`, `user_id`, `donor_name`, `donor_class`, `amount`, `message`, `created_at`) VALUES
(38, 2, 34, 'Citra Dewi', '11-A', '1500000.00', 'Education is the most powerful weapon. Happy to support!', '2026-05-20 04:10:10'),
(39, 2, 38, 'Sarah Wijaya', '12-A', '1000000.00', 'Proud to be a part of this amazing cause. Let\'s make an impact!', '2026-05-20 04:10:10'),
(40, 2, 3, 'Siswa Contoh', 'XI IPA 1', '750000.00', 'Every small act of kindness ripples out. Keep going, team!', '2026-05-20 04:10:10'),
(41, 2, 27, 'Ryan Smith', '10-B', '500000.00', 'Supporting the community brings so much joy. Semangat!', '2026-05-20 04:10:10'),
(42, 2, 4, 'Edward Cornelius', 'qfqwedfqwed', '250000.00', 'A clean environment starts with our contribution. Green future!', '2026-05-20 04:10:10'),
(43, 3, 35, 'Jonathan Lee', '12-D', '1500000.00', 'Education is the most powerful weapon. Happy to support!', '2026-05-20 04:10:10'),
(44, 3, 37, 'Julian Henderson', '12-E', '1000000.00', 'Proud to be a part of this amazing cause. Let\'s make an impact!', '2026-05-20 04:10:10'),
(45, 3, 21, 'Dewi Lestari', '9-B', '750000.00', 'Every small act of kindness ripples out. Keep going, team!', '2026-05-20 04:10:10'),
(46, 3, 19, 'Putri Handayani', '9-A', '500000.00', 'Supporting the community brings so much joy. Semangat!', '2026-05-20 04:10:10'),
(47, 3, 28, 'Novi Anggraini', '10-A', '250000.00', 'A clean environment starts with our contribution. Green future!', '2026-05-20 04:10:10'),
(48, 6, 26, 'Indah Permata', '10-A', '1500000.00', 'Education is the most powerful weapon. Happy to support!', '2026-05-20 04:10:10'),
(49, 6, 10, 'Siti Rahmawati', 'Teacher', '1000000.00', 'Proud to be a part of this amazing cause. Let\'s make an impact!', '2026-05-20 04:10:10'),
(50, 6, 35, 'Jonathan Lee', '12-D', '750000.00', 'Every small act of kindness ripples out. Keep going, team!', '2026-05-20 04:10:10'),
(51, 6, 28, 'Novi Anggraini', '10-A', '500000.00', 'Supporting the community brings so much joy. Semangat!', '2026-05-20 04:10:10'),
(52, 6, 13, 'Maria Susanti', 'Teacher', '250000.00', 'A clean environment starts with our contribution. Green future!', '2026-05-20 04:10:10'),
(53, 9, 35, 'Jonathan Lee', '12-D', '1500000.00', 'Education is the most powerful weapon. Happy to support!', '2026-05-20 04:10:10'),
(54, 9, 19, 'Putri Handayani', '9-A', '1000000.00', 'Proud to be a part of this amazing cause. Let\'s make an impact!', '2026-05-20 04:10:10'),
(55, 9, 37, 'Julian Henderson', '12-E', '750000.00', 'Every small act of kindness ripples out. Keep going, team!', '2026-05-20 04:10:10'),
(56, 9, 21, 'Dewi Lestari', '9-B', '500000.00', 'Supporting the community brings so much joy. Semangat!', '2026-05-20 04:10:10'),
(57, 9, 28, 'Novi Anggraini', '10-A', '250000.00', 'A clean environment starts with our contribution. Green future!', '2026-05-20 04:10:10'),
(58, 6, 7, 'billy', 'XI TKJ 1', '100000.00', 'Love is good', '2026-05-21 13:58:56'),
(59, 6, 1, 'Admin User', 'Alumni/Other', '100000.00', 'Good', '2026-05-22 14:45:37'),
(60, 6, 7, 'billy', 'XI TKJ 1', '100000.00', 'i hope its good', '2026-05-22 15:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_participants`
--

INSERT INTO `event_participants` (`id`, `event_id`, `user_id`, `created_at`) VALUES
(1, 10, 7, '2026-05-05 02:56:12'),
(2, 1, 2, '2026-05-05 03:33:59'),
(3, 1, 3, '2026-05-05 03:33:59'),
(4, 1, 4, '2026-05-05 03:33:59'),
(5, 1, 10, '2026-05-05 03:33:59'),
(6, 1, 12, '2026-05-05 03:33:59'),
(7, 1, 15, '2026-05-05 03:33:59'),
(8, 1, 18, '2026-05-05 03:33:59'),
(9, 2, 7, '2026-05-05 03:33:59'),
(10, 2, 11, '2026-05-05 03:33:59'),
(11, 2, 13, '2026-05-05 03:33:59'),
(12, 2, 16, '2026-05-05 03:33:59'),
(13, 2, 19, '2026-05-05 03:33:59'),
(14, 2, 22, '2026-05-05 03:33:59'),
(15, 2, 25, '2026-05-05 03:33:59'),
(16, 2, 28, '2026-05-05 03:33:59'),
(17, 3, 2, '2026-05-05 03:33:59'),
(18, 3, 10, '2026-05-05 03:33:59'),
(19, 3, 14, '2026-05-05 03:33:59'),
(20, 3, 18, '2026-05-05 03:33:59'),
(21, 3, 22, '2026-05-05 03:33:59'),
(22, 3, 26, '2026-05-05 03:33:59'),
(23, 3, 30, '2026-05-05 03:33:59'),
(24, 4, 3, '2026-05-05 03:33:59'),
(25, 4, 4, '2026-05-05 03:33:59'),
(26, 4, 15, '2026-05-05 03:33:59'),
(27, 4, 16, '2026-05-05 03:33:59'),
(28, 4, 17, '2026-05-05 03:33:59'),
(29, 4, 21, '2026-05-05 03:33:59'),
(30, 5, 12, '2026-05-05 03:33:59'),
(31, 5, 19, '2026-05-05 03:33:59'),
(32, 5, 25, '2026-05-05 03:33:59'),
(33, 6, 2, '2026-05-05 03:33:59'),
(34, 6, 3, '2026-05-05 03:33:59'),
(35, 6, 4, '2026-05-05 03:33:59'),
(36, 6, 7, '2026-05-05 03:33:59'),
(37, 6, 10, '2026-05-05 03:33:59'),
(38, 6, 11, '2026-05-05 03:33:59'),
(39, 6, 12, '2026-05-05 03:33:59'),
(40, 7, 20, '2026-05-05 03:33:59'),
(41, 7, 21, '2026-05-05 03:33:59'),
(42, 7, 22, '2026-05-05 03:33:59'),
(43, 7, 23, '2026-05-05 03:33:59'),
(44, 7, 24, '2026-05-05 03:33:59'),
(45, 8, 25, '2026-05-05 03:33:59'),
(46, 8, 26, '2026-05-05 03:33:59'),
(47, 8, 27, '2026-05-05 03:33:59'),
(48, 8, 28, '2026-05-05 03:33:59'),
(49, 9, 2, '2026-05-05 03:33:59'),
(50, 9, 4, '2026-05-05 03:33:59'),
(51, 9, 10, '2026-05-05 03:33:59'),
(52, 10, 15, '2026-05-05 03:33:59'),
(53, 10, 16, '2026-05-05 03:33:59'),
(54, 10, 17, '2026-05-05 03:33:59'),
(55, 8, 7, '2026-05-06 02:08:22'),
(56, 1, 7, '2026-05-09 13:55:42'),
(57, 2, 35, '2026-05-20 04:05:37'),
(58, 2, 29, '2026-05-20 04:05:37'),
(59, 2, 33, '2026-05-20 04:05:37'),
(60, 2, 23, '2026-05-20 04:05:37'),
(61, 2, 10, '2026-05-20 04:05:37'),
(62, 3, 12, '2026-05-20 04:05:37'),
(64, 3, 36, '2026-05-20 04:05:37'),
(65, 3, 24, '2026-05-20 04:05:37'),
(66, 3, 25, '2026-05-20 04:05:37'),
(67, 6, 35, '2026-05-20 04:05:37'),
(69, 6, 31, '2026-05-20 04:05:37'),
(70, 6, 24, '2026-05-20 04:05:37'),
(71, 6, 20, '2026-05-20 04:05:37'),
(72, 9, 29, '2026-05-20 04:05:37'),
(73, 9, 11, '2026-05-20 04:05:37'),
(74, 9, 32, '2026-05-20 04:05:37'),
(75, 9, 19, '2026-05-20 04:05:37'),
(76, 9, 27, '2026-05-20 04:05:37'),
(77, 2, 17, '2026-05-20 04:07:57'),
(78, 2, 38, '2026-05-20 04:07:57'),
(79, 3, 4, '2026-05-20 04:07:57'),
(80, 3, 16, '2026-05-20 04:07:57'),
(81, 3, 7, '2026-05-20 04:07:57'),
(82, 3, 39, '2026-05-20 04:07:57'),
(83, 6, 19, '2026-05-20 04:07:57'),
(84, 6, 13, '2026-05-20 04:07:57'),
(85, 6, 14, '2026-05-20 04:07:57'),
(86, 6, 38, '2026-05-20 04:07:57'),
(87, 6, 36, '2026-05-20 04:07:57'),
(89, 9, 24, '2026-05-20 04:07:58'),
(90, 9, 20, '2026-05-20 04:07:58'),
(91, 9, 7, '2026-05-20 04:07:58'),
(92, 9, 23, '2026-05-20 04:07:58'),
(93, 2, 34, '2026-05-20 04:10:10'),
(95, 2, 3, '2026-05-20 04:10:10'),
(96, 2, 27, '2026-05-20 04:10:10'),
(97, 2, 4, '2026-05-20 04:10:10'),
(98, 3, 35, '2026-05-20 04:10:10'),
(99, 3, 37, '2026-05-20 04:10:10'),
(100, 3, 21, '2026-05-20 04:10:10'),
(101, 3, 19, '2026-05-20 04:10:10'),
(102, 3, 28, '2026-05-20 04:10:10'),
(103, 6, 26, '2026-05-20 04:10:10'),
(106, 6, 28, '2026-05-20 04:10:10'),
(108, 9, 35, '2026-05-20 04:10:10'),
(110, 9, 37, '2026-05-20 04:10:10'),
(111, 9, 21, '2026-05-20 04:10:10'),
(112, 9, 28, '2026-05-20 04:10:10'),
(113, 10, 1, '2026-05-22 14:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT 'General',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image_url`, `date`, `description`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Victory Celebration: National Robotics Championship Award Ceremony', '/assets/images/latest/national-robotic-championship.png', '2026-03-04', 'This event was a formal commemorative ceremony to honor the outstanding achievement of our student body at the National Robotics Championship. After weeks of intense competition against the top technical schools in the country, PIC was officially crowned the 1st Place Winner.\n\nThe highlight of the ceremony featured the presentation of the Award of Excellence trophy by the Principal to our lead champion, Julian \"Jules\" Henderson (XII-E). Julian\'s innovative design in autonomous navigation was the key factor in securing the gold. The event served not only to celebrate this specific win but to inspire the next generation of PIC engineers and tech enthusiasts.', 'Achievement', '2026-05-05 02:34:19', '2026-05-05 02:34:19'),
(2, 'UMKM Empowerment Fair: Supporting Local Businesses Through Digital Innovation', '/assets/images/latest/umkm-empowerment.png', '2026-03-14', 'The UMKM Empowerment Fair is a bridge between the traditional craftsmanship of Pontianak and modern digital commerce. This event features local micro-enterprises???ranging from Keripik Tempe producers to Kain Songket weavers???showcasing their products while receiving hands-on digital support. Students from PIC\'s Business and IT departments provide live workshops on e-commerce integration, social media marketing, and digital payment systems to help these local heroes thrive in a global market.', 'Community', '2026-05-05 02:34:19', '2026-05-05 02:34:19'),
(3, 'Eco-Innovation Showcase: REPLA-BRICK Sustainable Paving Solutions', '/assets/images/latest/repla-brick.png', '2026-02-22', 'This showcase introduces \"REPLA-BRICK,\" a revolutionary student-led initiative focused on transforming plastic waste into high-quality, durable building materials. The project demonstrates the full lifecycle of recycled plastic???from raw waste collection to the compression of sustainable paving blocks. During the event, students presented their data on carbon emission reduction and waste management to faculty and local environmental experts, highlighting PIC\'s commitment to \"Inovasi Hijau untuk Indonesia\".', 'Environment', '2026-05-05 02:34:19', '2026-05-05 02:34:19'),
(4, 'Youth Voices Circle: Forum Diskusi Kesehatan Mental', '/assets/images/latest/youth-voices-circle.png', '2026-03-08', 'The Youth Voices Circle is a safe-space initiative designed to promote mental health awareness among the student body. In this session, participants engaged in a \"circle talk\" format to discuss the pressures of academic life, social media anxiety, and the importance of seeking help. The forum combined a brainstorming session with an open-floor discussion, allowing students to share personal stories and coping mechanisms under the guidance of a professional youth advocate.', 'Social', '2026-05-05 02:34:19', '2026-05-05 02:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('activity','improvement','event','other') COLLATE utf8mb4_unicode_ci DEFAULT 'other',
  `status` enum('pending','reviewed','approved','implemented','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `admin_response` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `user_id`, `title`, `description`, `category`, `status`, `admin_response`, `created_at`, `updated_at`) VALUES
(4, 4, 'Weekly Food Drive for Local Orphanages', 'We should establish a collection bin in the main lobby where students and staff can donate non-perishable food items. Every Friday, volunteer students can deliver these items to nearby orphanages. It is a simple but impactful way to give back.', 'activity', 'implemented', 'Excellent initiative! The weekly food drive has been successfully launched in collaboration with OSIS and is currently running every Friday. Thank you for your wonderful idea.', '2026-04-10 02:00:00', '2026-04-10 02:00:00'),
(5, 10, 'Digital Literacy Workshops for Senior Citizens', 'Many elderly people in our school neighborhood struggle with modern smartphones and online banking. Our students, especially those majoring in computer science, can run bi-weekly workshops to teach them basic digital literacy and safety online.', 'event', 'approved', 'This is an outstanding community outreach proposal. The committee has approved this event, and we are currently coordinating with the local community leader to schedule the first workshop in June 2026.', '2026-05-12 07:30:22', '2026-05-12 07:30:22'),
(6, 7, 'Implement Automated Certificate Generation for Volunteers', 'Currently, it takes a long time to get volunteer participation certificates. I suggest adding a feature to our platform where certificates are automatically generated and can be downloaded from the History page as soon as an event is marked as completed.', 'improvement', 'implemented', 'Thank you for your feedback! We have updated the history page so that students can now instantly download their digital certificates for all completed events.', '2026-05-01 04:20:10', '2026-05-01 04:20:10'),
(7, 3, 'School-wide Blood Donation Campaign', 'We should partner with the Indonesian Red Cross (PMI) to host a blood donation drive in the school auditorium. It is a great way to save lives and encourage students to perform social activities.', 'event', 'reviewed', 'We have reviewed your request and think it is a great idea. We are currently contacting PMI Pontianak to check their availability for a donation drive next semester.', '2026-05-15 01:45:00', '2026-05-15 01:45:00'),
(8, 11, 'Recycling Stations in Every Classroom', 'To promote sustainability, we should replace the single trash bins in classrooms with separated recycling bins (paper, plastic, organic). Student volunteers can help empty them into the main recycling bank.', 'improvement', 'implemented', NULL, '2026-05-19 09:05:12', '2026-05-20 02:43:23'),
(9, 4, 'Weekend Cleanup Drive at Pontianak Waterfront', 'The Pontianak Waterfront is a popular spot but often gets dirty. A monthly weekend cleanup campaign with volunteer students would keep our public space beautiful and set a good example for the citizens.', 'event', 'rejected', 'While we highly appreciate the spirit of this suggestion, the waterfront is currently managed by a dedicated municipal cleanup team under a new city program. We will focus our student volunteering efforts on other areas such as greening school environments.', '2026-04-20 06:10:40', '2026-04-20 06:10:40'),
(10, 7, 'Add WhatsApp Reminders for Registered Events', 'Sometimes students register for a volunteer activity weeks in advance and forget to attend. Having automated WhatsApp notifications or email reminders 24 hours before the event would drastically improve attendance rates.', 'improvement', 'reviewed', 'We are looking into integrating an email notification system to remind volunteers. WhatsApp integration is also being considered but requires API access.', '2026-05-14 03:00:00', '2026-05-14 03:00:00'),
(11, 3, 'Mentorship Program for Underprivileged Children', 'I propose a long-term volunteer program where senior college students mentor local middle school students from underprivileged families, assisting them with math, science, and English.', 'activity', 'reviewed', 'Good', '2026-05-20 00:12:00', '2026-05-22 14:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','committee','student','teacher') COLLATE utf8mb4_unicode_ci DEFAULT 'student',
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `nis`, `class`, `major`, `phone`, `avatar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@pic.edu', '$2y$10$dwytUN6DHDhso8O9rCB76OxtkjnKWNu9zlqwvxtcaAY3okRkPMS0K', 'admin', NULL, NULL, NULL, NULL, 'default.png', 1, '2026-03-20 09:27:50', '2026-05-21 12:03:43'),
(2, 'Panitia OSIS', 'osis@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'committee', 'COMMITTEE001', 'OSIS', NULL, NULL, 'default.png', 1, '2026-03-04 13:12:02', '2026-03-04 13:12:02'),
(3, 'Siswa Contoh', 'student@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12345', 'XI IPA 1', NULL, NULL, 'default.png', 1, '2026-03-04 13:12:02', '2026-03-04 13:12:02'),
(4, 'Edward Cornelius', 'edwardcornelius27@gmail.com', '$2y$10$.r4H3NsbPdu7pO2W7Vnf.e/Wu/v9QiKTIeKEFR2Zcz9jmSrjsWrhK', 'student', '7982', '11-A', 'TKJ', '081346142556', 'default.png', 0, '2026-03-18 03:09:14', '2026-05-23 09:29:11'),
(7, 'billy', 'billy@pic.edu', '$2y$10$GeZ7rVj4ZzOJ7Ev0VZ15/uuLpJi01y3sKCVks/W0XUz.rqnBWaRS.', 'student', '7899', '11-A', 'TKJ', '082931983112', 'default.png', 1, '2026-03-20 13:02:56', '2026-05-23 09:28:55'),
(10, 'Siti Rahmawati', 'siti.rahmawati@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'Teacher', NULL, '081234567801', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(11, 'Ahmad Fauzan', 'ahmad.fauzan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'Teacher', NULL, '081234567802', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(12, 'Jonathan Lim', 'jonathan.lim@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'Teacher', NULL, '081234567803', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(13, 'Maria Susanti', 'maria.susanti@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'Teacher', NULL, '081234567804', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(14, 'Budi Hartono', 'budi.hartono@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'Teacher', NULL, '081234567805', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(15, 'Rina Kartika', 'rina.kartika@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '7-A', NULL, '081345678901', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(16, 'Dimas Prasetyo', 'dimas.prasetyo@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '7-B', NULL, '081345678902', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(17, 'Anisa Putri', 'anisa.putri@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '8-A', NULL, '081345678903', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(18, 'Fajar Nugroho', 'fajar.nugroho@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '8-B', NULL, '081345678904', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(19, 'Putri Handayani', 'putri.handayani@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '9-A', NULL, '081345678905', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(20, 'Rizky Saputra', 'rizky.saputra@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '9-A', NULL, '081345678906', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(21, 'Dewi Lestari', 'dewi.lestari@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '9-B', NULL, '081345678907', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(22, 'Bayu Firmansyah', 'bayu.firmansyah@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '9-B', NULL, '081345678908', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(23, 'Brian Smith', 'brian.smith@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-C', 'TKJ', '081456789001', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(24, 'Maria Gonzalez', 'maria.gonzalez@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-D', 'AKL', '081456789002', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(25, 'Daniel Park', 'daniel.park@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-D', 'BDP', '081456789003', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(26, 'Indah Permata', 'indah.permata@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-A', 'TKJ', '081456789004', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(27, 'Ryan Smith', 'ryan.smith@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-B', 'AKL', '081456789005', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(28, 'Novi Anggraini', 'novi.anggraini@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '10-A', 'BDP', '081456789006', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(29, 'Michelle Tan', 'michelle.tan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-C', 'TKJ', '081567890001', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(30, 'Aisha Khan', 'aisha.khan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-B', 'AKL', '081567890002', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(31, 'Ethan Wong', 'ethan.wong@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-C', 'BDP', '081567890003', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(32, 'Liam Chen', 'liam.chen@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-D', 'TKJ', '081567890004', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(33, 'Andi Pratama', 'andi.pratama@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-A', 'AKL', '081567890005', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(34, 'Citra Dewi', 'citra.dewi@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '11-A', 'BDP', '081567890006', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(35, 'Jonathan Lee', 'jonathan.lee@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '12-D', 'TKJ', '081678900001', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(36, 'Kevin Lee', 'kevin.lee@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '12-E', 'AKL', '081678900002', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(37, 'Julian Henderson', 'julian.henderson@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '12-E', 'BDP', '081678900003', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(38, 'Sarah Wijaya', 'sarah.wijaya@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '12-A', 'TKJ', '081678900004', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42'),
(39, 'Hendra Gunawan', 'hendra.gunawan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NULL, '12-A', 'AKL', '081678900005', 'default.png', 1, '2026-05-05 02:15:42', '2026-05-05 02:15:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_donations_activity` (`activity_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_events_date` (`date`),
  ADD KEY `idx_events_created_by` (`created_by`);

--
-- Indexes for table `event_donations`
--
ALTER TABLE `event_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_edonations_event` (`event_id`),
  ADD KEY `idx_edonations_user` (`user_id`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_participant` (`event_id`,`user_id`),
  ADD KEY `idx_participants_event` (`event_id`),
  ADD KEY `idx_participants_user` (`user_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_news_date` (`date`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_suggestions_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_donations`
--
ALTER TABLE `event_donations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_donations`
--
ALTER TABLE `event_donations`
  ADD CONSTRAINT `event_donations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_donations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
