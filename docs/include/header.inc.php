<?php
/************************************************************************/
/* ATutor																*/
/************************************************************************/
/* Copyright (c) 2002-2004 by Greg Gay, Joel Kronenberg & Heidi Hazelton*/
/* Adaptive Technology Resource Centre / University of Toronto			*/
/* http://atutor.ca														*/
/*																		*/
/* This program is free software. You can redistribute it and/or		*/
/* modify it under the terms of the GNU General Public License			*/
/* as published by the Free Software Foundation.						*/
/************************************************************************/
if (!defined('AT_INCLUDE_PATH')) { exit; }

global $available_languages;
global $_rtl_languages;
global $page;
global $savant;
global $errors, $onload;
global $_base_href;
global $_user_location;

$savant->assign('tmpl_lang',	$available_languages[$_SESSION['lang']][2]);
$savant->assign('tmpl_title',	stripslashes(SITE_NAME));
$savant->assign('tmpl_charset', $available_languages[$_SESSION['lang']][1]);
$savant->assign('tmpl_base_href', $_base_href);

$savant->assign('tmpl_breadcrumbs', TRUE);

if (in_array($_SESSION['lang'], $_rtl_languages)) {
	$savant->assign('tmpl_rtl_css', '<link rel="stylesheet" href="'.$_base_path.'rtl.css" type="text/css" />');
} else {
	$savant->assign('tmpl_rtl_css', '');
}

if (!isset($errors) && $onload) {
	$savant->assign('tmpl_onload', $onload);
}

$savant->assign('tmpl_page', $page);

	if ($_SESSION['valid_user'] === true) {
		$savant->assign('tmpl_user_name', AT_print($_SESSION['login'], 'members.login'));
	} else {
		$savant->assign('tmpl_user_name', _AT('guest'));
	}

header('Content-Type: text/html; charset='.$available_languages[$_SESSION['lang']][1]);

if ($_user_location == 'public') {
	/* the public section */
	if (defined('HOME_URL') && HOME_URL) {
		$nav[] = array('name' => _AT('home'),  'url' => HOME_URL);
	}

	$nav[] = array('name' => _AT('register'),          'url' => 'registration.php',     'page' => 'register');
	$nav[] = array('name' => _AT('browse_courses'),    'url' => 'browse.php',           'page' => 'browse');
	$nav[] = array('name' => _AT('login'),             'url' => 'login.php',            'page' => 'login');
	$nav[] = array('name' => _AT('password_reminder'), 'url' => 'password_reminder.php','page' => 'password_reminder');

	$savant->assign('tmpl_nav', $nav);
	$savant->assign('tmpl_section', '[not sure of the section name?]');

} else if ($_user_location == 'admin') {
	/* the /admin/ section */

	$nav[] = array('name' => _AT('home'),                   'url' => 'admin/index.php',            'page' => 'home');
	$nav[] = array('name' => _AT('users'),                  'url' => 'admin/users.php',            'page' => 'users');
	$nav[] = array('name' => _AT('courses'),                'url' => 'admin/courses.php',          'page' => 'courses');
	$nav[] = array('name' => _AT('cats_course_categories'), 'url' => 'admin/course_categories.php','page' => 'course_cats');
	$nav[] = array('name' => _AT('language'),               'url' => 'admin/language.php',         'page' => 'language');
	$nav[] = array('name' => _AT('server_configuration'),   'url' => 'admin/config_info.php',      'page' => 'server_config');
	$nav[] = array('name' => _AT('logout'),                 'url' => 'logout.php',                 'page' => 'logout');

	$savant->assign('tmpl_nav', $nav);
	$savant->assign('tmpl_section', _AT('administration'));

} else {

	global $system_courses, $db;

	$sql	= "SELECT E.course_id FROM ".TABLE_PREFIX."course_enrollment E WHERE E.member_id=$_SESSION[member_id] AND E.approved='y'";
	$result = mysql_query($sql, $db);

	$nav_courses = array();
	while ($row = mysql_fetch_assoc($result)) {
		$nav_courses[] = array('course_id' => $row['course_id'], 'title' => $system_courses[$row['course_id']]['title']);
	}


	$nav[] = array('name' => _AT('home'),          'url' => $_base_path . 'index.php',             'page' => 'home',        'id' => 'home-nav');
	$nav[] = array('name' => _AT('tools'),         'url' => $_base_path . 'tools/index.php',       'page' => 'tools',       'id' => 'tools-nav');
	$nav[] = array('name' => _AT('resources'),     'url' => $_base_path . 'resources/index.php',   'page' => 'resources',   'id' => 'resources-nav');
	$nav[] = array('name' => _AT('discussions'),   'url' => $_base_path . 'discussions/index.php', 'page' => 'discussions', 'id' => 'discussions-nav');
	$nav[] = array('name' => _AT('sitemap'),       'url' => $_base_path . 'tools/sitemap/index.php', 'page' => 'sitemap',   'id' => 'sitemap-nav');


	$savant->assign('tmpl_course_nav', $nav);
	unset($nav);

	$nav[] = array('name' => _AT('my_courses'),     'url' => $_base_path . 'users/index.php',        'page' => 'my_courses',        'id' => '');
	$nav[] = array('name' => _AT('preferences'), 'url' => $_base_path . 'users/preferences.php',  'page' => 'preferences',        'id' => '');
	$nav[] = array('name' => _AT('profile'),     'url' => $_base_path . 'users/edit.php',        'page' => 'profile',        'id' => '');
	$nav[] = array('name' => _AT('browse_courses'), 'url' => $_base_path . 'users/browse.php',        'page' => 'browse_courses',        'id' => '');
	$nav[] = array('name' => _AT('inbox'),          'url' => $_base_path . 'inbox.php',        'page' => 'inbox',        'id' => '');
	//$nav[] = array('name' => _AT('create_course'),                 'url' => $_base_path . 'user/index.php',        'page' => 'help',        'id' => '');
	$nav[] = array('name' => _AT('help'),           'url' => $_base_path . 'help/index.php',        'page' => 'help',        'id' => '');
	$nav[] = array('name' => 'jump_menu');
	if ($_SESSION['valid_user'] === true) {
		$nav[] = array('name' => _AT('logout'),                 'url' => 'logout.php',        'page' => 'logout');
	} else {
		$nav[] = array('name' => _AT('login'),                 'url' => 'login.php?course='.$_SESSION['course_id'], 'page' => 'login');
	}

	/* the instructor nav bar */
	if (show_pen()) {
		if ($_SESSION['prefs']['PREF_EDIT'] == 0) {
			$instructor_nav[] = array('name' => _AT('enable_editor'), 'url' =>  $_my_uri.'enable='.PREF_EDIT,        'page' => 'enable_editor',        'id' => 'enable-editor-user-nav');
		} else {
			$instructor_nav[] = array('name' => _AT('disable_editor'),'url' => $_my_uri.'disable='.PREF_EDIT,        'page' => 'disable_editor',        'id' => 'disable-editor-user-nav');
		}
	}

	if (authenticate(AT_PRIV_ENROLLMENT, AT_PRIV_RETURN)) {	
		$instructor_nav[] = array('name' => _AT('course_enrolment'),	'url' => $_base_path . 'tools/enroll_admin.php', 'page' => 'enrollment', 'id' => 'enroll-instructor-nav');
	}
	if (authenticate(AT_PRIV_FILES, AT_PRIV_RETURN)) {
		$instructor_nav[] = array('name' => _AT('file_manager'),        'url' => $_base_path . 'tools/file_manager.php',	'page' => 'file_manager',        'id' => 'files-instructor-nav');
	}
	if (authenticate(AT_PRIV_TEST_CREATE, AT_PRIV_RETURN) || authenticate(AT_PRIV_TEST_MARK, AT_PRIV_RETURN)) {
		$instructor_nav[] = array('name' => _AT('test_manager'),		'url' => $_base_path . 'tools/tests/',       'page' => 'tests',       'id' => 'tests-instructor-nav');
	}
	if (authenticate(AT_PRIV_ADMIN, AT_PRIV_RETURN)) { 
		$instructor_nav[] = array('name' => _AT('course_properties'),   'url' => $_base_path . 'tools/course_properties.php',   'page' => 'course_properties',   'id' => 'props-instructor-nav');
	}

	$savant->assign('tmpl_nav', $nav);
	$savant->assign('tmpl_nav_courses', $nav_courses);
	$savant->assign('tmpl_user_nav', $user_nav);
	$savant->assign('tmpl_section', $_SESSION['course_title']);
	$savant->assign('tmpl_instructor_nav', $instructor_nav);	/* instructor nav bar */
}

$savant->display('include/header_footer/header.tmpl.php');

if ($_SESSION['course_id'] > 0) {
	require(AT_INCLUDE_PATH.'course_header.inc.php');
}

?>