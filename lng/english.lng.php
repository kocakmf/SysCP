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
 * @author Florian Lippert <flo@redenswert.de>
 * @copyright (C) 2003-2004 Florian Lippert
 * @package Language
 * @version $Id$
 */


/**
 * Global
 */
$lng['panel']['edit'] = 'edit';
$lng['panel']['delete'] = 'delete';
$lng['panel']['create'] = 'create';
$lng['panel']['save'] = 'save';
$lng['panel']['yes'] = 'yes';
$lng['panel']['no'] = 'no';
$lng['panel']['emptyfornochanges'] = 'empty for no changes';
$lng['panel']['emptyfordefault'] = 'empty for defaults';
$lng['panel']['path'] = 'Path';

/**
 * Login
 */
$lng['login']['username'] = 'Username';
$lng['login']['password'] = 'Password';
$lng['login']['language'] = 'Language';
$lng['login']['login'] = 'Login';
$lng['login']['logout'] = 'logout';

/**
 * Customer
 */
$lng['customer']['login'] = 'Username';
$lng['customer']['documentroot'] = 'Homedir';
$lng['customer']['name'] = 'Name';
$lng['customer']['surname'] = 'Surname';
$lng['customer']['company'] = 'Company';
$lng['customer']['street'] = 'Street';
$lng['customer']['zipcode'] = 'Zipcode';
$lng['customer']['city'] = 'city';
$lng['customer']['phone'] = 'phone';
$lng['customer']['fax'] = 'fax';
$lng['customer']['email'] = 'email';
$lng['customer']['customernumber'] = 'Customerid';
$lng['customer']['diskspace'] = 'Webspace (MB)';
$lng['customer']['traffic'] = 'Traffic (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databases';
$lng['customer']['emails'] = 'eMail-Addresses';
$lng['customer']['forwarders'] = 'eMail-Forwarders';
$lng['customer']['ftps'] = 'FTP-Accounts';
$lng['customer']['subdomains'] = 'Sub-Domain(s)';
$lng['customer']['domains'] = 'Domain(s)';
$lng['customer']['unlimited'] = 'unlimited';

/**
 * Customermenue
 */
$lng['menue']['main']['main'] = 'Main';
$lng['menue']['main']['changepassword'] = 'Change password';
$lng['menue']['email']['email'] = 'eMail';
$lng['menue']['email']['pop'] = 'Accounts';
$lng['menue']['email']['forwarders'] = 'Forwarders';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databases';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domains';
$lng['menue']['domains']['settings'] = 'Settings';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Accounts';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Directory protection';
$lng['menue']['extras']['pathoptions'] = 'path options';

/**
 * Index
 */
$lng['index']['customerdetails'] = 'Customerdetails';
$lng['index']['accountdetails'] = 'Accountdetails';

/**
 * Change Password
 */
$lng['changepassword']['old_password'] = 'Old password';
$lng['changepassword']['new_password'] = 'New password';
$lng['changepassword']['new_password_confirm'] = 'New password (confirm)';
$lng['changepassword']['also_change_ftp'] = ' also change password of the main ftp-account';

/**
 * Domains
 */
$lng['domains']['description'] = 'Here you can create (Sub-)Domains and change their paths.<br />The system will need some time to apply the new settings after every change.';
$lng['domains']['domainsettings'] = 'Domainsettings';
$lng['domains']['domainname'] = 'Domainname';
$lng['domains']['subdomain_add'] = 'Create subdomain';
$lng['domains']['subdomain_edit'] = 'Edit (sub)domain';
$lng['domains']['wildcarddomain'] = 'Create as wildcarddomain?';

/**
 * eMails
 */
$lng['emails']['description'] = 'Here you can create and change your Mailboxes.<br />An account is like your letterbox in front of your house. If someone sends you an email, it will be dropped into the account.<br><br>To download your emails use the following settings in your mailprogram: (The data in <i>italics</i> have to be changed into the equivalents you typed in!)<br>Hostname: <b><i>Domainname</i></b><br>Username: <b><i>Accountname / eMail-address</i></b><br>Password: <b><i>the password you\'ve chosen</i></b>';
$lng['emails']['forwarders_add'] = 'Create forwarder';
$lng['emails']['from'] = 'Source';
$lng['emails']['to'] = 'Destination';
$lng['emails']['pop3_add'] = 'Create account';
$lng['emails']['emailaddress'] = 'Accountname/eMail-address';

/**
 * FTP
 */
$lng['ftp']['description'] = 'Here you can simply create and change your FTP-Accounts.<br>The changes are made instantly and the accounts can be used immediately.';
$lng['ftp']['account_add'] = 'Create Account';

/**
 * MySQL
 */
$lng['mysql']['description'] = 'Here you can simply create and change your MySQL-Databases.<br>The changes are made instantly and the database can be used immediately.<br>At the menu on the left side you find the tool phpMyAdmin with which you can easily administer your database.<br><br>To use your databases in your own php-scripts use the following settings: (The data in <i>italics</i> have to be changed into the equivalents you typed in!)<br>Hostname: <b>localhost</b><br>Username: <b><i>Databasename</i></b><br>Password: <b><i>the password you\'ve chosen</i></b><br>Database: <b><i>Databasename';
$lng['mysql']['databasename'] = 'User/Databasename';
$lng['mysql']['database_create'] = 'Create database';

/**
 * Extras
 */
$lng['extras']['description'] = 'Here you can add some extras for example the directory protection.<br />The system will need some time to apply the new settings after every change.';
$lng['extras']['directoryprotection_add'] = 'Add directory protection';
$lng['extras']['view_directory'] = 'display directory content';
$lng['extras']['pathoptions_add'] = 'add path options';
$lng['extras']['directory_browsing'] = 'directory content browsing';
$lng['extras']['pathoptions_edit'] = 'edit path options';

/**
 * Errors
 */
$lng['error']['error'] = 'Error';
$lng['error']['directorymustexist'] = 'The directory you typed in has to exist. Please create it with your FTP-programme.';
$lng['error']['domains_cantdeletemaindomain'] = 'You cannot delete a domain which is used as an email-domain.';
$lng['error']['firstdeleteallsubdomains'] = 'You have to delete all Subdomains first before you can create a wildcarddomain.';
$lng['error']['ftp_cantdeletemainaccount'] = 'You cannot delete your main FTP-account';
$lng['error']['login'] = 'The username or password you typed in is wrong. Please try it again!';
$lng['error']['login_blocked'] = 'This account has been suspended because of too many loginerrors. <br />Please try again in '.$settings['login']['deactivatetime'].' seconds.';
$lng['error']['notallreqfieldsorerrors'] = 'You have not filled in all or filled in some fields incorrectly.';
$lng['error']['oldpasswordnotcorrect'] = 'The old password is not correct.';
$lng['error']['youcantallocatemorethanyouhave'] = 'You cannot allocate more ressources than you own for yourself.';
$lng['error']['youcantdeletechangemainadmin'] = 'You cannot delete or edit the main admin for security reasons.';

/**
 * Questions
 */
$lng['question']['question'] = 'Securityquestion';
$lng['question']['admin_customer_reallydelete'] = 'Do you really want to delete this customer? This cannot be undone!';
$lng['question']['admin_domain_reallydelete'] = 'Do you really want to delete this domain?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Do you really want to deactivate these Securitysettings (OpenBasedir and/or SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Do you really want to delete this admin? Every customer and domain will be reallocated to the mainadmin.';
$lng['question']['domains_reallydelete'] = 'Do you really want to delete this domain?';
$lng['question']['email_reallydelete_forwarders'] = 'Do you really want to delete this forwarder?';
$lng['question']['email_reallydelete_pop'] = 'Do you really want to delete this email-account?';
$lng['question']['extras_reallydelete'] = 'Do you really want to delete this directory protection?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Do you really want to delete these path options?';
$lng['question']['ftp_reallydelete'] = 'Do you really want to delete this FTP-account?';
$lng['question']['mysql_reallydelete'] = 'Do you really want to delete this database? This cannot be undone!';

/**
 * Mails
 */
$lng['mails']['pop_success']['mailbody'] = 'Hello,\n\nyour POP3-account $email\nwas set up successfully.\n\nThis is an automatically created\neMail, please do not answer!\n\nYours, the SysCP-Team';
$lng['mails']['pop_success']['subject'] = 'POP3-account set up successfully';
$lng['mails']['createcustomer']['mailbody'] = 'Hello $surname $name,\n\nhere are your accountinformationen:\n\nUsername: $loginname\nPassword: $password\n\nThank you,\nthe SysCP-Team';
$lng['mails']['createcustomer']['subject'] = 'Accountinformationen';

/**
 * Admin
 */
$lng['admin']['overview'] = 'Overview';
$lng['admin']['ressourcedetails'] = 'Used ressources';
$lng['admin']['systemdetails'] = 'Systemdetails';
$lng['admin']['syscpdetails'] = 'SysCP-Details';
$lng['admin']['installedversion'] = 'Installed Version';
$lng['admin']['latestversion'] = 'Latest Version';
$lng['admin']['lookfornewversion']['clickhere'] = 'sarch via webservice';
$lng['admin']['lookfornewversion']['error'] = 'Error while reading';
$lng['admin']['customer'] = 'Customer';
$lng['admin']['customers'] = 'Customers';
$lng['admin']['customer_add'] = 'Create customer';
$lng['admin']['customer_edit'] = 'Edit customer';
$lng['admin']['domains'] = 'Domains';
$lng['admin']['domain_add'] = 'Create domain';
$lng['admin']['domain_edit'] = 'Edit domain';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = 'Create admin';
$lng['admin']['admin_edit'] = 'Edit admin';
$lng['admin']['customers_see_all'] = 'Can see all customers?';
$lng['admin']['domains_see_all'] = 'Can see all domains?';
$lng['admin']['change_serversettings'] = 'Can change serversettings?';
$lng['admin']['serversettings'] = 'Serversettings';
$lng['admin']['stdsubdomain'] = 'Standardsubdomain';
$lng['admin']['stdsubdomain_add'] = 'Create standardsubdomain';
$lng['admin']['deactivated'] = 'Deactivated';
$lng['admin']['deactivated_user'] = 'Deactivate User';
$lng['admin']['sendpassword'] = 'Send password';
$lng['admin']['ownvhostsettings'] = 'Own vHost-Settings';

/**
 * Serversettings
 */
$lng['serversettings']['session_timeout']['title'] = 'Session Timeout';
$lng['serversettings']['session_timeout']['description'] = 'How long does a user have to be inactive before a session gets invalid (seconds)?';
$lng['serversettings']['catachallkeyword']['title'] = 'Catchall-Keyword';
$lng['serversettings']['catachallkeyword']['description'] = 'Which email-address should automatically be a catchall-account?';
$lng['serversettings']['accountprefix']['title'] = 'Customerprefix';
$lng['serversettings']['accountprefix']['description'] = 'Which prefix should customeraccounts have?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL-Prefix';
$lng['serversettings']['mysqlprefix']['description'] = 'Which prefix should mysqlaccounts have?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP-Prefix';
$lng['serversettings']['ftpprefix']['description'] = 'Which prefix should ftpaccounts have?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Documentdirectory';
$lng['serversettings']['documentroot_prefix']['description'] = 'Where should all data be stored?';
$lng['serversettings']['logfiles_directory']['title'] = 'Logfilesdirectory';
$lng['serversettings']['logfiles_directory']['description'] = 'Where should all logfiles be stored?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Addres';
$lng['serversettings']['ipaddress']['description'] = 'What\'s the IP-address of this server?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'What is the Hostname of this server?';
$lng['serversettings']['apacheconf_directory']['title'] = 'Apache-Config-Directory';
$lng['serversettings']['apacheconf_directory']['description'] = 'Where are the apache configfiles?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache-Reload-Command';
$lng['serversettings']['apachereload_command']['description'] = 'What\'s the apache reloadcommand?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind-Config-Directory';
$lng['serversettings']['bindconf_directory']['description'] = 'Where are the bind configfiles?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind-Reload-Command';
$lng['serversettings']['bindreload_command']['description'] = 'What\'s the bind reloadcommand?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind-Default-Zone';
$lng['serversettings']['binddefaultzone']['description'] = 'What\'s the name of the default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Which UserID should mails have?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Which GroupID should mails have?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Where should all mails be stored?';
$lng['serversettings']['adminmail']['title'] = 'Sender';
$lng['serversettings']['adminmail']['description'] = 'What\'s the senderaddress for emails sent from the Panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin-URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'What\'s the URL to the phpMyAdmin?';
$lng['serversettings']['webmail_url']['title'] = 'WebMail-URL';
$lng['serversettings']['webmail_url']['description'] = 'What\'s the URL to the WebMail?';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP-URL';
$lng['serversettings']['webftp_url']['description'] = 'What\'s the URL to the WebFTP?';

?>