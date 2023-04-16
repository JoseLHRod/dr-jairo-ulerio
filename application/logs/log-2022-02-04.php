<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-02-04 10:20:23 --> Severity: Warning --> Error while sending QUERY packet. PID=10800 /home/customer/www/drjairoulerio.net/public_html/dash/system/database/drivers/mysqli/mysqli_driver.php 307
ERROR - 2022-02-04 10:20:23 --> Query error: MySQL server has gone away - Invalid query: INSERT INTO `tblactivity_log` (`description`, `date`, `staffid`) VALUES ('Messages get from email drjairouleriovargas@gmail.com:1', '2022-02-04 10:20:23', '[CRON]')
ERROR - 2022-02-04 10:20:29 --> Query error: MySQL server has gone away - Invalid query: SELECT `staffid`
FROM `tblstaff`
WHERE `email` = 'actividadesbluemallpuntacana@bluemall.com.do'
ERROR - 2022-02-04 10:20:36 --> Severity: error --> Exception: Call to a member function row() on bool /home/customer/www/drjairoulerio.net/public_html/dash/modules/mailbox/helpers/mailbox_helper.php 20
ERROR - 2022-02-04 10:20:36 --> Query error: MySQL server has gone away - Invalid query: INSERT INTO `tblsessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8659855e92d36b9028c7b5863972c98308f609ae', '35.209.179.243', 1643984436, '__ci_last_regenerate|i:1643984341;')
ERROR - 2022-02-04 10:20:36 --> Query error: MySQL server has gone away - Invalid query: SELECT RELEASE_LOCK('ceeb4550b07938d1480b0bb636da516a') AS ci_session_lock
ERROR - 2022-02-04 15:03:04 --> Severity: Warning --> Error while sending QUERY packet. PID=81275 /home/customer/www/drjairoulerio.net/public_html/dash/system/database/drivers/mysqli/mysqli_driver.php 307
ERROR - 2022-02-04 15:03:04 --> Query error: MySQL server has gone away - Invalid query: INSERT INTO `tblactivity_log` (`description`, `date`, `staffid`) VALUES ('Connect to IMAP from email: drjairouleriovargas@gmail.com', '2022-02-04 15:03:04', '[CRON]')
ERROR - 2022-02-04 15:04:04 --> Query error: MySQL server has gone away - Invalid query: INSERT INTO `tblactivity_log` (`description`, `date`, `staffid`) VALUES ('Messages get from email drjairouleriovargas@gmail.com:0', '2022-02-04 15:04:04', '[CRON]')
