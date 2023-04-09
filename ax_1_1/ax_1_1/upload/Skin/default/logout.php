<?
class LogOut {
	function LogOut() {
		global $functions;
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		$url='index.php?do=';
		$functions->do_redirect($url);
		$functions->do_copyright();
	}
}
?>