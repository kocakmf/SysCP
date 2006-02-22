<?php
/**
 * filename: $Source$
 * begin: Friday, Aug 06, 2004
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. This program is distributed in the
 * hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * @author    Florian Lippert <flo@redenswert.de>
 * @copyright (C) 2003-2004 Florian Lippert
 * @package   System
 * @version   $Id$
 * 
 * @changes   martin@2006-01-30:
 *            - fixed race condition during task row deletion
 */
	if(@php_sapi_name() != 'cli' && @php_sapi_name() != 'cgi' && @php_sapi_name() != 'cgi-fcgi')
	{
		die('This script will only work in the shell.');
	}

	/**
	 * LOOK INTO TASKS TABLE TO SEE IF THERE ARE ANY UNDONE JOBS
	 */
	fwrite( $debugHandler, '  cron_tasks: Searching for tasks to do');
	$result_tasks = $db->query("SELECT `id`, `type`, `data` FROM `".TABLE_PANEL_TASKS."` ORDER BY `id` ASC");
	$resultIDs   = array();	
	
	while($row = $db->fetch_array($result_tasks))
	{
		$resultIDs[] = $row['id'];
		
		if($row['data'] != '')
		{
			$row['data']=unserialize($row['data']);
		}

		/**
		 * TYPE=1 MEANS TO REBUILD APACHE VHOSTS.CONF
		 */
		if($row['type'] == '1')
		{
			fwrite( $debugHandler, '  cron_tasks: Task1 started - ' . $settings['system']['apacheconf_filename']. ' rebuild');
			$vhosts_file = '# '.$settings['system']['apacheconf_directory'] . 
			               $settings['system']['apacheconf_filename'] . "\n" . 
			               '# Created ' . date('d.m.Y H:i') . "\n" . 
			               '# Do NOT manually edit this file, all changes will be ' .
			               ' deleted after the next domain change at the panel.' . "\n" .
			               "\n";

			if (file_exists($settings['system']['apacheconf_directory'].'diroptions.conf'))
			{
				$vhosts_file .= 'Include ' . $settings['system']['apacheconf_directory'] . 
				                'diroptions.conf' . "\n\n";
			}

			$result_ipsandports=$db->query("SELECT CONCAT(`ip`.`ip`,':',`ip`.`port`) AS `ipandport` FROM `".TABLE_PANEL_DOMAINS."` `d` LEFT JOIN `".TABLE_PANEL_IPSANDPORTS."` `ip` ON (`d`.`ipandport` = `ip`.`id`) ORDER BY `ip`.`ip` ASC");
			while($ipandportresult=$db->fetch_array($result_ipsandports))
			{
				$ipandportarray[$ipandportresult['ipandport']] = $ipandportresult['ipandport'];
			}
			foreach($ipandportarray as $ipandport)
			{
				$vhosts_file.='NameVirtualHost '.$ipandport."\n";
			}
			$vhosts_file.="\n";

			$vhosts_file.='# DummyHost for DefaultSite'."\n";
			$vhosts_file.='<VirtualHost '.$settings['system']['ipaddress'].':80>'."\n";
			$vhosts_file.='ServerName '.$settings['system']['hostname']."\n";
			$vhosts_file.='</VirtualHost>'."\n"."\n";

			$result_domains=$db->query("SELECT `d`.`id`, `d`.`domain`, `d`.`customerid`, `d`.`documentroot`, CONCAT(`ip`.`ip`,':',`ip`.`port`) AS `ipandport`, `d`.`parentdomainid`, `d`.`isemaildomain`, `d`.`iswildcarddomain`, `d`.`openbasedir`, `d`.`safemode`, `d`.`speciallogfile`, `d`.`specialsettings`, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot` FROM `".TABLE_PANEL_DOMAINS."` `d` LEFT JOIN `".TABLE_PANEL_CUSTOMERS."` `c` USING(`customerid`) LEFT JOIN `".TABLE_PANEL_DOMAINS."` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) LEFT JOIN `".TABLE_PANEL_IPSANDPORTS."` `ip` ON (`d`.`ipandport` = `ip`.`id`) WHERE `d`.`deactivated` <> '1' AND `d`.`aliasdomain` IS NULL ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC");
			while($domain=$db->fetch_array($result_domains))
			{
				fwrite( $debugHandler, '  cron_tasks: Task1 - Writing Domain '.$domain['id'].'::'.$domain['domain']);
				$vhosts_file.='# Domain ID: '.$domain['id'].' - CustomerID: '.$domain['customerid'].' - CustomerLogin: '.$domain['loginname']."\n";
				$vhosts_file.='<VirtualHost '.$domain['ipandport'].'>'."\n";
				$vhosts_file.='  ServerName '.$domain['domain']."\n";

				$server_alias = '';
				$alias_domains = $db->query('SELECT `domain`, `iswildcarddomain` FROM `'.TABLE_PANEL_DOMAINS.'` WHERE `aliasdomain`=\''.$domain['id'].'\'');
				while(($alias_domain=$db->fetch_array($alias_domains)) !== false)
				{
					$server_alias .= ' '.$alias_domain['domain'].' '.(($alias_domain['iswildcarddomain']==1) ? '*' : 'www').'.'.$alias_domain['domain'];
				}
				if($domain['iswildcarddomain'] == '1')
				{
					$alias = '*';
				}
				else
				{
					$alias = 'www';
				}
				$vhosts_file.='  ServerAlias '.$alias.'.'.$domain['domain'].$server_alias."\n";
				$vhosts_file.='  ServerAdmin '.$domain['email']."\n";

				if(preg_match('/^https?\:\/\//', $domain['documentroot']))
				{
					$vhosts_file.='  Redirect / '.$domain['documentroot']."\n";
				}
				else
				{
					$domain['documentroot'] = makeCorrectDir ($domain['documentroot']);
					$vhosts_file.='  DocumentRoot "'.$domain['documentroot']."\"\n";
 					if($domain['openbasedir'] == '1')
 					{
						$vhosts_file.='  php_admin_value open_basedir "'.$domain['documentroot']."\"\n";
 					}
 					if($domain['safemode'] == '1')
 					{
 						$vhosts_file.='  php_admin_flag safe_mode On '."\n";
 					}
					if($domain['safemode'] == '0')
					{
						$vhosts_file.='  php_admin_flag safe_mode Off '."\n";
					}
 
 					if(!is_dir($domain['documentroot']))
 					{					
 						safe_exec('mkdir -p "'.$domain['documentroot'].'"');
						safe_exec('chown -R '.$domain['guid'].':'.$domain['guid'].' "'.$domain['documentroot'].'"');
					}
					if($domain['speciallogfile'] == '1')
					{
						if($domain['parentdomainid'] == '0')
						{
							$speciallogfile = '-'.$domain['domain'];
							$vhosts_file .= '   Alias /webalizer "'.$domain['customerroot'].'/webalizer/'.$domain['domain']."\"\n";
						}
						else
						{
							$speciallogfile = '-'.$domain['parentdomain'];
							$vhosts_file .= '   Alias /webalizer "'.$domain['customerroot'].'/webalizer/'.$domain['parentdomain']."\"\n";
						}
					}
					else
					{
						$speciallogfile = '';
					}
					$vhosts_file.='  ErrorLog "'.$settings['system']['logfiles_directory'].$domain['loginname'].$speciallogfile.'-error.log'."\"\n";
					$vhosts_file.='  CustomLog "'.$settings['system']['logfiles_directory'].$domain['loginname'].$speciallogfile.'-access.log" combined'."\n";
				}
				$vhosts_file.=stripslashes($domain['specialsettings'])."\n";
				$vhosts_file.='</VirtualHost>'."\n";
				$vhosts_file.="\n";
			}

			$vhosts_file_handler = fopen( $settings['system']['apacheconf_directory'] . 
			                              $settings['system']['apacheconf_filename'], 'w');
			fwrite($vhosts_file_handler, $vhosts_file);
			fclose($vhosts_file_handler);
			safe_exec($settings['system']['apachereload_command']);
			fwrite( $debugHandler, '   cron_tasks: Task1 - Apache reloaded');
		}

		/**
		 * TYPE=2 MEANS TO CREATE A NEW HOME AND CHOWN
		 */
		elseif($row['type'] == '2')
		{
			fwrite( $debugHandler, '  cron_tasks: Task2 started - create new home');
			if(is_array($row['data']))
			{
				safe_exec('mkdir -p "'.$settings['system']['documentroot_prefix'].$row['data']['loginname'].'/webalizer"');
				safe_exec('mkdir -p "'.$settings['system']['vmail_homedir'].$row['data']['loginname'].'"');
				safe_exec('cp -a '.$pathtophpfiles.'/templates/misc/standardcustomer/* "'.$settings['system']['documentroot_prefix'].$row['data']['loginname'].'/"');
				safe_exec('chown -R '.$row['data']['uid'].':'.$row['data']['gid'].' "'.$settings['system']['documentroot_prefix'].$row['data']['loginname'].'"');
				safe_exec('chown -R '.$settings['system']['vmail_uid'].':'.$settings['system']['vmail_gid'].' "'.$settings['system']['vmail_homedir'].$row['data']['loginname'].'"');
			}
		}

		/**
		 * TYPE=3 MEANS TO CREATE/CHANGE/DELETE A HTACCESS AND/OR HTPASSWD
		 */
		elseif($row['type'] == '3')
		{
			fwrite( $debugHandler, '  cron_tasks: Task3 started - create/change/del htaccess/htpasswd');
			if ( is_array($row['data']) )
			{
				$path = $row['data']['path'];
						fwrite( $debugHandler, '  cron_tasks: Task3 - Path: '.$path);
				
				if (!is_dir($path))
				{
					$db->query(
						'DELETE FROM `'.TABLE_PANEL_HTACCESS.'` ' .
						'WHERE `path` = "'.$path.'"'
					);
					$db->query(
						'DELETE FROM `'.TABLE_PANEL_HTPASSWDS.'` ' .
						'WHERE `path` = "'.$path.'"'
					);
				}
				
				$diroptions_file = '';
				$diroptions_file = '# '.$settings['system']['apacheconf_directory'].'diroptions.conf'."\n".'# Created '.date('d.m.Y H:i')."\n".'# Do NOT manually edit this file, all changes will be deleted after the next dir options change at the panel.'."\n"."\n";
				$result = $db->query(
					'SELECT * ' .
					'FROM `'.TABLE_PANEL_HTACCESS.'` ' .
					'ORDER BY `path`'
				);
				$diroptions = array();
				while($row_diroptions=$db->fetch_array($result))
				{
					$diroptions[$row_diroptions['path']] = $row_diroptions;
					$diroptions[$row_diroptions['path']]['htpasswds'] = array();
				}
				$result = $db->query(
					'SELECT * ' .
					'FROM `'.TABLE_PANEL_HTPASSWDS.'` ' .
					'ORDER BY `path`, `username`'
				);
				while($row_htpasswds=$db->fetch_array($result))
				{
					$diroptions[$row_htpasswds['path']]['path'] = $row_htpasswds['path'];
					$diroptions[$row_htpasswds['path']]['customerid'] = $row_htpasswds['customerid'];
					$diroptions[$row_htpasswds['path']]['htpasswds'][] = $row_htpasswds;
				}
				
				$htpasswd_files = array();
				foreach($diroptions as $row_diroptions)
				{
 					$diroptions_file .= '<Directory "'.$row_diroptions['path'].'">'."\n";
 					if ( isset ( $row_diroptions['options_indexes'] ) && $row_diroptions['options_indexes'] == '1' )
 					{
						$diroptions_file .= '  Options +Indexes'."\n";
						fwrite( $debugHandler, '  cron_tasks: Task3 - Setting Options +Indexes');
					}
					if ( isset ( $row_diroptions['options_indexes'] ) && $row_diroptions['options_indexes'] == '0' )
					{
						$diroptions_file .= '  Options -Indexes'."\n";
						fwrite( $debugHandler, '  cron_tasks: Task3 - Setting Options -Indexes');
 					}
 					if ( isset ( $row_diroptions['error404path'] ) && $row_diroptions['error404path'] != '')
 					{
						$diroptions_file .= '  ErrorDocument 404 "'.$row_diroptions['error404path']."\"\n";
					}
					if ( isset ( $row_diroptions['error403path'] ) && $row_diroptions['error403path'] != '')
					{
						$diroptions_file .= '  ErrorDocument 403 "'.$row_diroptions['error403path']."\"\n";
					}
//					if ( isset ( $row_diroptions['error401path'] ) && $row_diroptions['error401path'] != '')
//					{
//						$diroptions_file .= '  ErrorDocument 401 '.$row_diroptions['error401path']."\n";
//					}
					if ( isset ( $row_diroptions['error500path'] ) && $row_diroptions['error500path'] != '')
					{
						$diroptions_file .= '  ErrorDocument 500 "'.$row_diroptions['error500path']."\"\n";
					}
					
					if(count($row_diroptions['htpasswds']) > 0)
					{
						$htpasswd_file = '';
						$htpasswd_filename = '';
						foreach($row_diroptions['htpasswds'] as $row_htpasswd)
						{
							if($htpasswd_filename == '')
							{
								$htpasswd_filename = $settings['system']['apacheconf_directory'].'htpasswd/'.$row_diroptions['customerid'].'-'.$row_htpasswd['id'].'-'.md5($row_diroptions['path']).'.htpasswd';
								$htpasswd_files[] = basename($htpasswd_filename);
							}
							$htpasswd_file .= $row_htpasswd['username'].':'.$row_htpasswd['password']."\n";
						}
						fwrite( $debugHandler, '  cron_tasks: Task3 - Setting Password');
						$diroptions_file .= '  AuthType Basic'."\n";
						$diroptions_file .= '  AuthName "Restricted Area"'."\n";
						$diroptions_file .= '  AuthUserFile '.$htpasswd_filename."\n";
						$diroptions_file .= '  require valid-user'."\n";
						
						if(!file_exists($settings['system']['apacheconf_directory'].'htpasswd/')) 
						{
							$umask = umask();
							umask( 0000 );
							mkdir($settings['system']['apacheconf_directory'].'htpasswd/',0751);
							umask( $umask );
						}
						elseif(!is_dir($settings['system']['apacheconf_directory'].'htpasswd/'))
						{
							fwrite( $debugHandler, '  cron_tasks: WARNING!!! ' . $settings['system']['apacheconf_directory'].'htpasswd/ is not a directory. htpasswd directory protection is disabled!!!');
							echo 'WARNING!!! ' . $settings['system']['apacheconf_directory'].'htpasswd/ is not a directory. htpasswd directory protection is disabled!!!' ;
						}

						if(file_exists($settings['system']['apacheconf_directory'].'htpasswd/') && is_dir($settings['system']['apacheconf_directory'].'htpasswd/'))
						{
							$htpasswd_file_handler = fopen($htpasswd_filename, 'w');
							fwrite($htpasswd_file_handler, $htpasswd_file);
							fclose($htpasswd_file_handler);
						}
					}
					$diroptions_file .= '</Directory>'."\n\n";
				}
				$diroptions_file_handler = fopen($settings['system']['apacheconf_directory'].'diroptions.conf', 'w');
				fwrite($diroptions_file_handler, $diroptions_file);
				fclose($diroptions_file_handler);
				safe_exec($settings['system']['apachereload_command']);
				
				if(file_exists($settings['system']['apacheconf_directory'].'htpasswd/') && is_dir($settings['system']['apacheconf_directory'].'htpasswd/'))
				{
					$htpasswd_file_dirhandle = opendir($settings['system']['apacheconf_directory'].'htpasswd/');
					while(false !== ($htpasswd_filename = readdir($htpasswd_file_dirhandle))) 
					{
						if($htpasswd_filename != '.' && $htpasswd_filename != '..' && !in_array($htpasswd_filename,$htpasswd_files) && file_exists($settings['system']['apacheconf_directory'].'htpasswd/'.$htpasswd_filename)) 
						{
							unlink($settings['system']['apacheconf_directory'].'htpasswd/'.$htpasswd_filename);
						}
					}
				}
			}
		}

		/**
		 * TYPE=4 MEANS THAT SOMETHING IN THE BIND CONFIG HAS CHANGED. REBUILD syscp_bind.conf
		 */
		elseif($row['type'] == '4')
		{
			fwrite( $debugHandler, '  cron_tasks: Task4 started - Rebuilding syscp_bind.conf');
			$bindconf_file='# '.$settings['system']['bindconf_directory'].'syscp_bind.conf'."\n".'# Created '.date('d.m.Y H:i')."\n".'# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.'."\n"."\n";
			
			$result_domains=$db->query("SELECT `d`.`id`, `d`.`domain`, `d`.`customerid`, `d`.`zonefile`, `c`.`loginname`, `c`.`guid` FROM `".TABLE_PANEL_DOMAINS."` `d` LEFT JOIN `".TABLE_PANEL_CUSTOMERS."` `c` USING(`customerid`) WHERE `d`.`isbinddomain` = '1' ORDER BY `d`.`domain` ASC");
			while($domain=$db->fetch_array($result_domains))
			{
				fwrite( $debugHandler, '  cron_tasks: Task4 - Writing '.$domain['id'].'::'.$domain['domain']);
				if($domain['zonefile'] == '')
				{
					$domain['zonefile'] = $settings['system']['binddefaultzone'];
				}
				$bindconf_file.='# Domain ID: '.$domain['id'].' - CustomerID: '.$domain['customerid'].' - CustomerLogin: '.$domain['loginname']."\n";
				$bindconf_file.='zone "'.$domain['domain'].'" in {'."\n";
				$bindconf_file.='	type master;'."\n";
				$bindconf_file.='	file "'.$settings['system']['bindconf_directory'].$domain['zonefile'].'";'."\n";
				$bindconf_file.='	allow-query { any; };'."\n";
				$bindconf_file.='};'."\n";
				$bindconf_file.="\n";
			}
			$bindconf_file_handler = fopen($settings['system']['bindconf_directory'].'syscp_bind.conf', 'w');
			fwrite($bindconf_file_handler, $bindconf_file);
			fclose($bindconf_file_handler);
			fwrite( $debugHandler, '  cron_tasks: Task4 - syscp_bind.conf written');
			safe_exec($settings['system']['bindreload_command']);
			fwrite( $debugHandler, '  cron_tasks: Task4 - Bind9 reloaded');
		}
	}
	if( $db->num_rows( $result_tasks ) != 0 )
	{
		$where = array();
		
		foreach( $resultIDs as $id )
		{
			$where[] = '`id`=\''.$id.'\'';
		}
		$where = implode( $where, ' OR ');
		$db->query("DELETE FROM `".TABLE_PANEL_TASKS."` WHERE ".$where);
	}
 
?>