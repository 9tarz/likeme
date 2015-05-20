<?php

/**
 * Class Registration
 * modified from https://github.com/panique/php-login-minimal
 */


class Registration
{

    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerUser();
        }
    }

    private function registerUser()
    {
        if (empty($_POST['username'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['password']) || empty($_POST['password_confirm'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['password'] !== $_POST['password_confirm']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['password']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['username'])
            && strlen($_POST['username']) <= 64
            && strlen($_POST['username']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
            && !empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['password'])
            && !empty($_POST['password_confirm'])
            && ($_POST['password'] === $_POST['password_confirm'])
        ) {
            $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) {

                $username = $this->db_connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));

                $password = $_POST['password'];
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM user WHERE username = '" . $username . "' OR email = '" . $email . "';";
                $query_check_username = $this->db_connection->query($sql);

                if ($query_check_username->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {

                    $sql = "INSERT INTO user (email, username, password) VALUES('" . $email . "', '" . $username . "', '" . $password_hashed . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    if ($query_new_user_insert) {
                        
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                        

                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
