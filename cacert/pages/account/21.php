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
	$org = $_SESSION['_config']['row'];
	if($org['id'] <= 0)
		$org = $_SESSION['_config']['altrow'];
?>
<p>
<?=_("Please make sure the following details are correct before proceeding any further.")?>
</p>

<p>
<? if(is_array($_SESSION['_config']['rows']))
	foreach($_SESSION['_config']['rows'] as $row) { ?>
<?=_("CommonName")?>: <?=$row?><br>
<? } ?>
<? if(is_array($_SESSION['_config']['altrows']))
	foreach($_SESSION['_config']['altrows'] as $row) { ?>
<?=_("subjectAltName")?>: <?=$row?><br>
<? } ?>
<?=_("Organisation")?>: <?=$org['O']?><br>
<?=_("Org. Unit")?>: <?=($_SESSION['_config']['OU'])?><br>
<?=_("Location")?>: <?=$org['L']?><br>
<?=_("State/Province")?>: <?=$org['ST']?><br>
<?=_("Country")?>: <?=$org['C']?><br>


<form method="post" action="account.php">
<input type="submit" name="process" value="<?=_("Submit")?>">
<input type="hidden" name="oldid" value="<?=$id?>">


<? if($_SESSION['profile']['admin'] == 1) { ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<input type="checkbox" name="ocspcert" value="OCSPCert"/> <?=_("OCSP certificate")?>
<? } ?>

</form>
</p>
