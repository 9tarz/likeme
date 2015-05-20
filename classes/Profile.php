<?php

/**
 * Class Profile
 */

class Profile
{
	private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public $data = array();

    public function __construct()
    {
        session_start();

		if (isset($_GET["uid"]) AND empty($_POST["updateProfile"])) {
            $this->showProfile();
        } elseif (isset($_POST["updateProfile"]) AND $this->isProfileOwner()) {
           $this->updateProfile();
        } elseif (isset($_POST["updateProfile"]) AND $this->isProfileOwner() ) {
            $this->errors[] = "Sorry, No Permission";
        } else {
        	$this->errors[] = "Error!";
        }

    }

    private function showProfile()
    {
    	 if (empty($_GET['uid'])) {
            $this->errors[] = "No User";

         } elseif (!empty($_GET['uid'])) {

			$this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

			if (!$this->db_connection->set_charset("utf8")) {
				$this->errors[] = $this->db_connection->error;
			}

			if (!$this->db_connection->connect_errno) {
				$uid = $this->db_connection->real_escape_string($_GET['uid']);

				$sql = "SELECT first_name, last_name, about, updated_at FROM user_profile WHERE uid = '" . $uid . "';";
				$sql2 = "SELECT uid FROM user WHERE uid = '" . $uid . "';";
                $result_profile = $this->db_connection->query($sql);
                $result_check_uid_exist = $this->db_connection->query($sql2);
                if ($result_profile->num_rows == 1) {

                    $result_row = $result_profile->fetch_object();

                    $this->data["first_name"] = $result_row->first_name;
					$this->data["last_name"] = $result_row->last_name;
					$this->data["about"] = $result_row->about;

                    $date = new DateTime();
                    $date->setTimestamp($result_row->updated_at);
                    $this->data["last_updated_at"] = $date->format('Y-m-d H:i:s');


                } else {
                	if ($result_check_uid_exist->num_rows == 1) { //if User No Profile 
                        $this->data["first_name"] = "";
                        $this->data["last_name"] = "";
                        $this->data["about"] = "";

                        $this->data["last_updated_at"] = "";
                		$this->errors[] = "This user no profile. Please create new Profile";
                	} else {
                    	$this->errors[] = "This user does not exist.";
                    }
                }
			} else {

				$this->errors[] = "Database connection problem.";
			}
         } 
    }

    private function updateProfile()
    {

        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $first_name = $this->db_connection->real_escape_string(strip_tags($_POST['first_name'], ENT_QUOTES));
            $last_name = $this->db_connection->real_escape_string(strip_tags($_POST['last_name'], ENT_QUOTES));
            $about = $this->db_connection->real_escape_string(strip_tags($_POST['about'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            $sql = "SELECT profile_id FROM user_profile WHERE uid = '" . $uid . "';";
            $result_user_have_profile = $this->db_connection->query($sql);

            if ($result_user_have_profile->num_rows == 1) { //update Profile
                $sql = "UPDATE user_profile SET first_name = '" . $first_name . "', last_name = '" . $last_name . "', about = '" . $about . "', updated_at = '" . time() . "' ; ";
                $query_update_profile = $this->db_connection->query($sql);

                if ($query_update_profile) {
                    $this->messages[] = "Your profile has been updated successfully.";
                    $this->showProfile();
                } else {
                    $this->errors[] = "Sorry, your profile can not updated. Please go back and try again.";
                }


            } elseif ($result_user_have_profile->num_rows == 0) { //create new Profile (INSERT)

                $sql = "INSERT INTO user_profile (uid, first_name, last_name, about, created_at, updated_at) VALUES('" . $uid . "', '" . $first_name . "', '" . $last_name . "', '" . $about . "', '" . time() . "', '" . time() . "' );";
                $query_new_user_profile_insert = $this->db_connection->query($sql);

                if ($query_new_user_profile_insert) {
                    $this->messages[] = "Your profile has been created successfully.";
                    header("Location: profile.php?uid=" . $uid."");
                } else {
                    
                    $this->errors[] = "Sorry, new profile failed. Please go back and try again.";
                }

            } else {

                $this->errors[] = "Problem in Profile Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    public function isProfileOwner()
    {
        if (isset($_GET["uid"]) AND isset($_SESSION['uid'])) {
            if ($_GET["uid"] == $_SESSION['uid'])
                return true;
            else 
                return false;
        } else {
            return false;  
        }
    }


}