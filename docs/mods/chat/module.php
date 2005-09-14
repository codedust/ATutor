<?php
if (!defined('AT_INCLUDE_PATH')) { exit; }

define('AT_PRIV_CHAT', $this->getPrivilege());

// if this module is to be made available to students on the Home or Main Navigation
$_student_tools = array('chat/index.php');

$_module_pages['tools/chat/index.php']['title_var'] = 'chat';
$_module_pages['tools/chat/index.php']['parent']    = 'tools/index.php';
$_module_pages['tools/chat/index.php']['children']  = array('tools/chat/start_transcript.php');
$_module_pages['tools/chat/index.php']['guide']     = 'instructor/?p=3.0.chat.php';

	$_module_pages['tools/chat/start_transcript.php']['title_var']  = 'chat_start_transcript';
	$_module_pages['tools/chat/start_transcript.php']['parent'] = 'tools/chat/index.php';

	$_module_pages['tools/chat/delete_transcript.php']['title_var']  = 'chat_delete_transcript';
	$_module_pages['tools/chat/delete_transcript.php']['parent'] = 'tools/chat/index.php';

	$_module_pages['tools/chat/view_transcript.php']['title_var']  = 'chat_transcript';
	$_module_pages['tools/chat/view_transcript.php']['parent'] = 'tools/chat/index.php';

$_module_pages['chat/index.php']['title_var'] = 'chat';
$_module_pages['chat/index.php']['img']       = 'images/home-chat.gif';

	$_module_pages['chat/chat_frame.php']['title_var'] = 'chat';
	$_module_pages['chat/chat_frame.php']['parent']    = 'chat/index.php';

	$_module_pages['chat/view_transcript.php']['title_var'] = 'chat_transcript';
	$_module_pages['chat/view_transcript']['parent']        = 'chat/index.php';
	
?>