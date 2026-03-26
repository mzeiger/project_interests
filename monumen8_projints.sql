-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 09:38 PM
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
-- Database: `monumen8_projints`
--
CREATE DATABASE IF NOT EXISTS `monumen8_projints` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `monumen8_projints`;

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob_month` varchar(10) NOT NULL,
  `dob_day` tinyint(6) NOT NULL,
  `spouse` varchar(30) NOT NULL,
  `address` varchar(20) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` char(5) NOT NULL,
  `home_phone` varchar(16) NOT NULL,
  `cell_phone` varchar(16) NOT NULL,
  `home_email` varchar(50) NOT NULL,
  `sponsor` varchar(20) NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `job_title` varchar(30) NOT NULL,
  `business_address` varchar(50) NOT NULL,
  `business_email` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `skills` text NOT NULL,
  `saw_ads` tinyint(1) NOT NULL DEFAULT 0,
  `saw_website` tinyint(1) NOT NULL DEFAULT 0,
  `application_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`home_email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `application`:
--

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `first_name`, `last_name`, `dob_month`, `dob_day`, `spouse`, `address`, `city`, `state`, `zip`, `home_phone`, `cell_phone`, `home_email`, `sponsor`, `business_name`, `job_title`, `business_address`, `business_email`, `bio`, `skills`, `saw_ads`, `saw_website`, `application_date`) VALUES
(1, 'Robert (RF)', 'Smith', 'October', 16, 'Ann', 'Smugglers Court', 'Monument', 'CO', '80132', '719-757-4888', '719-746-3828', 'rk@gmail.com', 'Rich Strom', '', '', '', '', '', '', 0, 0, '2026-03-04 11:24:31'),
(2, 'Mark', 'Zeiger', 'April', 21, 'Diane', '2193 Red Edge Hts.', 'Colorado Springs', 'CO', '80921', '719-488-5934', '719-494-7718', 'mark.zeiger@gmail.com', 'Rich Rima', '', '', '', '', '', '', 0, 0, '2026-03-04 11:27:51'),
(9, 'John', 'Jones', 'April', 5, '', '2', '2', 'WW', '44444', '', '777-777-7777', 'mark.zeiger@gmail.co', 'm', '', '', '', '', '', '', 0, 0, '2026-03-11 12:38:14'),
(11, 'John', 'Jones', 'April', 5, '', '2', '2', 'WW', '44444', '', '777-777-777', 'mark.zeiger@gmail.c', 'm', '', '', '', '', '', '', 0, 0, '2026-03-11 12:41:56'),
(12, 'm', 'm', 'October', 15, 'm', 'm', 'm', 'DD', '44444', '', '444-444-4444', 'd@g.c', 't', '', '', '', '', '', '', 0, 0, '2026-03-11 20:04:24'),
(14, 'y', 'y', 'September', 17, 'y', 'y', 'y', 'YY', '66666', '777-777-7777', '', 'd@f.c', 't', '', '', '', '', '', '', 0, 0, '2026-03-11 20:33:42'),
(15, '5', '5', 'January', 13, '5', '5', '5', 'YY', '66666', '666-666-6666', '', 't@g.w', '8', '', '', '', '', '', '', 0, 0, '2026-03-11 20:35:34'),
(16, 'rrr', 'rrr', 'February', 2, 'rrr', 'rrr', 'rrr', 'RR', '55555', '333-333-3333', '', '333@t.com', 'd', '', '', '', '', '', '', 0, 0, '2026-03-14 11:38:01');

--
-- Triggers `application`
--
DROP TRIGGER IF EXISTS `trg_insert_person`;
DELIMITER $$
CREATE TRIGGER `trg_insert_person` AFTER INSERT ON `application` FOR EACH ROW BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM person
        WHERE email = NEW.home_email
    ) THEN
        INSERT INTO person (fname, lname, email)
        VALUES (NEW.first_name, NEW.last_name, NEW.home_email);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
CREATE TABLE IF NOT EXISTS `interest` (
  `personId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  UNIQUE KEY `idx_person_project` (`personId`,`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `interest`:
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `pwd` varchar(200) NOT NULL DEFAULT '""',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `person`:
--

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `email`, `lname`, `fname`, `pwd`) VALUES
(65, 'mark.zeiger@gmail.com', 'Zeiger', 'Mark', ''),
(66, 'zoe.zeiger@gmail.com', 'Zeiger', 'Zoe', '');

--
-- Triggers `person`
--
DROP TRIGGER IF EXISTS `delete_interest_when_person_deleted`;
DELIMITER $$
CREATE TRIGGER `delete_interest_when_person_deleted` AFTER DELETE ON `person` FOR EACH ROW BEGIN
    DELETE FROM interest WHERE interest.personId = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(60) NOT NULL,
  `position` int(11) NOT NULL,
  `projectHead` varchar(60) NOT NULL,
  `estimatedTime` varchar(60) NOT NULL,
  `projectDescription` text NOT NULL,
  `fullDescription` text NOT NULL DEFAULT '\'\'',
  `divider` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_projectName` (`id`),
  UNIQUE KEY `idx_position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `project`:
--

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `projectName`, `position`, `projectHead`, `estimatedTime`, `projectDescription`, `fullDescription`, `divider`) VALUES
(284, 'Kiwanis Service Leadership Program (SLP)', 10, 'Mike Luginbuhl', 'Substantial investment in time', 'MHKC advisors work in pairs to increase continuity.  MHKC advisors provide assistance and mentoring to SLP students and support to faculty advisors.  Participating in SLP at elementary or middle school level involves 2-5 hours/month, most of which is spent in the schools with the students.  At the high school and college level, the commitment is higher, 10-20 hours a month depending on the time of year.', 'The Service Leadership Program (SLP) is our SIGNATURE PROJECT?helping our youth learn about service and leadership. This program is a central element of our Youth Outreach programs and the key element of our mission: Making a Positive Difference for Youth and Our Community. The SLP organizes and mentors student-led clubs at elementary, middle, and high school levels as well as a college level club. The program provides our members a way to interact directly with our community and youth, bringing them perspective on service to others and on leadership in the community.  Our advisors work with school faculty to enrich our students by providing them early opportunities to impact others.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(285, 'MHKC 4th of July Parade', 20, 'Frank Dellala', 'One morning on July Fourth', 'Most of the volunteer work for the Parade is on one day, the 4th of July.  Some leadership positions are available to assist the Parade Manager with Setup, Judging, Marshals, Logistics, Transportation, Cleanup, and in other areas.  Volunteers work from early on the 4th until noon or a little later, depending on the position.  Most positions involve contact with the parade participants and the public.', 'The MHKC 4th of July Parade has been billed as ?The Biggest Small Town Parade in America.?  MHKC makes a difference by organizing and operating a 100 unit parade through historic downtown Monument, Colorado every Independence Day as part of the Tri-Lakes Independence Day Celebration.  In operation since the 1970s, this parade is our largest Community Service project.  Our members start in April, implementing parade plans and coordinating with our partners. The parade includes a children?s parade, VIPs, veterans units, horses & other animals, bands, churches, businesses, fire trucks, and other exciting units.  The MHKC team manages publicity, coordination with law enforcement, transportation, services, trash, barricades, and unit applications.  Our members also supervise parking, parade line-up, children?s parade organization, parade safety marshals, and cleanup.  In all, it takes more than 80 of our members to make the parade a success.  MHKC volunteers contribute over 1,500 hours to present this event?we?re very proud of this gift to the community.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(286, 'Children\'s Literacy Center (CLC)', 30, 'Mike Luginbuhl', 'Moderate investment in time', 'MHKC volunteers tutor selected students twice per week between 5:30-6:30 pm. A background check is required but no specific teaching experience is required. Tutors participate in a half day training session before working with students.The CLC has both school year and summer sessions. ', 'Learning to Read is KEY to Reading to Learn.  According to the National Assessment of Adult Literacy, 2/3 of students who cannot read proficiently by the end of the 4th grade will end up in jail or on welfare.  MHKC makes a difference by providing volunteer tutors to the Children\'s Literacy Center for elementary students in D38 schools. The program is aimed at K-3 grades. Students are screened by the CLC and assigned to volunteers who maintain continuity with a single student through their participation in the program. MHKC volunteers contribute about 500 hours annually to this project. This event takes place during the school year and during a short summer session. For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(287, 'Distributive Education Clubs of America (DECA)', 40, 'Ed Hettler', 'Moderate investment in time', 'DECA volunteers give 1-2 days, once a year, to be judges? one day at the district competition in Castle Rock in November, and/or one day at the state competition at the Broadmoor in February.  No specific experience is required and training is provided on the day.  Judges travel to the location and must have a charged internet device (tablet or phone) for the scoring process.  Meals are provided at the venues.', 'For our students who want to careers in business, MHKC makes a difference by providing judges for annual area and state DECA competitions. High school DECA students compete in a number of marketing challenges in several specialty areas to earn college scholarship support. Area competitions take place over a 1-2 day period. MHKC volunteers work in pairs to judge student presentations in a number of specialty areas. No specific qualifications are required of volunteers and training is provided to assist them in the judging tasks. Judges are not involved in compiling scores or in selecting competition awards. MHKC volunteers contribute about 30 hours annually to this project. This event takes place on one weekend in early December every year.  Two judging sessions yearly between November and February? No experience necessary.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(288, 'Pikes Peak Soap Box Derby', 50, 'Greg Bielanski', 'One to two days', 'This project requires a commitment of 2-3 hours several days in mid to late May and three weekend days in early June.  Volunteers work with youth to disassemble and reassemble SBD cars at Brad?s House in Monument.  Complete step by step plans are provided.  Some simple tools are required.  No specific expertise is required.', 'Having fun building self-confidence in our youth, MHKC makes a difference by supporting the annual Pikes Peak Soap Box Derby (PPSBD) which provides the opportunity for young boys and girls to build and race gravity propelled cars in an environment of safe competition.  Club members provide assistance with inspecting and weighing cars as well as supervision of track preparation and race activities. Members also provide special assistance to the Griffith Centers for Children Chins Up (GCCCU), supervising selected students who build and race cars in three categories. MHKC volunteers contribute about 200 hours annually to this event. This event takes place in early June every year.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a> , or <a href=\"http://www.soapboxderby.org\" target=\"_blank\">www.soapboxderby.org</a>  or google <strong>Pikes Peak Soap Box Derby</strong>.', 0),
(289, 'Rocky Mountain Youth Leadership Conference (RMYLC)', 60, 'RF Smith', 'One to four days', 'Volunteer opportunities are available with the Foundation and the Conference.  Foundation volunteers commit to 2 hours/month for Board meetings and additional time in the fall to organize and execute a fundraiser.  Conference volunteer work can vary from part time to full time at the Conference in Pueblo for a week in the middle of June.  Volunteer room and board is paid by the Foundation.', 'MHKC makes a difference by supporting the annual Rocky Mountain Youth Leadership Conference?Building Informed Citizen Leaders. The RMYLC is operated by a separate 501(c)3 organization, the Rocky Mountain Youth Leadership Foundation (rmylf.org). The RMYLC provides a 5-day on-campus experience for 99 area high school juniors at  Colorado State University Pueblo (CSUP) in mid-June. The fully chaperoned event provides attendees with a college-like experience and education in leadership, patriotism, and the free enterprise system. Students participate in team and individual problem-solving challenges as well as attending presentations by highly qualified educational speakers. In addition to providing a grant for the conference, several club members volunteer time to assist with the operation of the conference. MHKC volunteers contribute about 100 hours annually to this event.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(290, 'Senior Meals', 70, 'Jim Murphy', 'One morning per month', 'Volunteer commit to drive once a month on a Monday, Wednesday, or Thursday.  Volunteers pick up empties at the church at 10am and are usually finished in an hour or so. The trip is down to the Silver Key facility off Airport Drive in southern Colorado Springs and back with full containers.  No skill is involved and members donate their time and vehicle operating costs.  Volunteers need to be able to lift 30 pounds.', 'MHKC makes a difference by providing assistance to Silver Key to deliver safe, convenient meals for the greatest generation, residents of the Tri-Lakes area at the Tri-Lakes Senior Center (currently at the Monument Community Presbyterian Church, 3rd Street). On selected days of the week, MHKC members pick up empty service containers at the Center, return those containers to the Silver Key kitchens in south Colorado Springs, pick up containers of hot food, and bring those containers back to the Center for serving at a noon meal. The work is shared between 12-15 volunteers so that each volunteer performs this service once or twice a month. The work is entirely voluntary and no compensation of any kind is provided. MHKC volunteers contribute over 400 hours annually to this project. This event takes place every week of the year and involves about a two-hour commitment.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=78&Itemid=260\" target=\"_blank\">HERE</a>', 0),
(291, 'Stars of Tomorrow', 80, 'Rich Strom', 'One to two days in March', 'There are several different volunteer opportunities for Stars of Tomorrow, most coming on the days of auditions (2 days in February) and the show (2 days in March).  Volunteers assist with publicity, preparation, and operation of the event.  Volunteer hours range from 2-3 hours for some tasks to 3-4 days for others.  No special skill is required.', 'Talent on Display. Monument Hill Kiwanis Club and District 38 inaugurate the Stars of Tomorrow Talent Show program for our community in 2022.  We highlight the talent of our local youth and provide them with an extraordinary opportunity to perform and receive feedback to continue to hone their skills. In addition, the Stars show is a fantastic fun family event for everyone in our community!  Stars of Tomorrow: gives recognition to our performing arts students, helps them hone their skills as they move forward with their performing arts career, builds their confidence as they compete in a professionally judged competition, and gives them experience in performing before a live audience in a first-class venue.\nThe competition classes are: Elementary (1-5) with a $500 prize, Middle School (6-8) with $750 prize and High School (9-12) with scholarships of $1,000 and $2,000.  While the middle school category does not mirror District 38?s classifications, adding an additional year?s class to the group helps even out the number of potential contestants. Dollar amounts of awards increase with age since older performers are anticipated to be more accomplished, have been working to improve their skills for longer, have spent more money on instruments and instructions and are possibly committed to pursuing a career in the performing arts.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=76&Itemid=299\" target=\"_blank\">HERE</a>', 0),
(292, 'Peach Sales', 90, 'Terry McMullen', 'One morning or afternoon in August', 'Volunteers donate between 2-10 hours, one day a year, to support distribution of the peaches sold.  This is an outdoor event and is organized in 4 hours shifts.  Some volunteers need to be able to lift 20# boxes of peaches. Some standing is required but there are volunteer positions that involve seated work as well.', 'Fresh Colorado peach sales support grants to make a difference.  MHKC raises funds to enable our mission of Making a Difference for Youth and Our Community by selling Colorado Palisades peaches once a year. All proceeds are used to execute the philanthropic element of the MHKC mission.  Purchase orders are taken in June and July and peaches are delivered in August. MHKC volunteers administer the sales process and assemble for customer pickup in the parking lot of Bear Creek Elementary School on the specified day, dependent on the growing season. MHKC volunteers contribute over 100 hours annually to this project.  The pickup event takes place near the beginning of August.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=76&Itemid=299\" target=\"_blank\">HERE</a>', 0),
(293, 'Empty Bowls Dinner', 100, 'Dave Baily', 'One evening in October', 'Volunteers can contribute time to help organize the event and/or operate the event on the day.  Typical volunteer effort is between 2 -10 hours total, though some lead tasks require more time.  There are physical requirements for those who help collect the soup and those who help in the kitchen on the night of the event.  Otherwise, the duties require no specific qualifications.', 'A generous community helping ourselves.  MHKC raises funds to enable our mission of Making a Difference for Youth and Our Community by partnering with Tri-Lakes Cares to conduct the Empty Bowls Dinner in October. Patrons pre-purchase a ticket to the event for $25 ($30 at the door) which entitles them to a bowl, a meal, entertainment, and community fellowship. Annually, 800+ bowls are produced by local artists & schools and donated for the event at no cost. Paper bags to carry the bowls are decorated by D38 elementary students. Soup is donated by 25+ local restaurants and bread is donated by local stores. Beverages are donated by Home Depot and Serranos Coffee. Desserts are donated by local stores and restaurants.  MHKC volunteers coordinate with TLC, prepare publicity for the event, conduct ticket sales, arrange for entertainment, solicit and collect donations, provide kitchen support, operate the event, and clean up afterward. MHKC volunteers contribute about 1,000 hours annually to this project. This one-night event raises more than $15,000 and all proceeds of the event are donated to our partner Tri-Lakes Cares for their mission. This event takes place on Wednesday of the first full week of October of every year.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=76&Itemid=299\" target=\"_blank\">HERE</a>', 0),
(294, 'Holiday Bell Ringing', 110, 'Jeff Baker', 'Multiple one-hour shifts in Nov & Dec (participant can choos', 'Volunteers sign up for one hour shifts.  Stools are provided and some provisions are available for foul weather.  The project runs from the day after Thanksgiving to Christmas Eve.  Volunteer opportunities are also available for member who pick up money at the end of the day and take it to the bank.', 'Helping The Salvation Army do more, MHKC raises funds to Make a Difference for Youth and Our Community by ringing the bell for the Salvation Army every holiday season. MHKC volunteers ring the bell at two local locations: King Soopers on Baptist Road and Walmart. Volunteers sign up for one-hour shifts from 10 am - 6 pm. Sunday ringing is supported by our Service Leadership Program Key Club and Builders Club students who are supervised while ringing the bell. Overall, MHKC volunteers contribute over 750 hours annually to this project.  All proceeds are donated to Salvation Army to support their mission?impacting hundreds of families and children in the area. In addition to nearly $40,000 raised annually through the generosity of area citizens, MHKC volunteers receive no compensation. Salvation Army saves nearly $7,000 annually in wages they have to pay to get bell ringers in other locations.  This event takes place on selected days from the day after Thanksgiving through Christmas Eve every year.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=76&Itemid=299\" target=\"_blank\">HERE</a>', 0),
(295, 'K-News', 120, 'Rich Hicks, Mark Anderson, RF Smith', 'Substantial investment in time', 'The K-News is a weekly publication by the club that is a recap of Saturday\'s meeting.  Editors need minimal training in the use of Constant Contact, the online email took used by the Club for communications.', '', 0),
(296, 'North Pole at Tri-Lakes Craft Fair', 130, 'Jim Ward, Dick Salverson', 'One day in December', 'Almost all volunteer work is on the night before the event and the day of the event.  Members volunteer between 2-10 hours to prepare the venue and to assist vendors with setup on Friday evening, and on Saturday to help vendors, to staff a MHKC booth, and to assist vendors and the project manager with breakdown and cleanup at the end of the day.  Volunteers are assisted by youth members of our SLP clubs.  No specific qualification are required.', 'Funding grants to make a difference, MHKC raises funds to enable our mission of Making a Difference for Youth and Our Community by conducting a one-day craft fair every year in December.  The North Pole Craft Fair is held at the Bear Creek Elementary School on Leather Chaps Road in Monument, Colorado. Vendors purchase space to present their wares for sale and local churches prepare baked goods for purchase by craft fair patrons. Entry is free but patrons are requested to bring a non-perishable food item that is donated to Tri-Lakes Cares. All other proceeds are used to execute the philanthropic element of the MHKC mission.MHKC volunteers set up and break down the display area at Grace Best for the event and assist vendors when requested. Volunteers also provide assistance during the event to vendors or patrons who need it. MHKC volunteers contribute about 100 hours annually to this project.  This event takes place on the first Saturday of December every year.  For more info click <a href=\"https://monumenthillkiwanis.org/mhk/index.php?option=com_content&view=article&id=76&Itemid=299\" target=\"_blank\">HERE</a>', 0),
(297, 'Pools', 140, 'Dan Lopez, Larry Young, Dennis Beasley', 'Moderate investment in time', 'The club operates several internal (members only) NFL and NBA pools in the fall and spring of each year.  Volunteers assist the project managers with member notification, and by filing in as required on Saturdays.  Estimate volunteer hours 10-20 hours per year.', 'The Club operates five internal (members only) pools during the NFL season and one pool during the NCAA basketball season.\nThe football pools are: Sally?s Challenge, the Losers Pool, the Losers Losers Pool, the Glenn Scott Winners Pool and the Super Bowl Boards.  The first four operate during the regular NFL season, the Super Boards are initiated at the Holiday Party in December through the Super Bowl game in February.\nThe basketball pool, March Madness, is operated in March and uses the CBS online March Madness service.', 0),
(298, 'Kris Kringle Coffee', 150, 'Larry Vliet', 'One day in December', 'Volunteers assist the project manager in coordinating for production and delivery of product and sales.', 'The club sells coffee in the holiday season.  The coffee is especially packaged by the Serannos Coffee Company in Monument.  The Kris Kringle Coffee is branded for Serannos and the Monument Hill Kiwanis Club.  Sales take place at the Craft Fair and in other places.  Members may buy coffee at meetings and some local merchants give up counter space for sales.', 0),
(299, 'Margarita @ Pine Creek Wine Tasting', 160, 'Dirk Stamp, Rich Strom', 'Usually one evening', 'Volunteers assist the project manager in public relations, preparation for, and execution of the project and attend in support.', 'In the fall of each year, the proprietor of The Wine Seller in Monument works with Margarita @ Pine Creek to stage a wine tasting event in support of Monument Hill Kiwanis projects and granting.  Members may volunteer to assist with advertising and by attending the event in Club vests to provide public exposure for our Club and mission.', 0),
(300, 'Kiwanis Board of Directors', 2000, 'N/A', 'Moderate to substantial investment in time', 'The following are Board or Board support positions.  Each Officer or Director listed will have a committee of member volunteers to assist in performance of Board duties and responsibilities.', 'This column, buttons, links or other mechanism can point to selected paragraphs from our governance that provide full descriptions of the duties and responsibilities of the officers and directors shown.', 1),
(301, 'Assistant Secretary', 2010, 'Sue Reinecke, Secretary', 'Moderate to substantial investment in time', 'Assists Secretary in recording Board meeting, publishing minutes, reporting to Kiwanis International and other monthly and annual tasks.  Estimate 10 hours/month.', '', 0),
(302, 'Assistant Treasurer', 2020, 'Dan Lopez, Treasurer', 'Usually one meeting per month', 'Assists Treasurer and bookkeeper at meetings by collecting and recording payments and delivering to the bank same day.  Approximately once per month at a regular Saturday meeting.  Detailed instructions available.', '', 0),
(303, 'Vice President, Membership', 2030, 'Bill Stoner', 'Moderate investment in time', 'Responsible for MHKC membership, cradle to grave.  Recruits volunteers to lead acquisition, retention, recognition, social, interclub, and special needs activities.', '', 0),
(304, 'Vice President, Youth Outreach', 2040, 'Mike Luginbuhl', 'Substantial investment in time', 'Responsible for all youth outreach activities.  Recruits volunteers to lead SLP, CLC and other youth activities.', '', 0),
(305, 'Deputy for Youth Outreach', 2050, 'TBD', 'Substantial investment in time', 'Responsible to assist the VP, Youth Outreach as assigned.  Estimate 10-30 hours/month', '', 0),
(306, 'Director, Fundraising', 2060, 'TBD', 'Substantial investment in time', 'Responsible for oversight of all fundraising activities of the Club.  Recruits project managers and deputies for six current fundraising projects', '', 0),
(307, 'Director, Service Programs', 2070, '', 'Substantial investment in time', 'Responsible for oversight of all service activities of the Club.  Recruits project managers and deputies for five current service projects', '', 0),
(308, 'Director, Communications', 2080, 'Bob Harrigan', 'Substantial investment in time', 'Responsible for all internal and external communications for the Club.  Establishes website content and provides public relations support to project managers.  Provides internal communications to ensure members are aware of Club activities and needs.', '', 0),
(309, 'Director, Programs', 2090, 'Ed Tomlinson', 'Moderate investment in time', 'Responsible to recruit programs for Saturday meetings.', '', 0),
(310, 'Director, Planning', 2100, 'Larry Young', 'Moderate investment in time', 'Responsible to provide strategic assessment and guidance to the President regarding the future of Club activities.', '', 0),
(311, 'Director, IT', 2110, 'Mark Zeiger', 'Small investment in time', 'Responsible to maintain Club website functionality and subscriptions for various online tools used by the Club.  Assists the other Board members in implementing online functionality to improve efficiency of operation.', '', 0),
(312, 'Monument Hill Foundation', 3000, 'Rich Strom', 'See below', 'The following are functions of the Monument Hill Foundation for which Club members may volunteer.', '', 1),
(313, 'Investment', 3010, '', 'Substantial investment in time', 'A small committee manages the investments of the Foundation.  Members may volunteer to act as advisors on this committee.  Committee size and structure are controlled by the Foundation Executive Director under the Foundation bylaws and policies.', '', 0),
(314, 'Granting', 3020, '', 'Usually one to two three-hour meetings', 'A committee assesses and recommends the annual Grants Plan to the Foundation Board for approval.  Members may volunteer to serve on this committee.  Committee size and structure are controlled by the Foundation Executive Director under the Foundation bylaws and policies.', '', 0);

--
-- Triggers `project`
--
DROP TRIGGER IF EXISTS `delete_interest_when_project_deleted`;
DELIMITER $$
CREATE TRIGGER `delete_interest_when_project_deleted` AFTER DELETE ON `project` FOR EACH ROW BEGIN
    DELETE FROM interest WHERE interest.projectId = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_project_person`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_project_person`;
CREATE TABLE IF NOT EXISTS `v_project_person` (
`interest_personId` int(11)
,`interest_projectId` int(11)
,`projectId` int(11)
,`projectName` varchar(60)
,`projectHead` varchar(60)
,`estimatedTime` varchar(60)
,`projectPosition` int(11)
,`projectDescription` text
,`fullDescription` text
,`personId` int(11)
,`email` varchar(50)
,`lname` varchar(30)
,`fname` varchar(20)
,`pwd` varchar(200)
);

-- --------------------------------------------------------

--
-- Structure for view `v_project_person`
--
DROP TABLE IF EXISTS `v_project_person`;

DROP VIEW IF EXISTS `v_project_person`;
CREATE VIEW `v_project_person`  AS SELECT `interest`.`personId` AS `interest_personId`, `interest`.`projectId` AS `interest_projectId`, `project`.`id` AS `projectId`, `project`.`projectName` AS `projectName`, `project`.`projectHead` AS `projectHead`, `project`.`estimatedTime` AS `estimatedTime`, `project`.`position` AS `projectPosition`, `project`.`projectDescription` AS `projectDescription`, `project`.`fullDescription` AS `fullDescription`, `person`.`id` AS `personId`, `person`.`email` AS `email`, `person`.`lname` AS `lname`, `person`.`fname` AS `fname`, `person`.`pwd` AS `pwd` FROM ((`interest` left join `project` on(`project`.`id` = `interest`.`projectId`)) left join `person` on(`interest`.`personId` = `person`.`id`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
