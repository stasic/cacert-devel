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
*/ ?>
<?
	$certid = 0; if(array_key_exists('cert',$_REQUEST)) $certid=intval($_REQUEST['cert']);

	$query = "select * from `orgemailcerts`,`org` where `orgemailcerts`.`id`='".intval($certid)."' and
			`org`.`memid`='".intval($_SESSION['profile']['id'])."' and
			`org`.`orgid`=`orgemailcerts`.`orgid`";
	$res = mysql_query($query);
	if(mysql_num_rows($res) <= 0)
	{
		showheader(_("My CAcert.org Account!"));
		echo _("No such certificate attached to your account.");
		showfooter();
		exit;
	}
	$row = mysql_fetch_assoc($res);

	show_client_cert($row['crt_name'], "account.php?id=19&amp;cert=$certid", $row['CN']);
