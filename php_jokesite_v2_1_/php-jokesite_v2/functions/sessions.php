<?
function bx_session_start()
{
	return session_start();
}

function bx_session_register($variable)
{
	return session_register($variable);
}

function bx_session_is_registered($variable)
{
	return session_is_registered($variable);
}

function bx_session_unregister($variable)
{
	return session_unregister($variable);
}

function bx_session_destroy()
{
	return session_destroy();
}

?>