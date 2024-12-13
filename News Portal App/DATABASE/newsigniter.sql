-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2021 at 09:21 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `album_name` varchar(100) NOT NULL,
  `album_seo` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `album_name`, `album_seo`, `photo`, `is_active`) VALUES
(17, 'Album 1', 'album-1', 'album-1-1581343722711.jpg', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `photo`) VALUES
(5, 'Home', '999a6fae9968a1b4ef9c498c502c0d83.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `slug`, `is_active`) VALUES
(6, 'Technology', 'technology', 'Y'),
(7, 'Gaming', 'gaming', 'Y'),
(8, 'Movie', 'movie', 'Y'),
(10, 'Science', 'science', 'Y'),
(11, 'Health', 'health', 'Y'),
(12, 'Finance', 'finance', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `contact_name`, `description`) VALUES
(1, 'About Me', 'Online news and article portal project, which aims to help programmers understand in the creation of projects as well as mastery of programming languages, libraries and frameworks.');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `id_album` int(11) NOT NULL,
  `gallery_name` varchar(100) NOT NULL,
  `gallery_seo` varchar(100) NOT NULL,
  `information` text NOT NULL,
  `photo` varchar(100) NOT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `id_album`, `gallery_name`, `gallery_seo`, `information`, `photo`, `is_active`) VALUES
(9, 17, 'Galeri 2', 'galeri-2', 'LIfe is Strange', 'galeri-2-15815614412.jpg', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `identity`
--

CREATE TABLE `identity` (
  `id` int(11) NOT NULL,
  `web_name` varchar(255) NOT NULL,
  `web_address` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identity`
--

INSERT INTO `identity` (`id`, `web_name`, `web_address`, `meta_description`, `meta_keyword`, `photo`) VALUES
(1, 'newsportaligniter.com', 'newsportaligniter.com', 'Latest Indonesia and World News Today, the Latest Most Complete Daily News Regarding Politics, Economy, Travel, Technology, Automotive, ...', 'Newsportaligniter.com', 'c551664b65bad27d6b56ac71bfdd016f.png');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 'Setting Web', '', 'fas fa-fw fa-cog', 'Y'),
(2, 'Menu Setting', '', 'fas fa-fw fa-sliders-h', 'Y'),
(3, 'Article Management', '', 'fas fa-fw fa-newspaper', 'Y'),
(4, 'Media', '', 'fas fa-fw fa-photo-video', 'Y'),
(5, 'Visit Site', 'home', 'fas fa-fw fa-home', 'Y'),
(6, 'Logout', 'auth/logout', 'fa fa-power-off', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE `posting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `featured` char(1) NOT NULL,
  `choice` char(1) NOT NULL,
  `thread` char(1) NOT NULL,
  `id_category` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `is_active` char(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posting`
--

INSERT INTO `posting` (`id`, `title`, `seo_title`, `content`, `featured`, `choice`, `thread`, `id_category`, `photo`, `is_active`, `date`) VALUES
(69, 'New MacBook Pro 13-inch spotted with 10th-generation Ice Lake', 'new-macbook-pro-13-inch-spotted-with-10th-generation-ice-lake', '<p>It looks like Apple has plans to give the MacBook Pro 13-inch a \r\nconsiderable power boost in 2020. And, it’s about darn time, especially \r\nsince 8th-generation Intel Core processors are aging at this point, \r\nespecially on a premium laptop.</p><p>A <a href=\"https://twitter.com/_rogame/status/1228636786517270529?s=20\" target=\"_blank\" class=\"hawk-link-parsed\"><u>3DMark Time Spy benchmark</u></a>, recently leaked by <a href=\"https://twitter.com/_rogame\" target=\"_blank\" class=\"hawk-link-parsed\"><u>@_rogame</u></a>\r\n on Twitter, shows a new 13-inch MacBook Pro boasting marked performance\r\n improvements over 2019’s second highest configuration. If you’re not \r\nfamiliar with this serial leaker, he was responsible for uncovering a <a href=\"https://www.reddit.com/r/Amd/comments/dvq3xx/16_macbook_pro_with_an_rx_5500m_8gb/\" target=\"_blank\" class=\"hawk-link-parsed\"><u>Geekbench 4 benchmark</u></a>\r\n of the 16-inch MacBook Pro boasting the Radeon 5500M graphics card \r\nbefore it came out. So, you know this is coming from a reliable source.</p><aside class=\"hawk-widget\" data-render-type=\"fte\" data-widget-type=\"seasonal\"></aside><p>The\r\n unreleased 13-inch MacBook Pro model is fitted with an Intel Core \r\ni7-1068NG7 processor with a 2.3GHz base clock, Turbo Boost up to 4.1GHz \r\nclocks and a TDP of 28W. Based on an <a href=\"https://twitter.com/_rogame/status/1228628173509857280?s=20\" target=\"_blank\" class=\"hawk-link-parsed\"><u>earlier tweet</u></a>, it also boasts 32GB of memory and 2TB of storage (SSD).</p><p>It’s worth noting that the i7-1068NG7 could be a variant of the i7-1068G7, which <a href=\"https://wccftech.com/2020-macbook-pro-13-vs-predecessor-benchmark-leak-shows-30-gpu-lead/\" target=\"_blank\" class=\"hawk-link-parsed\"><u>Wccftech.com</u></a> praises as the best performing mobile chip in the Ice Lake U family. <br></p>', 'Y', 'N', 'Y', 6, '1c9ed66e86d7f2edff5ea376dba2f5b0.jpg', 'Y', '2020-02-23'),
(72, 'Nintendo Switch Pro: what we want to see from a new Switch console', 'nintendo-switch-pro-what-we-want-to-see-from-a-new-switch-console', '<p>Rumors have been circling for a while now that a Nintendo Switch Pro \r\nis in the works. However, contrary to belief, a Switch Pro certainly \r\nwon\'t be releasing this year as Nintendo has officially confirmed that a\r\n new Switch isn\'t coming in 2020.</p><p>But that\'s not to say we won\'t see a new Nintendo Switch in the future.</p><aside class=\"hawk-widget\" data-render-type=\"fte\" data-widget-type=\"seasonal\"></aside><p>While we technically seen two new Switch devices release in 2019 - the Switch with longer battery and the handheld <a href=\"https://www.techradar.com/reviews/nintendo-switch-lite-review\" data-original-url=\"https://www.techradar.com/uk/news/nintendo-switch-lite-release-date-price-games-and-more\" class=\"hawk-link-parsed\">Nintendo Switch Lite</a> - we\'re still expecting Nintendo to have another, more premium, Switch up its sleeve. </p><p>This new Switch (or Switch Pro) would boast upgraded hardware in comparison to the original <a href=\"https://www.techradar.com/reviews/nintendo-switch\" class=\"hawk-link-parsed\">Nintendo Switch</a>, potentially offering better graphics and processing power, among other improved features - although it\'s been suggested this <a href=\"https://www.techradar.com/news/the-latest-nintendo-switch-pro-rumors-are-pretty-disappointing\" class=\"hawk-link-parsed\">upgrade won\'t be as extensive as we\'d like to see</a>.</p><p>With Nintendo not even confirming the existence of a Switch Pro, and the\r\n company ruling out a 2020 release for any new Switch, when would be a \r\nlikely release window? And, if the rumors <em>are</em> true, what \r\nfeatures would this new Switch likely offer? While we wait for more \r\ndefinitive answers, let\'s run through the likely (and unlikely) \r\npossibilities below.</p>', 'N', 'Y', 'Y', 6, '91c9893cd2a1f8284c883b3b04775b90.jpg', 'Y', '2020-02-23'),
(73, 'The Last of Us 2 release date, trailers, news and rumors', 'the-last-of-us-2-release-date-trailers-news-and-rumors', '<p>There are only a few months left to wait until we can all finally get our hands on The Last of Us 2 - and we\'re getting excited.</p><p>The\r\n ending of The Last of Us was pretty conclusive. But as it turns out, \r\nthat hasn\'t stopped developer Naughty Dog from cranking out a sequel in \r\nthe form of The Last of Us 2 – or, The Last of Us: Part 2 if we\'re using\r\n its proper name. </p><aside class=\"hawk-widget\" data-render-type=\"fte\" data-widget-type=\"seasonal\"></aside><p>Given\r\n the first game was hailed by players and critics alike as a masterpiece\r\n with excellent, emotional storytelling and engaging, realistic \r\ncharacters, we have to admit that the decision to release a follow-up \r\nisn\'t particularly shocking. We\'d probably have been more surprised if \r\nthere <em>wasn\'t</em> one. And yet, when The Last of Us 2 was first announced, we\'d be lying if we said our hearts didn\'t skip a beat. </p><p>The\r\n Last of Us 2 was first announced by Naughty Dog at PlayStation \r\nExperience in 2016 alongside a teaser trailer, but it wasn\'t until \r\nSeptember 2019 that we were finally told the game\'s initial release date\r\n of February 2020 during a State of Play livestream. However, Naughty \r\nDog later announced that the release date has been delayed by a few \r\nmonths, and we now know we\'ll be joining Ellie and Joel again in May \r\n2020. <br></p>', 'N', 'Y', 'N', 7, 'dcc5f464a60adebca40c21ec9be5ec26.jpg', 'Y', '2020-02-23'),
(74, 'Ben Affleck Thinks Robert Pattinson is Going to Be a Great Batman', 'ben-affleck-thinks-robert-pattinson-is-going-to-be-a-great-batman', '<p>Former Batman Ben Affleck is sharing his support for his successor in \r\nthe role, Robert Pattinson, who will play the Caped Crusader in next \r\nyear\'s <a href=\"https://screenrant.com/tag/the-batman/\"><strong><em>The Batman</em></strong></a>. Starting with 2016\'s <a href=\"https://screenrant.com/tag/batman-v-superman/\"><em>Batman v. Superman: Dawn of Justice</em></a>,\r\n Affleck was the fifth actor to play Batman in a live-action film, and \r\nhe appeared in three movies total (which includes a small cameo in <a href=\"https://screenrant.com/tag/suicide-squad/\"><em>Suicide Squad</em></a>). Affleck was reportedly going to direct, write, and star in <em>The Batman, </em>but\r\n reports later emerged suggesting someone new would take over the role. \r\nAffleck later departed the project, and Matt Reeves signed on to write \r\nand direct with Pattinson filling the role of Bruce Wayne.</p><p>Production on <em>The Batman </em>has been underway for a little while now, and recently Reeves unveiled the <a href=\"https://screenrant.com/batman-robert-pattinson-costume-bat-suit-reveal-video/\">first official look of Pattinson in costume</a>.\r\n Excitement for the 2021 film has only been building as production has \r\ncontinued, especially due to its large cast. Aside from Pattinson, <em>The Batman </em>will star <a href=\"https://screenrant.com/batman-movie-catwoman-costume-zoe-kravitz-photos-motorcycle/\">Zoë Kravitz</a>, Colin Farrell, Jeffrey Wright, Paul Dano, Andy Serkis, <a href=\"https://www.cbr.com/the-batman-peter-sarsgaard-jayme-lawson-roles/\" target=\"_blank\" rel=\"noopener noreferrer\">Peter Sarsgaard</a>, and John Turturro.</p><p>While promoting his new film <em><a href=\"https://screenrant.com/tag/the-way-back/\">The Way Back</a> </em>in an interview with <a href=\"https://www.youtube.com/watch?v=5oYrYpn4bIc\" target=\"_blank\" rel=\"noopener noreferrer\">Jake Hamilton</a>, Affleck was briefly asked about his time as Batman as well as the initial script he wrote for <em>The Batman</em>. Affleck was quick to share some words of support for Pattinson, saying, \"<em>I think Robert\'s a great actor, he\'s going to do great</em>.\" Affleck also opened up a bit more about why he chose to leave, explaining that he had \"<em>kind of lost my passion for it</em>.\" He added, \"<em>The movie deserves to be made by someone whose dying to do it and can\'t wait, and that wasn\'t me at the time, so I moved on</em>.\"</p><p>Recently, Affleck elaborated on his departure from <em>The Batman</em>\r\n in a more candid manner than he had previously. Whereas before, it \r\nseemed like creative differences led to his exit, Affleck admitted that \r\nit was a more personal reason. Affleck explained, \"<em>I showed somebody\r\n ‘The Batman’ script. They said, ‘I think the script is good. I also \r\nthink you’ll drink yourself to death if you go through what you just \r\nwent though again</em>.\" It seems that the <a href=\"https://screenrant.com/ben-affleck-batman-exit-justice-league-reshoots-drama-rehab/\">process behind making and promoting 2017\'s <em>Justice League</em></a>\r\n effectively diminished his interest in playing Batman, which isn\'t too \r\nsurprising considering that film\'s troubled production history. <a href=\"https://screenrant.com/ben-afflecks-addiction-rehab-statement/\">Affleck\'s struggles with alcoholism</a> reportedly added to his stress.</p>\r\n<p>Affleck\'s recent comments, including the ones in support of \r\nPattinson, suggest he\'s made some peace with his rocky tenure as Batman.\r\n Of course, it\'s impossible to say for sure without being inside of his \r\nhead, but it\'s a bit of a relief to know that he has moved onto projects\r\n he feels more passionate about. Affleck\'s Batman, while perhaps not as \r\nbeloved as say Michael Keaton\'s or Christian Bale\'s, was a solid take on\r\n the well-known character, and it would have been interesting to see \r\nwhat his version of <em><strong>The Batman</strong> </em>would have \r\nbeen. Instead though, fans will get the chance to see a new actor take \r\non the role, and only time will tell if they enjoy it or not.</p>', 'N', 'N', 'N', 8, '0bd7bd67d3784eb4a9be9ef50510274a.jpg', 'Y', '2020-02-24'),
(75, 'Apple shares drop amid reports of low demand for iPhone X', 'apple-shares-drop-amid-reports-of-low-demand-for-iphone-x', '<p>BEIJING/SAN FRANCISCO, Dec 26 (Reuters) – Shares in <a href=\"http://www.globalnews.ca/tag/apple\" target=\"_blank\" rel=\"noopener\">Apple Inc</a>\r\n and several of its Asian suppliers fell on Tuesday after a report by \r\nTaiwan’s Economic Daily and comments from some analysts suggested <a href=\"http://www.globalnews.ca/tag/iphone-x\" target=\"_blank\" rel=\"noopener\">iPhone X</a> demand could come in below expectations in the first quarter.</p><p>Apple\r\n will slash its sales forecast for the iPhone X in the quarter to 30 \r\nmillion units, the newspaper said on Monday, citing unidentified \r\nsources, down from what it said was an initial plan of 50 million units.</p><p>Apple\r\n has not publicly disclosed quarterly sales targets for the iPhone X, \r\nwhich went on sale in November at a base price of $999 in the United \r\nStates. An Apple spokeswoman said the company does not comment on market\r\n rumors.</p><p>Shares of Apple surged 45 percent this year before the iPhone X launch \r\nas investors anticipated interest from iPhone users who had gone years \r\nsince buying a new one.</p><p>Shares of Apple have edged slightly lower since the iPhone X debut. They fell 2.5 percent to $170.57 on Tuesday.</p><p>During\r\n a trip to China this month Apple Chief Executive Tim Cook said he \r\n“couldn’t be happier” with the demand for the iPhone X in the country. \r\nThe company also had described pre-orders for iPhone X as “off the \r\ncharts.”</p> \r\n  \r\n  \r\n <h3>Varying estimates</h3><p>Estimates of how many of the new phones Apple is making, and how many it will sell, vary widely.</p>', 'N', 'Y', 'N', 6, '0806ef39ec267c04b99a51a88129327a.jpg', 'Y', '2020-02-24'),
(81, 'The Walking Dead Seasson 10', 'the-walking-dead-seasson-10', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do \r\neiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad \r\nminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip \r\nex ea commodo consequat. Duis aute irure dolor in reprehenderit in \r\nvoluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in culpa qui officia deserunt\r\n mollit anim id est laborum.\"</p><p>\"Sed\r\n ut perspiciatis unde omnis iste natus error sit voluptatem accusantium \r\ndoloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo \r\ninventore veritatis et quasi architecto beatae vitae dicta sunt \r\nexplicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut \r\nodit aut fugit, sed quia consequuntur magni dolores eos qui ratione \r\nvoluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum \r\nquia dolor sit amet, consectetur, adipisci velit, sed quia non numquam \r\neius modi tempora incidunt ut labore et dolore magnam aliquam quaerat \r\nvoluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam \r\ncorporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?\r\n Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse \r\nquam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo \r\nvoluptas nulla pariatur?\"</p>\r\n\r\n<p>\"But I must explain to you how all this mistaken idea of denouncing \r\npleasure and praising pain was born and I will give you a complete \r\naccount of the system, and expound the actual teachings of the great \r\nexplorer of the truth, the master-builder of human happiness. No one \r\nrejects, dislikes, or avoids pleasure itself, because it is pleasure, \r\nbut because those who do not know how to pursue pleasure rationally \r\nencounter consequences that are extremely painful. Nor again is there \r\nanyone who loves or pursues or desires to obtain pain of itself, because\r\n it is pain, but because occasionally circumstances occur in which toil \r\nand pain can procure him some great pleasure. To take a trivial example,\r\n which of us ever undertakes laborious physical exercise, except to \r\nobtain some advantage from it? But who has any right to find fault with a\r\n man who chooses to enjoy a pleasure that has no annoying consequences, \r\nor one who avoids a pain that produces no resultant pleasure?\"</p>', 'N', 'N', 'N', 8, 'd1b6077499ecdfa48be70dee1242f8d6.jpg', 'Y', '2020-02-24'),
(87, 'Assasin\'s Creed Valhalla', 'assasin-s-creed-valhalla', '<p><strong xss=removed>Lorem Ipsum</strong><span xss=removed> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>', 'N', 'N', 'N', 7, '2dbd28ddf26159d8c71232097b85136d.jpg', 'Y', '2020-08-13'),
(88, 'WandaVision Star Kathryn Hahn Receives High Praise From Ant-Man Actor Paul Rudd', 'wandavision-star-kathryn-hahn-receives-high-praise-from-ant-man-actor-paul-rudd', 'Not only is Kathryn Hahn a runaway favorite amongst fans, but the WandaVision star is also beloved by those in the Marvel Cinematic Universe. In fact, Paul Rudd thinks Hahn is the only person on the planet that could play Agatha Harkness, taking to a recent Vanity Fair piece to applaud his Marvel costar.\r\n\r\n“Kathryn is often not only the best person for the part, but also the best person on the set. Her personality is so joyous. With no attitude,” Rudd told the magazine. “Kathryn goes for it in everything.”\r\n\r\nShortly after making those comments, Rudd made sure to point out he\'s watched all of WandaVision and hasn\'t been able to stop thinking about how good Hahn was in Marvel Studios\' introductory television series. \"I mean, my God, who else could do what she did? She does that crazy witch cackle, and you buy it,\" Rudd added. \"You know how hard it is to do a crazy witch cackle?”\r\n\r\nUnlike other Marvel villains, Hahn\'s Harkness is still alive and well in Westview. As seen in the Disney+ show, Wanda Maximoff (Elizabeth Olsen) locked the witch in a modern-day version of herself, unable to use her magic.\r\n\r\n\"I actually don’t think, ultimately, that she minds it,\" Hahn previously told the New York Times. \"She needed to rest for a hot second. She’s been very restless. I think she was very lonely, for a very, very long time. She loves having the companionship — loves the mailman, loves Ralph, loves Dottie. For the moment, I think she’s actually OK to just loosen the corset and sit and have a muffin and a latte.\"\r\n\r\nIn that same piece, Hahn wouldn\'t reveal if she\'s onboard for more Marvel projects just quite yet.\r\n\r\n\"I have no idea. They keep it really tight,\" she said about the planning at Marvel Studios. \"Oh me too. I want to [have an another opportunity.] Now that I have a tase of it, I\'m like \'Ahh.\' I really, really love it.\"', 'Y', 'Y', 'Y', 8, '11b29ec64ad1819fbb29251375e9c8a6.jpeg', 'Y', '2021-05-22'),
(89, 'Why the James Bond Franchise Complicates Amazon’s Talks to Acquire MGM', 'why-the-james-bond-franchise-complicates-amazon-s-talks-to-acquire-mgm', 'Industry executives are stunned that Amazon is in negotiations to buy Metro-Goldwyn-Mayer in a deal that could reach $9 billion. Their shock comes from a belief that the price tag severely overvalues the studio behind James Bond, the Pink Panther and “Legally Blonde.”\r\n\r\nOther companies have kicked the tires on MGM at various points during a stop-and-start sales process that has been dragging on for months. Industry insiders say that the true value of the studio is more in the $5 billion to $6 billion range along with the assumption of some debt. Even then, they are skeptical that MGM’s prize asset, its stake in the 007 franchise, can be properly monetized.\r\n\r\nThat’s because of the unprecedented creative control that’s held by Eon Productions and its owner the Broccoli family, who have been stewards of the film series dating back to Bond’s first on-screen appearance in 1962’s “Dr. No.” Under a deal first hammered out by Albert “Cubby” Broccoli, MGM has the right to finance and distribute all of the Bond movies and splits the profits with EON. However, Broccoli’s heirs and Eon’s chiefs, Barbara Broccoli and her half-brother Michael G. Wilson, still have final say on everything from the film’s marketing and distribution plans to whoever will slip into Bond’s tuxedo when Daniel Craig hangs up the role.\r\n\r\nInsiders believe that Broccoli and Wilson would likely nix any plans to debut Bond films on Amazon’s streaming service Prime Video and would insist on a theatrical release, as is their contractual right. That was a key stumbling block when MGM briefly floated the possibility of selling the COVID-delayed Bond sequel “No Time to Die” to Apple for north of $600 million. The producers have also been resistant to have Bond pop up in spinoffs or television shows, the kinds of ancillary properties that could prove highly lucrative. Moreover, the films have been heavily licensed to cable networks and streaming platforms, which could complicate matters.\r\n\r\n“If Barbara isn’t on board with this, things could be very difficult,” says an executive who has worked on Bond films.\r\n\r\nMoreover, the franchise is in transition. Craig is leaving the role after five films and there is real concern that his hard-living womanizer character may not have as much resonance with younger generations. That’s problematic given that much of the value of MGM is banked on Bond continuing to seduce audiences for years to come.\r\n\r\nBut MGM’s brass appears to be undeterred. Two weeks ago, Michael De Luca, chairman of the company’s motion picture group, and other executives made a formal presentation to Amazon. The PowerPoint was viewed by Mike Hopkins, senior VP of Amazon Studios and Prime Video, who is an advocate for the deal. One person in the know said the parties are in an exclusive negotiating window.\r\n\r\nRepresentatives from Amazon and MGM did not immediately respond to requests for comment.\r\n\r\nOther companies have been down this road with MGM before only for talks to collapse. MGM was talking to Apple in early 2020 before COVID upended the landscape, and other legacy studios took a look at the company.', 'Y', 'Y', 'Y', 8, '310bb8f1204b8ed665b92c1a21dafd28.jpg', 'Y', '2021-05-22'),
(90, 'Tinder tweak urges people to think before sending abuse', 'tinder-tweak-urges-people-to-think-before-sending-abuse', 'Dating app Tinder will detect abusive messages and ask the writer to stop and think before sending them, in an effort to tackle harassment.\r\n\r\nThe automated system will learn to detect \"harmful language\" from messages reported by users.\r\n\r\nTinder said the \"Are you sure?\" system had \"reduced inappropriate language in messages sent\" in trials by about 10%.\r\n\r\nInstagram and Twitter already use similar systems to detect abusive comments and tweets.\r\n\r\nInstagram asks users \"are you sure you want to post this?\" if its systems spot bullying or harassment in photo comments.\r\n\r\nEarlier in May, Twitter said it would start asking people to review their tweets before posting if they contained \"harmful or offensive\" language.\r\n\r\nTinder already asks people receiving messages in which it has detected an abusive phrase: \"Does this bother you?\"\r\n\r\nBut the new system will ask the writer to reconsider before the message is sent.\r\n\r\nThe dating app said members who saw the warning during its trial were \"less likely to be reported for inappropriate messages over the next month\".\r\n\r\nIf you thought social media could be toxic, wait until you see what happens on dating apps.\r\n\r\nSocial media is full of people sharing some of the harassing and sexually explicit messages they have received from strangers on Tinder.\r\n\r\nUnbelievably, people sometimes \"match\" with others just to send them abuse.\r\n\r\nTinder\'s experiment demonstrated that asking people to stop and think reduced the amount of harassing messages by 10%.\r\n\r\nBut that means 90% of them were still slipping through the net.\r\n\r\nWhat is it about dating apps that fosters this toxicity?\r\n\r\nPerhaps pitting people against one another in an \"attractiveness Hunger Games\", based on their photographs, is part of the problem.\r\n\r\nBut that is a lucrative game for Tinder, which charges £116 a year for unlimited swiping of its \"top picks\" - an algorithmically curated list of the most in-demand members on the app.', 'Y', 'Y', 'Y', 6, '4af05f808861f9381fc39522a6bcd2e0.jpg', 'Y', '2021-05-22'),
(91, 'Twitter will finally verify more accounts: How to get the blue check', 'twitter-will-finally-verify-more-accounts-how-to-get-the-blue-check', 'Twitter users itching to get verified on the social media site can soon apply for the coveted blue badge.\r\n\r\nIn 2017, Twitter paused public submissions for verification amid confusion about what the blue check mark next to a person\'s profile meant. The decision came after the company drew flack for verifying the account of a white supremacist. It later pulled the badge.\r\n\r\nSome view the badge as a status symbol. Others see it as a sign that Twitter had endorsed certain accounts, which wasn\'t the company\'s intention. \r\n\r\nBlue check marks remain rare. About 360,000 accounts are verified. That\'s just 0.2% of Twitter\'s 199 million monetizable daily active users.\r\n\r\nOn Thursday, Twitter announced that it will reopen applications for verification to the public over the next few weeks. To get the blue badge, you\'ll have to make the case that your account is \"notable, authentic and active.\"', 'Y', 'Y', 'Y', 6, '64d99be53283555cbc4c273df318b35c.jpg', 'Y', '2021-05-22'),
(92, 'Snapchat\'s new full AR glasses can map 3D effects onto the world', 'snapchat-s-new-full-ar-glasses-can-map-3d-effects-onto-the-world', 'After three versions of Snapchat Spectacles, the social media company has a new pair coming that are real AR glasses. The news was announced at Snapchat\'s developer-focused keynote Thursday. But while these glasses can display 3D effects onto the real world, are wireless, and have hand tracking, these new glasses are currently aimed specifically at developers and creators who want to use these to explore AR creation on headsets. No price is listed for them, and they\'re only available by application.\r\n\r\nSnapchat has promised it\'s working on a full-featured pair of augmented reality glasses for a while. It\'s one of many companies including Facebook, Niantic, and Qualcomm that are trying to crack the idea of everyday smart glasses. Snap\'s previous versions of Spectacles were focused on being mainly wearable camera-glasses. Last year\'s Spectacles 3 could layer glasses footage with 3D AR effects, but the AR needed to be seen and shared via a phone app; the glasses didn\'t have their own displays.\r\nThe glasses promise 2,000 nits of brightness, have a 26.3-inch diagonal field of view and dual waveguide displays. They have a touchpad control on the side, and look like thick sunglasses. They use a \"Snap Spatial Engine\" and have hand-tracking, can track the world with six degrees of freedom, and weigh 134 grams (4.7 ounces), according to Snapchat. \r\n\r\nAnother interesting feature: They\'re wireless, something other AR glasses this size haven\'t achieved yet. But there are tradeoffs, too. The glasses only last for 30 minutes on a charge, according to Snapchat\'s specs, and have a limited 480x564-pixel resolution for each eye. The glasses have their own charging case (and it sounds like you\'ll need it). ', 'Y', 'N', 'Y', 6, 'dec67c60a4a8480884c509d3226a5b19.jpg', 'Y', '2021-05-22'),
(93, 'Europe plans sat-nav and telecoms network at the Moon', 'europe-plans-sat-nav-and-telecoms-network-at-the-moon', 'The European Space Agency is proposing a precise navigation system at the Moon, much like the sat-nav technology we have here on Earth.\r\n\r\nIt would enable spacecraft and astronauts to know exactly where they are when moving around the lunar body and to land with precision.\r\n\r\nThe initiative, known as Moonlight, would also incorporate a telecommunications function.\r\n\r\nA large flotilla of lunar missions will be launched this decade.\r\n\r\nChief among them will be the US space agency-led successor to Apollo. Called Project Artemis, this will put crews on the Moon for the first time in more than 50 years.\r\n\r\n\"We are entering a new phase - the systematic exploration of our \'eighth continent\', the Moon,\" said David Parker, the director of human and robotic exploration at Esa.\r\n\r\n\"The Moon is a repository of 4.5 billion years of Solar System history, but we\'ve hardly begun to unlock its secrets. And so Moonlight is something that we see as really exciting, as a necessary infrastructure to support sustained exploration.\"\r\n\r\nEsa is asking two industrial consortia in Europe to define what an integrated sat-nav and telecoms system at the Moon would look like.\r\n\r\nIt\'ll include a constellation of at least three, but probably more, positioning-and-relay satellites to give global coverage, and will likely include some surface beacons, too, to augment the accuracy of the navigation signals.\r\n\r\n\"The target we have at the moment is that the constellation would be able to allow for an accuracy of 100m and probably better. We think we are able to get to 30m in the first instance,\" explained Paul Verhoef, the director of Esa\'s navigation department.\r\n\r\nMoonlight is just at the feasibility stage at the moment - what is known in industry-speak as a Phase A/B1 study.\r\n\r\nThe consortia will put their thinking on the technologies required in reports to Esa, who will then produce a defined and costed proposal to go before Europe\'s research ministers when they gather for their triennial council meeting next year.\r\n\r\nOne consortium will be led by the UK small satellite manufacturer, Surrey Satellite Technology Limited. SSTL assembled the navigation payloads on the European Union\'s Galileo sat-nav system.', 'Y', 'Y', 'Y', 10, '5b9bda3902adff1bb8bc02dd4712b665.jpg', 'Y', '2021-05-22'),
(94, 'Covid: Australia\'s vaccine hesitancy worries medical experts', 'covid-australia-s-vaccine-hesitancy-worries-medical-experts', 'Australia\'s troubled vaccine rollout has hit a potential new stumbling block - rising vaccine hesitancy.\r\n\r\nThis week a survey suggested about one-third of Australians said they were unlikely to get vaccinated, reportedly up from previous months.\r\n\r\nThe caution mostly centres around side effects and a lack of urgency given Australia\'s low infection rates.\r\n\r\nBut hesitancy threatens to frustrate plans to open its borders, which are slated to remain shut until mid-2022.\r\n\r\nThe country of nearly 26 million people has managed to stave off major outbreaks through strict border and quarantine controls, and by periodically enforcing snap lockdowns.\r\n\r\nAustralia is one of the few places in the world where there is no widespread community transmission of Covid.\r\n\r\nBut it is also one of the slowest in the developed world to immunise its population.\r\n\r\nWhile the pace of the rollout has picked up in recent weeks - reaching daily records - concern about vaccine hesitancy in some pockets of the community has began to increase.', 'Y', 'Y', 'Y', 11, '6059f47ec2c6678d24f4bec94dc709f2.jpg', 'Y', '2021-05-22'),
(95, 'The Definitive Story of How Marvel Studios Created the Marvel Cinematic Universe', 'the-definitive-story-of-how-marvel-studios-created-the-marvel-cinematic-universe', 'Get your first look at The Story of Marvel Studios: The Making of the Marvel Cinematic Universe from Abrams Books! This must-have collection is the first and only authorized book to give you an exclusive behind-the-scenes look at the creation of the MCU, as told by the studio\'s creatives, and the cast and crew of The Infinity Saga.\r\n\r\nThis definitive story is available wherever books are sold on October 19, 2021. You can pre-order it now!\r\n\r\nThe Story of Marvel Studios is the first-ever, fully authorized, all-access history of Marvel Studios’ creation of the Marvel Cinematic Universe, as told by the producers, writers, directors, concept artists, VFX artists, cast, and crew who brought it to life. Year-by-year, project-by-project, the studio’s founding and meteoric growth are described through detailed personal stories, anecdotes, and remembrances of noteworthy challenges, breakthrough milestones, and history-making successes.\r\n\r\nTogether, these stories reveal how each of the films evolved into one ongoing cinematic narrative, as coauthors Tara Bennett and Paul Terry chart the complete production history of The Infinity Saga’s 23 movies (from 2008’s Iron Man all the way up to, and including, 2019’s Avengers: Endgame and Spider-Man: Far From Home). Bennett and Terry were granted unprecedented access to Marvel Studios, which led to this years-in-the-making tome containing personal stories from more than 200 interviews, including every Marvel Studios producer; MCU writers and directors; the stars of The Infinity Saga; concept artists, costume designers, composers, and the talents behind the MCU’s dazzling visual effects; and more. Featuring previously unpublished behind-the-scenes photography and archival production material, as well as personal photos and memorabilia from cast and crew, The Story of Marvel Studios is the essential, collectible chronicle of how the Marvel Cinematic Universe was brought to life.', 'Y', 'N', 'Y', 8, '5650f2970076d4f150e9289a64c6147f.jpg', 'Y', '2021-05-22'),
(96, 'Nvidia GeForce RTX 3060 restock updates from Amazon, Best Buy, Newegg and more', 'nvidia-geforce-rtx-3060-restock-updates-from-amazon-best-buy-newegg-and-more', 'On the hunt for an Nvidia GeForce RTX 3000 series graphics card? Get in line. Between the pandemic that forced people to stay home and game more and the explosion in cryptocurrency mining, demand is sky high for Nvidia\'s new Ampere GPU. Finding a new RTX 3000 card is next to impossible; the GeForce RTX 3060, RTX 3060 Ti, RTX 3070, RTX 3080 and RTX 3090 have been perpetually out of stock since they were released. You\'d have better luck tracking down a PS5 or locating an Xbox Series X console than finding a new RTX GPU for your gaming rig.\r\n\r\nNvidia is not deaf to your cries for an RTX 3000 series GPU. It tweaked the RTX 3060\'s driver to discourage crypto miners from snatching up the card and will soon release new versions of the higher-end cards with the same restriction. Labeled as \"Lite Hash Rate\" or LHR cards, they will will throttle back performance if they detect that you are mining using the Ethereum algorithm. Fear not, gamers: These cards will run at full speed for games. The new LHR cards will begin shipping in late May.\r\n\r\nDespite Nvidia\'s efforts to get the RTX 3060 into the hands of gamers from the start, it\'s out of stock everywhere -- along with the rest of its RTX 3000-series siblings. You can find it on eBay or StockX, but be prepared to pay three or four times its $330 retail price. If you aren\'t willing to shell out $1,000 and up for an RTX 3060, then keep this page bookmarked. \r\n\r\nTo aid your efforts in finding an RTX 3060 card that\'s actually in stock and available to purchase, we\'ve linked below to product listing pages of the major retailers for the cards from the various manufacturers -- namely Asus, EVGA, Gigabyte, MSI, PNY and Zotac. There is no Founders Edition of the card from Nvidia, but you can check Nvidia\'s site to see the different flavors of the RTX 3060 sold by its partners and check inventory.', 'Y', 'N', 'N', 7, '25b26f635905cf8b6c8392241f72ca24.jpg', 'Y', '2021-05-22'),
(97, 'Verizon, AT&T and T-Mobile dominate $81 billion 5G spectrum auction', 'verizon-at-t-and-t-mobile-dominate-81-billion-5g-spectrum-auction', 'The nation\'s largest wireless carriers dominated the Federal Communications Commission\'s latest 5G spectrum auction, pushing revenue to a record-shattering price tag of more than $81 billion. The FCC released the names and winning bids of the top five bidders for the auction on Wednesday.\r\n\r\nVerizon, which bid under the name Cellco Partnership, spent the most on the auction bidding a whopping $45 billion for 3,511 spectrum licenses. AT&T came in second bidding $23 billion for 1,621 licenses. T-Mobile had the third highest bid of $9 billion for 142 licenses. \r\n\r\nThe so-called C-band spectrum, which includes 500MHz of spectrum between 3.7 and 4.2GHz, has been used by satellite providers to deliver video programming to cable providers. The FCC began auctioning off 280MHz of the block of spectrum in December and ended Jan. 15.  About 200MHz of the spectrum in this band has will continue to be used for TV programming. \r\n\r\nWireless experts had expected the auction of the midband spectrum to generate a lot of interest. Some had predicted the prized spectrum could be worth as much as $60 billion. But the final tally blew through those predictions, raising more than $81 billion for the US Treasury. \r\n\r\nThe high price tag and final list of winners underscores the high value the nation\'s largest wireless providers have placed on midband spectrum to build out their 5G networks. \r\n\r\n5G is the next generation of wireless service, which is expected to increase network speeds and make networks more responsive. The technology could help make applications like autonomous vehicles a reality and will deliver new AR and VR experiences to smartphones. \r\n\r\nMidband spectrum, such as the C-band, is considered important for 5G deployments because it offers both geographic coverage and the capacity to transmit large amounts of data. This combination is especially appealing to wireless giants who have been trying to fill out their spectrum portfolios. \r\n\r\n\"It is essential to America\'s economic recovery that we deliver on the promise of next generation wireless services for everyone, everywhere,\" FCC Acting Chairwoman Jessica Rosenworcel said in a statement. \"This auction reflects a shift in our nation\'s approach to 5G toward midband spectrum that can support fast, reliable, and ubiquitous service that is competitive with our global peers.\"', 'Y', 'Y', 'Y', 6, '400cff9440110937f33a6c4a00fe66b7.jpg', 'Y', '2021-05-22'),
(98, 'Google Chrome will fix your hacked passwords with ONE TAP!', 'google-chrome-will-fix-your-hacked-passwords-with-one-tap', 'Google Chrome is getting a new ability to fix your hacked password fast. It\'s standard for web browsers to warn you when your password is found on a list of hacked passwords, but now Google\'s browser also will be able to fix it with a  tap of a button.\r\n\r\nWhen Google spots a vulnerable password, Google Assistant will offer a \"change password\" button, Google announced at its Google I/O developers conference on Tuesday. It will arrive in Chrome on Android in the United States but will spread to other browsers and regions later. It only works on Twitter and a \"small number\" of other sites initially, and you need to enable Chrome password sync.\r\n\r\nThe password change feature relies on Google\'s Duplex technology, an AI-powered service that fills out forms and takes other automated actions on the web. \r\n\r\nThe feature reflects the growing importance of password managers. We\'re bad at creating hard-to-crack passwords and even worse at remembering them, but password managers handle the grunt work. They\'re built into operating systems and browsers, but many people use standalone password managers that work across different browsers.', 'Y', 'Y', 'Y', 6, '9daf234fa201c5a53f9900a52f161d3a.jpg', 'Y', '2021-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE `submenu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `sub_title` varchar(50) NOT NULL,
  `sub_url` varchar(50) NOT NULL,
  `is_active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submenu`
--

INSERT INTO `submenu` (`id`, `id_menu`, `sub_title`, `sub_url`, `is_active`) VALUES
(1, 1, 'Web Identity', 'admin/identity', 'Y'),
(2, 1, 'Contact', 'admin/contact', 'Y'),
(3, 2, 'Main Menu', 'admin/menu', 'Y'),
(4, 2, 'Sub Menu', 'admin/submenu', 'Y'),
(5, 3, 'Category', 'admin/category', 'Y'),
(6, 3, 'Add Post', 'admin/posting', 'Y'),
(7, 4, 'Album', 'admin/album', 'N'),
(8, 4, 'Photo Gallery', 'admin/gallery', 'N'),
(10, 4, 'Banner', 'admin/banner', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$QUM2OeQCZclQqJIhZKKMt.Aq8dA3Y7eIzjtXsyr.xuE0kDjfj8SLS', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1621754450, 1, 'Will', 'Williams', 'CodeAstro', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(37, 1, 1),
(38, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identity`
--
ALTER TABLE `identity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `identity`
--
ALTER TABLE `identity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `posting`
--
ALTER TABLE `posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
