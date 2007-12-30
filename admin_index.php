<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Panel
 * @version    $Id$
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if($action == 'logout')
{
	$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = '" . (int)$userinfo['adminid'] . "' AND `adminsession` = '1'");
	redirectTo('index.php');
	exit;
}

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'overview')
{
	$overview = $db->query_first("SELECT COUNT(*) AS `number_customers`,
				SUM(`diskspace_used`) AS `diskspace_used`,
				SUM(`mysqls_used`) AS `mysqls_used`,
				SUM(`emails_used`) AS `emails_used`,
				SUM(`email_accounts_used`) AS `email_accounts_used`,
				SUM(`email_forwarders_used`) AS `email_forwarders_used`,
				SUM(`ftps_used`) AS `ftps_used`,
				SUM(`subdomains_used`) AS `subdomains_used`,
				SUM(`traffic_used`) AS `traffic_used`
				FROM `" . TABLE_PANEL_CUSTOMERS . "`" . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "' "));
	$overview['traffic_used'] = round($overview['traffic_used']/(1024*1024), 4);
	$overview['diskspace_used'] = round($overview['diskspace_used']/1024, 2);
	$number_domains = $db->query_first("SELECT COUNT(*) AS `number_domains` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `parentdomainid`='0'" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' "));
	$overview['number_domains'] = $number_domains['number_domains'];
	$phpversion = phpversion();
	$phpmemorylimit = @ini_get("memory_limit");

	if($phpmemorylimit == "")
	{
		$phpmemorylimit = $lng['admin']['memorylimitdisabled'];
	}

	$mysqlserverversion = mysql_get_server_info();
	$mysqlclientversion = mysql_get_client_info();
	$webserverinterface = strtoupper(@php_sapi_name());

	if((isset($_GET['lookfornewversion']) && $_GET['lookfornewversion'] == 'yes')
	   || (isset($lookfornewversion) && $lookfornewversion == 'yes'))
	{
		$latestversion = @file('http://version.syscp.org/SysCP/legacy/' . $version);

		if(is_array($latestversion)
		   && count($latestversion) >= 2)
		{
			$lookfornewversion_lable = $latestversion[0];
			$lookfornewversion_link = $latestversion[1];
			$lookfornewversion_addinfo = '';

			if(count($latestversion) >= 3)
			{
				$addinfo = $latestversion;
				unset($addinfo[0]);
				unset($addinfo[1]);
				$lookfornewversion_addinfo = implode("\n", $addinfo);
			}
		}
		else
		{
			$lookfornewversion_lable = $lng['admin']['lookfornewversion']['error'];
			$lookfornewversion_link = htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');
			$lookfornewversion_addinfo = '';
		}
	}
	else
	{
		$lookfornewversion_lable = $lng['admin']['lookfornewversion']['clickhere'];
		$lookfornewversion_link = htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');
		$lookfornewversion_addinfo = '';
	}

	$userinfo['diskspace'] = round($userinfo['diskspace']/1024, 4);
	$userinfo['diskspace_used'] = round($userinfo['diskspace_used']/1024, 4);
	$userinfo['traffic'] = round($userinfo['traffic']/(1024*1024), 4);
	$userinfo['traffic_used'] = round($userinfo['traffic_used']/(1024*1024), 4);
	$userinfo = str_replace_array('-1', $lng['customer']['unlimited'], $userinfo, 'customers domains diskspace traffic mysqls emails email_accounts email_forwarders ftps subdomains');
	$cronlastrun = date("d.m.Y H:i:s", $settings['system']['last_tasks_run']);
	$trafficlastrun = date("d.m.Y H:i:s", $settings['system']['last_traffic_run']);
	eval("echo \"" . getTemplate("index/index") . "\";");
}
elseif($page == 'change_password')
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
		wasFormCompromised();
		$old_password = validate($_POST['old_password'], 'old password');

		if(md5($old_password) != $userinfo['password'])
		{
			standard_error('oldpasswordnotcorrect');
			exit;
		}

		$new_password = validate($_POST['new_password'], 'new password');
		$new_password_confirm = validate($_POST['new_password_confirm'], 'new password confirm');

		if($old_password == '')
		{
			standard_error(array(
				'stringisempty',
				'oldpassword'
			));
		}
		elseif($new_password == '')
		{
			standard_error(array(
				'stringisempty',
				'newpassword'
			));
		}
		elseif($new_password_confirm == '')
		{
			standard_error(array(
				'stringisempty',
				'newpasswordconfirm'
			));
		}
		elseif($new_password != $new_password_confirm)
		{
			standard_error('newpasswordconfirmerror');
		}
		else
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `password`='" . md5($new_password) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `password`='" . md5($old_password) . "'");
			redirectTo($filename, Array(
				's' => $s
			));
		}
	}
	else
	{
		eval("echo \"" . getTemplate("index/change_password") . "\";");
	}
}
elseif($page == 'change_language')
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
		wasFormCompromised();
		$def_language = validate($_POST['def_language'], 'default language');

		if(isset($languages[$def_language]))
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `def_language`='" . $db->escape($def_language) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "'");
			$db->query("UPDATE `" . TABLE_PANEL_SESSIONS . "` SET `language`='" . $db->escape($def_language) . "' WHERE `hash`='" . $db->escape($s) . "'");
		}

		redirectTo($filename, Array(
			's' => $s
		));
	}
	else
	{
		$language_options = '';

		while(list($language_file, $language_name) = each($languages))
		{
			$language_options.= makeoption($language_name, $language_file, $userinfo['def_language'], true);
		}

		eval("echo \"" . getTemplate("index/change_language") . "\";");
	}
}

?>
