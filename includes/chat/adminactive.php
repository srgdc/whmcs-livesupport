<?
/*
    WHMCS Addon Live Support - Provides a way for you to instantly communicate
    with your customers.
    Copyright (C) 2010-2012 WHMCS Addon

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
@error_reporting(0);
@ini_set("register_globals", "off");
// Find WHMCS Directory
//    Set $pathPart to the folder to exclude from.
$directoryFinder = explode("/", $_SERVER["SCRIPT_FILENAME"]);
foreach($directoryFinder as $pathPart) {
	if ($pathPart != "") {
		if ($pathPart != "includes") {
			$dir .= "/".$pathPart;
		} else {
			$dir .= "/";
			break;
		}
	}
}

require($dir."/dbconnect.php");
session_start();

$result = mysql_query("SELECT * FROM `tbladminlog` WHERE `sessionid`='".$_COOKIE["PHPSESSID"]."' ORDER BY `id` DESC");
while($row = mysql_fetch_array($result)) {
	$lastvisit = $row[6];
}


$visit = date("Y-m-d H:i:s");

$result = mysql_query("UPDATE `tbladminlog` SET `lastvisit`='".$visit."' WHERE `sessionid`='".$_COOKIE["PHPSESSID"]."'") or die(mysql_error());
if ($_GET["online"] == "1") {
	echo "1";
	$result = mysql_query("UPDATE `tbladminlog` SET `online`='1' WHERE `sessionid`='".$_COOKIE["PHPSESSID"]."'") or die(mysql_error());
} else {
	$result = mysql_query("UPDATE `tbladminlog` SET `online`='0' WHERE `sessionid`='".$_COOKIE["PHPSESSID"]."'") or die(mysql_error());
}

mysql_close();
?>