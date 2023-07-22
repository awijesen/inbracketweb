<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli("inb.crptbfpjxc5h.ap-southeast-2.rds.amazonaws.com", "inbadminuser", "0peNmlinbSql2022dbase!", "INB");
$db->set_charset('utf8mb4');


/*
CREATE TABLE `sales_order` (
  `LineId` int(11) NOT NULL,
  `SortCodeDescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SO` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Customer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Reference` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ProcessedDate` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `CreatedOn` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Shipday` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `createdby` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `Picker` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `OrdQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`LineId`);

*/


/*

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `skey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `svalues` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `skey`, `svalues`) VALUES
(1, 'creds', '{\"username\":\"username\",\"password\":\"password\",\"grant_type\":\"password\",\"database\":\"database\",\"keys\":\"live\",\"Connection-Type\":\"application\\/x-www-form-urlencoded\"}'),
(2, 'tokens', '{}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


*/




?>