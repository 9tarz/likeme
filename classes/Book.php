<?php
/**
 * Class Book
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
            $this->showUserBook();

        } else if (isset($_GET["searchKeyword"]) AND empty($_GET["uid"])) {

            $this->searchBook();

        } else if (isset($_POST["createBook"])) {

            $this->createBook();

        } else if (isset($_GET["addBook"]) AND isset($_GET["book_id"])) {

            $this->addBook();

        } else if (isset($_GET["deleteBook"]) AND isset($_GET["book_id"])) {

            $this->deleteBook();

        } else if (isset($_GET["showBook"]) AND isset($_GET["book_id"])) {

            $this->showBook();

        } else if (isset($_GET["updateBook"]) AND isset($_GET["book_id"]) AND empty($_POST["updateBook"])) {

            $this->showBook();

        } else if (isset($_GET["updateBook"]) AND isset($_GET["book_id"]) AND isset($_POST["updateBook"])) {

            $this->updateBook();
                
        } else {
        	$this->errors[] = "Error!";
        }

    }

    private function showUserBook()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $uid = $this->db_connection->real_escape_string(strip_tags($_GET['uid'], ENT_QUOTES));

            $sql = "SELECT book.book_id as book_id, book.name as book_name ,book.description as book_description 
                    FROM book,user_book 
                    WHERE book.book_id = user_book.book_id AND user_book.uid = '" . $uid . "';";

            $result_user_book = $this->db_connection->query($sql);

            if ($result_user_book) { 

                    while ($result_row = $result_user_book->fetch_assoc()) {

                        $this->data[] = $result_row;
                    }
                    $result_user_book->free();

            } else {

                $this->errors[] = "Problem in User Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function showBook()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));

            $sql = "SELECT book_id, ISBN, name, description, created_at, updated_at
                    FROM book
                    WHERE book_id = '" . $book_id . "';";

            $result_book = $this->db_connection->query($sql);

            $result_book_row = $result_book->fetch_object();

            if ($result_book->num_rows == 1) { 

                $this->data["book_id"] = $result_book_row->book_id;
                $this->data["book_ISBN"] = $result_book_row->ISBN;
                $this->data["book_name"] = $result_book_row->name;
                $this->data["book_description"] = $result_book_row->description;

                $created_date = new DateTime();
                $created_date->setTimestamp($result_book_row->created_at);
                $this->data["created_at"] = $created_date->format('Y-m-d H:i:s');

                $updated_date = new DateTime();
                $updated_date->setTimestamp($result_book_row->updated_at);
                $this->data["updated_at"] = $updated_date->format('Y-m-d H:i:s');

            } else if ($result_book->num_rows == 0) {

                $this->errors[] = "No book!";

            } else {

                $this->errors[] = "Problem in User Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }

    }


    private function updateBook()
    {

        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $book_name = $this->db_connection->real_escape_string(strip_tags($_POST['book_name'], ENT_QUOTES));
            $book_description = $this->db_connection->real_escape_string(strip_tags($_POST['book_description'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            $sql = "SELECT book_id 
                    FROM  book
                    WHERE name = '" . $book_name . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            $result_is_book_exist_row = $result_is_book_exist->fetch_object();

            $book_id = $result_is_book_exist_row->book_id;

            if ($result_is_book_exist->num_rows == 1) { // this book is exist

                $sql = "UPDATE book
                        SET name = '" . $book_name . "', description = '" . $book_description . "', updated_at = '" . time() . "', updated_by = '" . $uid . "'
                        WHERE book_id = '" . $book_id . "' ; ";

                $query_update_book = $this->db_connection->query($sql);

                $this->messages[] = "This book has been updated successfully.";
                header("Location: book.php?showBook&book_id=" . $book_id . "");

            } elseif ($result_is_book_exist->num_rows == 0) { 
                
                $this->errors[] = "Book Not Found!";

            } else {

                $this->errors[] = "Problem in Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function searchBook()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $search_keyword = $this->db_connection->real_escape_string(strip_tags($_GET['searchKeyword'], ENT_QUOTES));

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT book_id , name as book_name , description as book_description 
                    FROM book
                    WHERE name like '%" . $search_keyword . "%' OR ISBN like '%". $search_keyword . "%';";

            $result_search_book = $this->db_connection->query($sql);

            if ($result_search_book) { 

                    while ($result_row = $result_search_book->fetch_assoc()) {

                        $this->data[] = $result_row;
                    }

                    $result_search_book->free();

            } else {

                $this->errors[] = "Problem in Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }



	private function createBook()
    {

        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $isbn = $this->db_connection->real_escape_string(strip_tags($_POST['book_isbn'], ENT_QUOTES));
            $book_name = $this->db_connection->real_escape_string(strip_tags($_POST['book_name'], ENT_QUOTES));
            $book_description = $this->db_connection->real_escape_string(strip_tags($_POST['book_description'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            $sql = "SELECT book_id 
                    FROM  book
                    WHERE name = '" . $book_name . "' OR ISBN = '". $isbn . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            if ($result_is_book_exist->num_rows >= 1) { // this book is exist

                    $this->errors[] = "Sorry, This book is exist.";

            } elseif ($result_is_book_exist->num_rows == 0) { //create new Book (INSERT)

                $sql = "INSERT INTO book (ISBN, name, description, created_at, updated_at, created_by, updated_by) 
                        VALUES('" . $isbn . "', '" . $book_name . "', '" . $book_description . "', '" . time() . "', '" . time() . "', '" . $uid . "', '"  . $uid . "' );";
                $query_insert_newbook = $this->db_connection->query($sql);

                if ($query_insert_newbook) {
                    $this->messages[] = "Book has been created successfully.";
                    header("Location: profile.php?uid=" . $uid."&editProfile");
                } else {
                    
                    $this->errors[] = "Sorry, new book failed. Please go back and try again.";
                }

            } else {

                $this->errors[] = "Problem in Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }


    private function addBook()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            $sql = "SELECT book_id 
                    FROM  book
                    WHERE book_id = '" . $book_id . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            $sql2 = "SELECT user_book_id, created_at
                    FROM  user_book
                    WHERE book_id = '" . $book_id . "' AND uid = '" .$uid . "' ;";

            $result_is_user_book_exist = $this->db_connection->query($sql2);


            if ($result_is_book_exist->num_rows == 1 AND $result_is_user_book_exist->num_rows == 0) { // this book is exist

                $sql = "INSERT INTO user_book
                        (book_id, uid, created_at) 
                        VALUES('" . $book_id . "', '" . $uid . "', '" . time() . "');";

                $query_insert_user_book = $this->db_connection->query($sql);
                $this->messages[] = "Book has been added successfully.";
                header("Location: profile.php?uid=" . $uid."&editProfile");

            } else if ($result_is_book_exist->num_rows == 0) { 
                    $this->errors[] = "Sorry, this book isn't in database";

            } else if ($result_is_user_book_exist->num_rows == 1) {
                    $result_row = $result_is_user_book_exist->fetch_object();
                    $date = new DateTime();
                    $date->setTimestamp($result_row->created_at);
                    $this->errors[] = "You already added this book at " .$date->format('Y-m-d H:i:s'). "" ;

            } else {
                $this->errors[] = "Problem in Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    public function deleteBook()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            $sql = "SELECT book_id 
                    FROM  book
                    WHERE book_id = '" . $book_id . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            $sql2 = "SELECT user_book_id, created_at
                    FROM  user_book
                    WHERE book_id = '" . $book_id . "' AND uid = '" .$uid . "' ;";

            $result_is_user_book_exist = $this->db_connection->query($sql2);

            $result_is_user_book_row = $result_is_user_book_exist->fetch_object();

            if ($result_is_book_exist->num_rows == 1 AND $result_is_user_book_exist->num_rows == 1) {

                $sql = "DELETE FROM user_book 
                       WHERE user_book_id = '" . $result_is_user_book_row->user_book_id . "';";

                $query_insert_user_book = $this->db_connection->query($sql);
                $this->messages[] = "Book has been deleted successfully.";

                header("Location: profile.php?uid=" . $uid."&editProfile");

            } else if ($result_is_book_exist->num_rows == 0) { 
                    $this->errors[] = "Sorry, this book isn't in database";

            } else if ($result_is_user_book_exist->num_rows == 0) {
                    $this->errors[] = "You don't have this book";
            } else {
                $this->errors[] = "Problem in Book Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    public function isCreateBook()
    {
        if (isset($_GET["createBook"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isSearchBook()
    {
        if (isset($_GET["searchKeyword"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isAddBook()
    {
        if (isset($_GET["addBook"]) AND isset($_GET["book_id"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isShowBook()
    {
        if (isset($_GET["showBook"]) AND isset($_GET["book_id"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isUpdateBook()
    {
        if (isset($_GET["updateBook"]) AND isset($_GET["book_id"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isOwnerBook($book_id, $uid)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            //$book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));
            //$uid = $_SESSION['uid'];

            $sql = "SELECT book_id 
                    FROM  book
                    WHERE book_id = '" . $book_id . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            $sql2 = "SELECT user_book_id, created_at
                    FROM  user_book
                    WHERE book_id = '" . $book_id . "' AND uid = '" .$uid . "' ;";

            $result_is_user_book_exist = $this->db_connection->query($sql2);


            if ($result_is_book_exist->num_rows == 1 AND $result_is_user_book_exist->num_rows == 1) {  

                return true;

            } else if ($result_is_book_exist->num_rows == 0) { 
                return false;

            } else if ($result_is_user_book_exist->num_rows == 0) {
                return false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


}

?>