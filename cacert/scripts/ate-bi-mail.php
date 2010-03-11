#!/usr/bin/php -q
<? /*
    LibreSSL - CAcert web application
    Copyright (C) 2004-2008  CAcert Inc.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/
	include_once("../includes/mysql.php");

	$lines = "";
	$fp = fopen("ate-bi-email.txt", "r");
	while(!feof($fp))
	{
		$line = trim(fgets($fp, 4096));
		$lines .= wordwrap($line, 75, "\n")."\n";
	}
	fclose($fp);


//	$locid = intval($_REQUEST['location']);
//	$maxdist = intval($_REQUEST['maxdist']);
  $maxdist = 200;

// location      location.ID
//   verified: 29.4.09 u.schroeter
//   $locid = 7902857;       // Paris
   $locid = 238568;        // Bielefeld  
//   $locid = 715191;        // Hamburg    
//   $locid = 1102495;       // London     
//   $locid = 520340;        // Duesseldorf
//   $locid = 1260319;       // Muenchen   
//   $locid = 606058;        // Frankfurt  
//   $locid = 1775784;       // Stuttgart  
//   $locid = 228950;        // Berlin     



	$query = "select * from `locations` where `id`='$locid'";
        $loc = mysql_fetch_assoc(mysql_query($query));

	$query = "SELECT ROUND(6378.137 * ACOS(0.9999999*((SIN(PI() * $loc[lat] / 180) * SIN(PI() * `locations`.`lat` / 180)) + 
			(COS(PI() * $loc[lat] / 180 ) * COS(PI() * `locations`.`lat` / 180) * 
			 COS(PI() * `locations`.`long` / 180 - PI() * $loc[long] / 180)))), -1) AS `distance`, sum(`points`) as pts, `users`.* 
			FROM `locations`
				inner join `users`  on `users`.`locid` = `locations`.`id` 
				inner join `alerts` on `users`.`id`=`alerts`.`memid`
				inner join `notary` on `users`.`id`=`notary`.`to`
			WHERE 	(`alerts`.`general`=1 OR `alerts`.`country`=1 OR `alerts`.`regional`=1 OR `alerts`.`radius`=1)
			GROUP BY `users`.`id`
			HAVING `distance` <= '$maxdist' 
			ORDER BY `distance` ";
//	echo $query;
// comment next line when starting to send mail not only to me 
//	$query = "select * from `users` where `email`='cacert@astrath.de'";
	$res = mysql_query($query);
	$xrows = mysql_num_rows($res);
	while($row = mysql_fetch_assoc($res))
	{
		// echo $row['pts']."..".$row['email']."...\n";
    // uncomment next line to send mails ...
		sendmail($row['email'], "[CAcert.org] ATE-Bielefeld 2.5.2009", $lines, "events@cacert.org", "", "", "CAcert Events Organisation", "returns@cacert.org", 1);
	}
  // 1x cc to events.cacert.org
	sendmail("events@cacert.org", "[CAcert.org] ATE-Bielefeld 2.5.2009", $lines, "events@cacert.org", "", "", "CAcert Events Organisation", "returns@cacert.org", 1);
	// 1x mailing report to events.cacert.org
  sendmail("events@cacert.org", "[CAcert.org] ATE-Bielefeld Report", "invitation sent to $xrows recipients.", "support@cacert.org", "", "", "CAcert Events Organisation", "returns@cacert.org", 1);	
?>
