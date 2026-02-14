<?php

function getUser($username)
{
	$raw = file_get_contents('users.json');
	$users = json_decode($raw, true);
	if (!$users) {
		return [];
	}
	if (isset($users[$username])) {
		return $users[$username];
	}
	return [];
}

function verifyPassword($username, $password)
{
	$user = getUser($username);
	if (empty($user)) {
		return false;
	}
	return ($user['password'] === md5($password));
}
