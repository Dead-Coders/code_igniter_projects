-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2021 at 06:17 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobportalci`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `company` varchar(50) NOT NULL,
  `location` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `skills` text NOT NULL,
  `perks` text NOT NULL,
  `salary_min` int(11) NOT NULL,
  `salary_max` int(11) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `duration` enum('Full time','Part time') NOT NULL,
  `expires` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` enum('no','yes') NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `title`, `company`, `location`, `description`, `responsibilities`, `skills`, `perks`, `salary_min`, `salary_max`, `contact_email`, `duration`, `expires`, `created_by`, `deleted`, `date_created`, `date_modified`) VALUES
(1, 'Programmer Analyst- C#, VB.NET, SQL', 'ComputerBytes', 'Seattle', 'Driven by technology-enabled growth and success in business for our clients, we employ unsurpassed methodologies to establish and conquer new realms of global markets. We follow industry’s best business practices and models to deliver deadline-driven, customizable, flexible and scalable business services such as Application Development, Mobile App Development, Cloud and Branding Services.', '<ul class=\'bullets\'><li>Programming, debugging, and documenting complex software applications.</li><li>Developing and implementing web-based solutions.</li><li>Providing technical and strategic advice to Manager, Applications Development and other Broadridge Managers.</li><li>Work with the Product Management team to build project specifications.</li><li>Collaborate with the Change Management team during development to ensure quality code.</li><li>Works with manager and teammates to build accurate estimates for assigned business support and project support development tasks, delivering reliable, reusable and supportable software on time and on-budget.</li><li>Performing other duties as assigned.</li></ul>', '<ul class=\'bullets\'><li>4+ years of experience programming with C#, JavaScript, CSS, and SQL</li><li>B.S. in Computer Science / related field required</li></ul>', '<ul class=\'bullets\'><li>We provide our own working environment with desktop setups.</li></ul>', 81589, 96500, 'computerbytes@gmail.com', 'Full time', '2021-06-16', 1, 'no', '2021-06-11 00:26:26', '2021-06-14 21:16:10'),
(2, 'SQL Database Administrator', 'ComputerBytes', 'Houston', 'Purpose: The SQL Server Database Administrator role is responsible for providing operational database services to the organization.', '<ul class=\'bullets\'><li>Owning, tracking, and resolving database related incidents and requests.</li><li>Assisting developers in optimizing SQL code and stored procedures to ensure optimal SQL Server performance. Develop SSIS Packages and SSRS Reports.</li><li>Reviewing service-related reports (database backups, maintenance, monitoring) on a daily basis to ensure service-related issues are identified and resolved within established SLAs.</li><li>Responding to database related alerts and escalations and working with database engineering to come up with strategic solutions to recurring problems.</li><li>Initiating and performing changes on production systems and proactively escalating any issues that cannot be resolved within the established timeframes.</li></ul>', '<ul class=\'bullets\'><li>Associate degree plus 3 years of experience providing end-user technical support preferred; 3+ years working with Microsoft SQL Server.</li><li>Experience or training in Performance Tuning, Query Optimization, using Performance Monitor, SQL Profiler and other related monitoring and troubleshooting tools such as Sentry One;</li><li>Ability to detect and troubleshoot SQL Server related CPU,memory,I/O, disk space and other resource contention;</li><li>Working knowledge of backups, restores, recovery models, database shrink operations, DBCC commands;</li><li>Working knowledge of indexes, index management, integrity checks, configuration, patching;</li><li>Knowledge of SQL Server tools ( Profiler, DTA, SSMS, SAC, SSCM, PerfMon, DMVs, system sprocs);</li><li>SQL Development – ability to write and troubleshoot SQL Code and design ( stored procs, functions, tables, views, triggers, indexes, constraints). Ability to write SSIS packages and convert queries in SSRS Reports;</li><li>Ability to work with Infrastructure and Virtualization staff on the performance of Hardware and Virtual component across CPU, Memory and backend Storage environments to provide optimum Hardware and Operating Systems selection;</li><li>Solid acquaintance with windows server, security delegation, SPNs, storage components;</li><li>SQL Database Operational support to technical users;</li></ul>', '<ul class=\'bullets\'><li>Saturdays and Sundays Off.</li><li>We provide working environment including full desktop.</li></ul>', 101575, 149588, 'computerbytes@gmail.com', 'Full time', '2021-07-15', 1, 'no', '2021-05-27 04:29:10', '2021-06-14 21:08:27'),
(3, 'Database Administrator', 'ComputerBytes', 'Houston', 'As part of a team whose mission is to serve state government and to support safe and healthy communities throughout Oregon, you’ll close each day with a sense of purpose inherent to public service. When you become a DOJ team member, you join an agency that values loyal and enthusiastic employees by providing a competitive salary and great benefits, including excellent medical, vision, dental, pension and retirement programs. You’ll also have access to paid Sick Leave, Vacation, Personal Business Leave, and 10 paid holidays a year', '<ul class=\'bullets\'><li>Design, implement and maintain database systems to support application and business needs.</li><li>Ensure databases are properly backed up, patched, and upgraded.</li><li>Produce documentation detailing the structure and construction of data application systems including narratives, program logic, and data flow diagrams.</li><li>Conduct business analysis and research for projects involving new technologies or business processes.</li><li>Involve managers, staff, and business partners to define requirements using standard department processes.</li><li>Prepare requirements documentation, feasibility studies, and scope statements per department standards.</li><li>Perform data analysis and develop and maintain database reports to support application, business, and IS needs.</li><li>Diagnose and resolve problems and errors with data or database systems that are complex and impact business critical systems.</li><li>Coordinate with customers, other IS staff and vendors.</li><li>Understand the agency’s affirmative action goals and objectives.</li><li>Recognize the value of individual and cultural differences, create work environments where individuals’ differences are valued, and consistently treat staff, colleagues, customers and stakeholders/partners with dignity and respect.</li></ul>', '<ul class=\'bullets\'><li>Four (4) years of information systems experience that demonstrate knowledge and experience in, OR the ability to master, .NET development and programming languages and SQL Server database management (SQL Server Management Studio).</li><li>Verbal and written communication.</li><li>Communicate technical information in a way that is understandable by customers and users.</li><li>Working independently and part of a team.</li></ul>', '<ul class=\'bullets\'><li>Salary Range $4,701 - $7,109 per month with additional bonuses.</li><li>Holidays and leave hours.</li></ul>', 63120, 101200, 'computerbytes@gmail.com', 'Full time', '2021-06-30', 1, 'no', '2021-06-02 00:33:41', '2021-06-14 21:02:05'),
(4, 'Sr. Laravel Developer', 'Bluelight IT', 'Detroit', 'Looking for those who are extremely passionate about joining as a senior laravel developer.', '<ul class=\'bullets\'><li>Must have an ability to work in as a team</li><li>Must have an ability to achieve a deadline</li><li>Must have an ability to work independently from project start to end</li></ul>', '<ul class=\'bullets\'><li>Sound knowledge of Object-Oriented PHP</li><li>Sound knowledge of Laravel 5.x to 7.x</li><li>Hands-on skill on Laravel concepts (Repository/Seeders/Queues etc)</li><li>Must have an ability to write clean, understandable and testable code.</li><li>Sound knowledge to deal with Blade files</li></ul>', '<ul class=\'bullets\'><li>Flexible work hours.</li><li>We like to party every time a new product/feature is released, typically happens once in two weeks.</li></ul>', 128500, 147500, 'bluelightit@gmail.com', 'Full time', '2021-06-21', 2, 'no', '2021-06-14 00:37:43', '2021-06-14 20:51:23'),
(5, 'iOS Developer', 'InTouch Tech', 'Chicago', 'We are looking for an experienced iOS developer to join our team. We\'re a mobile design and development firm based in Denver, focused on developing and designing. we usually develop natively but also use Xamarin in occasions it is a fit. On the services side, Rails is our go-to. We use Git on nearly all of our projects.', '<ul class=\'bullets\'><li>Throughout the process, you will work collaboratively with our world-class team of engineers, partner with designers, and coordinate with other teams at Apple including the iOS, macOS, and watchOS teams.</li><li>This position requires a self-motivated engineer with strong technical and communication skills to handle responsibilities</li></ul>', '<ul class=\'bullets\'><li>Having at least 4- 5 years of experience in Objective C and Cocoa Touch platform.</li><li>Having at least 1-2 years of experience in Swift language.</li><li>Experience in Enterprise iOS Applications.</li><li>Must have knowledge and Experience in Data Structures and Algorithms.</li><li>Retail POS and eCommerce Knowledge.</li><li>Must be organized, accurate, detail-oriented, and ability to multi-task.</li></ul>', '<ul class=\'bullets\'><li>Participating in architecture and code reviews</li><li>Building internal tools as needed to help ship high quality software</li><li>Various leaves granted with reasons</li><li>REMOTE and Direct Hire opportunity</li></ul>', 86016, 102016, 'contact@intouch.com', 'Full time', '2021-06-29', 3, 'no', '2021-06-14 16:50:11', '2021-06-14 20:39:03'),
(6, 'Frontend Developer', 'Genesis IT Solutions', 'New York', 'We’re on a mission to hire the very best and are committed to creating exceptional employee experiences where everyone is respected and has access to equal opportunity. We realize that new ideas can come from everywhere in the organization, and we know the next big idea could be yours!', '<ul class=\'bullets\'><li>You get the agility of a startup and the work/life balance of an established business.</li><li>You will be working on an emerging project defining and implementing the future of content management.</li><li>As we grow, we need to ensure that our backend evolves with the rest of the product.</li></ul>', '<ul class=\'bullets\'><li>JavaScript</li><li>HTML CSS</li><li>Node.js</li><li>Angular,</li><li>React,</li><li>Git</li></ul>', '<ul class=\'bullets\'><li>Work in an agile team environment, Innovate and identify opportunities.</li><li>Develop efficient solutions that scale for millions of users</li></ul>', 119224, 149970, 'contact@genesicit.com', 'Full time', '2021-06-21', 3, 'no', '2021-06-14 18:48:42', '2021-06-14 21:17:48'),
(7, 'Flutter Developer', 'CodeBright Inc', 'San Diego', 'We are looking to hire a Flutter developer to work remotely and be responsible for creating a hybrid applications for both iOS and Android using Google’s Flutter development framework. ', '<ul class=\'bullets\'><li>An individual should have deep experience in managing full-scale production application.</li><li>Must be able to work in business hours.</li><li>Your first interview will be a video call via Zoom or Google Meetings.</li></ul>', '<ul class=\'bullets\'><li>At least 1/2 years of experience in Flutter development.</li><li>Must have built at least 2 Android and/ or iOS applications using Flutter.</li><li>Proven experience in both mobile development and API integration.</li><li>Have experience with third-party libraries and APIs including REST and graphQL.Knowledge of Location Services, Maps, and other common iOS/Android libraries.</li></ul>', '<ul class=\'bullets\'><li>There are numerous plus points which will be explained during your interviews.</li><li>Being a renowned company for the last decade, working with us will help your CV to build even more stronger.</li></ul>', 129965, 169950, 'contact@incodebrig.com', 'Full time', '2021-06-29', 4, 'no', '2021-06-14 19:04:06', '2021-06-14 19:10:32'),
(8, 'Software Eng - Python/Django/React', 'Trion Technologies', 'San Francisco', 'Our genetic screens provide actionable information, empowering women and their families to make critical and timely healthcare decisions, whether they\'re thinking about starting a family or evaluating risk for cancer.', '<ul class=\'bullets\'><li>The software you write, above all else, ensures accurate results for patients but also enables us to accomplish this goal at scale.</li><li>Because this task is not a pure software problem our team is inherently interdisciplinary.</li><li>Strong software engineering fundamentals are essential but so is the ability collaborate with our genetic counselors, scientists, laboratory directors and many other groups.</li></ul>', '<ul class=\'bullets\'><li>2+ years of software engineering in industry or academia under your belt as demonstrated by prior experience, GitHub account or personal web page.</li><li>Proficient with a high level language and web framework. We use a Python/Django/React stack.</li><li>Proficient with a relational database system. We predominantly use PostgreSQL.</li><li>Experience with Unix, Git, Docker and a cloud computing platform. We use AWS.</li></ul>', '<ul class=\'bullets\'><li>Working in a collaborative environment with folks from different professional backgrounds.</li></ul>', 115997, 175696, 'triontech@gmail.com', 'Full time', '2021-06-17', 5, 'no', '2021-06-14 19:28:07', '0000-00-00 00:00:00'),
(9, 'Junior Software Engineer', 'Cryptical Software', 'Atlanta', 'As a Junior Software Engineer on the InScribe team, you will build and enhance the user interface of the InScribe web application. You will play an active role in designing and developing APIs that front-end components leverage, and develop a solid understanding of the InScribe backend services. You’ll work remotely with our team of engineers and the product team to build and maintain customer-facing experiences and backend solutions to enable high-quality services running at scale and deliver those experiences into the hands of students and teachers.', '<ul class=\'bullets\'><li>Reading and writing code, with a focus on writing maintainable code that is easy to understand.</li><li>Collaborating with peers and product teams to define and implement new features.</li><li>Collaboratively define, scope, prioritize, and estimate work.</li><li>Making well-reasoned decisions that inspire and energize others.</li><li>Documenting the systems you help build.</li><li>Building functional UI components from design mockups.</li><li>Building scalable and highly available systems that follow operational best practices.</li></ul>', '<ul class=\'bullets\'><li>Experience with Go.</li><li>Experience with relational databases.</li><li>Experience with OOP and API design.</li><li>Familiarity with Git.</li><li>High degree of empathy.</li><li>1+ years experience with software development.</li><li>Experience with HTML, CSS, Javascript, and React.</li><li>Experience working asynchronously on a remote, distributed team.</li></ul>', '<ul class=\'bullets\'><li>Have a meaningful impact on the company’s future, and share in the rewards accordingly.</li><li>Work quickly and without red tape.</li><li>Work on a product that impacts millions of students.</li><li>Work in a fun, fast-paced, startup environment.</li><li>Receive full benefits the month after you start working</li><li>Receive ongoing training for a career in technology</li><li>Receive paid family leave.</li><li>Work from home.</li></ul>', 75000, 92500, 'cryptical@gmail.com', 'Full time', '2021-06-27', 6, 'no', '2021-06-14 19:37:30', '0000-00-00 00:00:00'),
(10, 'Part Time Web Designer', 'Hashtag Web Consultants', 'Boston', 'We are looking for a talented Part-Time Web Designer to build, manage, and evolve the design of HastagWeb\'s website. As  HastagWeb’s Web Designer, you will report directly to the Chief Marketing Officer and work closely with our Graphic Designer and other key members of our Marketing and Content teams. You are responsible for conceptualizing and executing a website redesign that will drive our audiences to action through an intuitive, functional, and on-brand digital experience.', '<ul class=\'bullets\'><li>Work within the Elementor page builder for WordPress to design and execute for the HashtagWeb\'s website.</li><li>Create landing pages for events and new initiatives, and manage updates to content as needed.</li><li>Support and collaborate with a range of internal stakeholders from Marketing, Demand Generation, and Content teams.</li><li>Collaborate with Graphic Designer to ensure brand visuals are consistent across all channels.</li><li>Be communicative and proactive to ensure deadlines are met.</li><li>Analyze and optimize website considering data indicators, SEO, and web traffic metrics</li></ul>', '<ul class=\'bullets\'><li>Minimum of 3+ years industry experience in a similar role (Experience in a Tech/SaaS environment preferred)</li><li>Understanding of web publishing requirements.</li><li>Strong foundation in UI/UX design principles.</li><li>Strong attention to detail and receptive to feedback.</li><li>Proficiency in WordPress, HTML/CSS, and Adobe Creative Suite; Experience using Elementor page builder for WordPress is preferred.</li><li>Hands on experience with SEO and web traffic metrics a plus.</li><li>Up-to-date with the latest web trends, techniques, and technologies.</li></ul>', '<ul class=\'bullets\'><li>$85/hr or based on experience.</li><li>An exciting and positive work environment where you are encouraged to develop and thrive</li></ul>', 106585, 116875, 'vacancy@hashtagw.com', 'Part time', '2021-06-18', 7, 'no', '2021-06-14 20:24:53', '0000-00-00 00:00:00'),
(11, 'Application Developer', 'Astro Applications', 'Atlanta', 'This recruitment is for multiple levels. Based on your qualifications and/or experience you will be assessed and may qualify at the Entry, Journey, or Senior/Specialist level for our Application Development team. If selected, you may be offered at any level you qualify.', '<ul class=\'bullets\'><li>In these Application Developer roles, you will have increasing responsibility based on your level of expertise.</li><li>Your technical knowledge and skill will support the Unemployment Tax and Benefits (UTAB) system and related interfaces.</li><li>You will be relied upon to design, develop, solicit, analyze, and document business requests, prepare prototypes for solutions, write code, and configure features in GenTax.</li><li>As you perform and participate in gathering and discovering requirements for system changes, you will adhere to ESD’s software development and project management methodologies.</li></ul>', '<ul class=\'bullets\'><li>Bachelor\'s Degree in Computer Science or closely related field.</li><li>OR Four (4) years of IT experience with:Service-oriented design and development using C#, VB.Net and SQL.</li><li>Demonstrated testing skills that may include unit testing, requirements testing, user testing, load testing, functional, performance/load testing and regression testing.</li><li>Continuous development of skills related to new tools and techniques related to application development, maintenance, and support.</li><li>Experience with Fast Enterprises’ GenTax solution.</li><li>Final external candidates must be able to pass the Unemployment Insurance (UI) Fraud Check.</li><li>Internet service with speeds of 10mbps download and 2MB upload. To test your internet speed please go to www.speedtest.net.</li></ul>', '<ul class=\'bullets\'><li>Benefits (insurance, retirement, and related benefits)</li><li>Vacation, Leave, and Holidays</li><li>Special Programs (additional benefits)</li></ul>', 72000, 115176, 'astroapps@gmail.com', 'Full time', '2021-06-19', 8, 'no', '2021-06-14 20:32:05', '0000-00-00 00:00:00'),
(12, 'Software Developer', 'Marcell Technology', 'Nashville', 'The software developer codes, tests, debugs, documents, and maintains programs utilizing programming languages and an understanding of how data is related across multiple databases, tables, and platforms. This position communicates and collaborates with other Information Technology (IT) staff on application programming.', '<ul class=\'bullets\'><li>Makes basic modifications to application programs from detailed specifications.</li><li>Tackles specific tasks, smaller pieces, or routine task which may be associated with a larger-scale IT solution delivery projects.</li><li>Modifies or expands coding to eliminate errors or malfunctions which impact the production of usability of the technology solution.</li></ul>', '<ul class=\'bullets\'><li>1 Year or IT, programming, software development, help desk or related experience.</li><li>Basic level technical/professional level knowledge and skills.</li><li>Able to communicate to others when working on application programming.</li><li>Basic level collaboration, problem solving/resolution, prioritization/organization</li></ul>', '<ul class=\'bullets\'><li>Employee resource groups</li><li>Parental Leave</li><li>Internal Resources</li><li>And much more</li></ul>', 61602, 97228, 'contact@marcelltech.com', 'Full time', '2021-06-30', 9, 'no', '2021-06-14 21:42:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `name`, `date_created`, `date_modified`) VALUES
(1, 'computerbytes@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'ComputerBytes', '2021-03-08 00:34:51', '0000-00-00 00:00:00'),
(2, 'bluelightit@gmail.com', 'f085c76d7ddfef25a703190dca364687', 'Bluelight IT', '2021-05-13 00:42:20', '0000-00-00 00:00:00'),
(3, 'intouch@gmail.com', 'f085c76d7ddfef25a703190dca364687', 'InTouch Tech', '2021-06-14 16:49:29', '0000-00-00 00:00:00'),
(4, 'codebrightinc@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Code Bright', '2021-06-14 18:58:04', '0000-00-00 00:00:00'),
(5, 'triontech@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Trion Technologies', '2021-06-14 19:22:22', '0000-00-00 00:00:00'),
(6, 'cryptical@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Cryptical Software', '2021-06-14 19:32:09', '0000-00-00 00:00:00'),
(7, 'hashtagweb@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Hashtag Web', '2021-06-14 19:38:33', '0000-00-00 00:00:00'),
(8, 'astroapp@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Astro Applications', '2021-06-14 20:26:21', '0000-00-00 00:00:00'),
(9, 'marcelltech@gmail.com', '696d29e0940a4957748fe3fc9efd22a3', 'Marcell Technology', '2021-06-14 21:35:09', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
