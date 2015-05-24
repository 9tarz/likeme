<?php
/**
 * Class Tag
 */

class Tag
{   
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public $data = array();

	public function __construct()
    {
    	if (isset($_POST["createTag"])) {

            $this->createTag();

        } else if (isset($_GET["searchKeyword"]) AND isset($_GET["book_id"])) {
            $this->searchTag();
        } else if (isset($_GET["addTag"]) AND isset($_GET["book_id"]) AND isset($_GET["tag_id"]) ) {
            $this->addTag();
        } else if (isset($_GET["showBook"]) AND isset($_GET["book_id"])) {
            $this->showBookTag();
        } else if (isset($_GET["updateBook"]) AND isset($_GET["book_id"])) {
            $this->showBookTag();
        } else {
         	$this->errors[] = "Error!";
         }
    }

    private function createTag()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $tag_name = $this->db_connection->real_escape_string(strip_tags($_POST['tag_name'], ENT_QUOTES));
            $tag_description = $this->db_connection->real_escape_string(strip_tags($_POST['tag_description'], ENT_QUOTES));
            $book_id = $this->db_connection->real_escape_string(strip_tags($_POST['book_id'], ENT_QUOTES));
            $uid = $_SESSION['uid'];

            if ($this->isTagExist($tag_name)) { // this book is exist

                    $this->errors[] = "Sorry, This tag is exist.";

            } elseif ($result_is_book_exist->num_rows == 0) { //create new Book (INSERT)

                $sql = "INSERT INTO tag (name, description, created_at, created_by) 
                        VALUES('" . $tag_name . "', '" . $tag_description . "', '" . time(). "', '" .$uid . "');";
                $query_insert_new_tag = $this->db_connection->query($sql);

                if ($query_insert_new_tag) {
                    $this->messages[] = "Tag has been created successfully.";
                    header("Location: book.php?updateBook&book_id=" . $book_id . "");
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
    
    private function addTag()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));
            $tag_id = $this->db_connection->real_escape_string(strip_tags($_GET['tag_id'], ENT_QUOTES));


            if ($this->isBookExist($book_id) AND $this->isTagExist($tag_id) AND !$this->isBookTagExist($tag_id,$book_id)) { 
                $sql = "INSERT INTO book_tag
                        (book_id, tag_id, created_at) 
                        VALUES('" . $book_id . "', '" . $tag_id . "', '" . time() . "');";

                $query_insert_book_tag = $this->db_connection->query($sql);
                $this->messages[] = "Add this tag has been added successfully.";
                header("Location: book.php?updateBook&book_id=" . $book_id. "");

            } else if (!$this->isBookExist($book_id) OR !$this->isTagExist($tag_id)) { 
                    $this->errors[] = "This book or This Tag isn't in database";

            } else if ($this->isBookTagExist($tag_id,$book_id)) {
                    $this->errors[] = "This book already have this Tag";

            } else {
                $this->errors[] = "Problem in BookTag Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

	private function searchTag()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $search_keyword = $this->db_connection->real_escape_string(strip_tags($_GET['searchKeyword'], ENT_QUOTES));

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT tag_id , name as tag_name , description as tag_description 
                    FROM tag
                    WHERE name like '%" . $search_keyword . "%';";

            $result_search_tag = $this->db_connection->query($sql);

            if ($result_search_tag) { 

                    while ($result_row = $result_search_tag->fetch_assoc()) {

                        $this->data[] = $result_row;
                    }

                    $result_search_tag->free();

            } else {

                $this->errors[] = "Problem in Tag Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function showBookTag()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $book_id = $this->db_connection->real_escape_string(strip_tags($_GET['book_id'], ENT_QUOTES));

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT tag.name as tag_name 
                    FROM book_tag, book, tag
                    WHERE book.book_id = book_tag.book_id AND tag.tag_id = book_tag.tag_id 
                    AND book_tag.book_id = '" . $book_id . "';";

            $result_show_book_tag = $this->db_connection->query($sql);

            if ($result_show_book_tag) { 

                    while ($result_row = $result_show_book_tag->fetch_assoc()) {

                        $this->data[] = $result_row;
                    }

                    $result_show_book_tag->free();

            } else {

                $this->errors[] = "Problem in  Table.";
            }
        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function isTagExist($tag)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT tag_id 
                    FROM  tag
                    WHERE name = '" . $tag. "' OR tag_id = '" .$tag . "' ;";

            $result_is_tag_exist = $this->db_connection->query($sql);

            if ($result_is_tag_exist->num_rows == 1) {  
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    private function isBookExist($book_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

           	$sql = "SELECT book_id 
                    FROM  book
                    WHERE book_id = '" . $book_id . "';";

            $result_is_book_exist = $this->db_connection->query($sql);

            if ($result_is_book_exist->num_rows == 1) {  
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    private function isBookTagExist($tag_id,$book_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT book_tag_id 
                    FROM  book_tag
                    WHERE tag_id = '" . $tag_id. "' AND book_id = '" .$book_id . "' ;";

            $result_is_book_tag_exist = $this->db_connection->query($sql);

            if ($result_is_book_tag_exist->num_rows == 1) {  
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    public function isSearchTag()
    {
        if (isset($_GET["searchKeyword"]) AND isset($_GET["book_id"])) {
            return true;
        } else {
            return false;
        }

    }

    public function isShowBookTag()
    {
    	if(isset($_GET["showBookTag"]) AND isset($_GET["book_id"])) {
    		return true;
    	} else {
    		return false;
    	}
    }

 }