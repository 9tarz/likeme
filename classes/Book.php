<?php
/**
 * Class Profile
 */

class Book
{   
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public $data = array();

	public function __construct()
    {

		if (isset($_GET["uid"]) AND empty($_POST["updateProfile"])) {
            $this->showProfile();
        } else {
        	$this->errors[] = "Error!";
        }

    }

	private function addBook()
    {

        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $isbn = $this->db_connection->real_escape_string(strip_tags($_POST['first_name'], ENT_QUOTES));
            $book_name = $this->db_connection->real_escape_string(strip_tags($_POST['last_name'], ENT_QUOTES));
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

}

?>