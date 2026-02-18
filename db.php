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

function saveUser($username, $password){

	$raw = file_get_contents('users.json');
    $users = json_decode($raw, true);

    if (isset($users[$username])) {
        return false;
    }
	$users[$username] = [
        "username" => $username,
        "password" => md5($password)
    ];
	// uso json pretty print cosi il file resta formattato 
	file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
    return true;
}