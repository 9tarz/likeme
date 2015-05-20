<?php
/**
 * Class Authentication
 * modified from https://github.com/panique/php-login-minimal
 */


class Auth
{
	private $db_connection = null;

	public $errors = array();

	public $messages = array();

	public function __construct()
	{
		session_start();

		if (isset($_GET['signout'])) {

			$this->signout();

		} elseif (isset($_POST['signin'])) {

			$this->signin();
			
		}
	}

	private function signin()
	{
		if (empty($_POST['username'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
        	$this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        	$this->db_connection->set_charset("utf8");

        	if (!$this->db_connection->connect_errno) {

        		$username = $this->db_connection->real_escape_string($_POST['username']);

                $sql = "SELECT uid, email, username, password FROM user WHERE username = '" . $username . "';";
                $result_check_username_email = $this->db_connection->query($sql);

                if ($result_check_username_email->num_rows == 1) {

                    $result_row = $result_check_username_email->fetch_object();

                    if (password_verify($_POST['password'], $result_row->password)) {

                        $_SESSION['username'] = $result_row->username;
                        $_SESSION['uid'] = $result_row->uid;
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['signin_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }

                } else {
                    $this->errors[] = "This user does not exist.";
                }
        	} else {
        		$this->errors[] = "Database connection problem.";
        	}
       	}
	}

	public function signout()
	{
		$_SESSION = array();
		session_destroy();
		$this->messages[] = "Signout complete";
	}

	public function isUserSignin()
	{
		if (isset($_SESSION['signin_status']) AND $_SESSION['signin_status'] == 1) {
			return true;
		} else {
			return false;  
		}
	}

}



?>