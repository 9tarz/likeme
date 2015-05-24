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

        } else if (isset($_GET["addBook"]) AND isset($_GET["book_id"]) AND empty($_POST["addBook"]) ) {

            $this->showBook();

        } else if (isset($_GET["addBook"]) AND isset($_GET["book_id"]) AND isset($_POST["addBook"])) {

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


            $sql = "SELECT tag.name as tag_name , book_tag.count as count
                    FROM book_tag, tag
                    WHERE tag.tag_id = book_tag.tag_id AND book_tag.book_id = '" . $book_id . "';";

            $get_count_book = $this->db_connection->query($sql);

            $this->data["book_tag_status"] = array();

            if ($result_book->num_rows == 1) { 

                if ($get_count_book) { 
                    $i = 0;
                    while ($result_row = $get_count_book->fetch_array(MYSQLI_ASSOC)) {

                        $this->data["book_tag_status"][$i] = $result_row;
                        $i++;
                    }

                } else {

                    //$this->data["book_tag_status"] = "";
                }

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

    public function getBookTagCount($book_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $arr_book_count = array(); 

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT tag.tag_id as tag_id, tag.name as tag_name , book_tag.count as count
                    FROM book_tag, tag
                    WHERE tag.tag_id = book_tag.tag_id AND book_tag.book_id = '" . $book_id . "';";

            $get_count_book = $this->db_connection->query($sql);

            //$this->data["book_tag_status"] = array();
            if ($get_count_book) { 
                $i = 0;
                while ($result_row = $get_count_book->fetch_array(MYSQLI_ASSOC)) {

                    //$this->data["book_tag_status"][$i] = $result_row;
                    $arr_book_count[$i] = $result_row;
                    $i++;
                }

                return $arr_book_count;

            } else {

                return $arr_book_count;
            }
        } else {
            return $arr_book_count;
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

    public function getUserBook($uid)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $arr_user_book = array(); 

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT book.book_id as book_id, book.name as book_name ,book.description as book_description 
                    FROM book,user_book 
                    WHERE book.book_id = user_book.book_id AND user_book.uid = '" . $uid . "';";

            $result_user_book = $this->db_connection->query($sql);

            if ($result_user_book) { 

                $i=0;

                while ($result_row = $result_user_book->fetch_array(MYSQLI_ASSOC)) {

                    $arr_user_book[$i] = $result_row;
                    $i++;

                }

                return $arr_user_book;

            } else {
                return $arr_user_book;
            }
        } else {
            return $arr_user_book;
        }
    }

    public function getUserStatus($uid, $cmd)
    {
        $user_books = array();
        $user_books = $this->getUserBook($uid);
        $user_tag_count_each_book = array();
        $arr_tag = array();
        $arr_tag_id = array();
        $arr_tag_count = array();

        $arr_combine = array();

        $count_sum = 0;

        if ($user_books) {
            for ($i = 0; $i < count($user_books) ; $i++) {
                if ($this->getBookTagCount($user_books[$i]["book_id"])) {
                    $user_tag_count_each_book[$i] = $this->getBookTagCount($user_books[$i]["book_id"]);
                } else { 
                    continue;
                }
            }

            for ($j = 0; $j < count($user_tag_count_each_book) ; $j++) {
                for ($k = 0; $k < count($user_tag_count_each_book[$j]) ; $k++) {
                    if(!in_array($user_tag_count_each_book[$j][$k]["tag_name"] , $arr_tag) ) {
                        $arr_tag_count[] = $user_tag_count_each_book[$j][$k]["count"];
                        $arr_tag[] = $user_tag_count_each_book[$j][$k]["tag_name"];
                        $arr_tag_id[] = $user_tag_count_each_book[$j][$k]["tag_id"];
                        
                    } else {
                        $arr_tag_count[array_search($user_tag_count_each_book[$j][$k]["tag_name"], $arr_tag)] += $user_tag_count_each_book[$j][$k]["count"];
                    }
                }
            }
            for ($i = 0; $i < count($arr_tag) ; $i++) {
                $count_sum += $arr_tag_count[$i];
            }

            for ($i = 0; $i < count($arr_tag) ; $i++) {
                $arr_combine[$i]["tag_name"] = $arr_tag[$i];
                $arr_combine[$i]["count"] = $arr_tag_count[$i];
                $arr_combine[$i]["tag_id"] = $arr_tag_id[$i];
                $arr_combine[$i]["freq"] = ($arr_tag_count[$i]/ $count_sum)*100  ;
            }

            if ($cmd == 0) {
                return $arr_combine;
            } else if ($cmd == 1) {
                return $arr_tag_id;
            } else if ($cmd == 2) {
                return $arr_tag_count;
            } else if ($cmd == 3) {
                return $arr_tag;
            }
        } else {
            return $arr_combine;
        }
    }

    public function getUsersID()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $arr_users_id = array(); 

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT uid 
                    FROM user ;";

            $result_get_users_id = $this->db_connection->query($sql);

            if ($result_get_users_id) { 

                $i=0;

                while ($result_row = $result_get_users_id->fetch_array(MYSQLI_ASSOC)) {

                    $arr_users_id[$i] = $result_row;
                    $i++;

                }

                return $arr_users_id;

            } else {
                return $arr_users_id;
            }
        } else {
            return $arr_users_id;
        }
    }

    public function updatedUserTag($uid)
    {
        $arr_tag_id = $this->getUserStatus($uid, 1);

        $arr_tag_count = $this->getUserStatus($uid, 2);

        for ($i = 0 ; $i < count($arr_tag_id) ; $i++) {

            $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }


            $tag_id = $arr_tag_id[$i];
            $count = $arr_tag_count[$i];

            if (!$this->db_connection->connect_errno) {
            
                $sql = "SELECT user_tag_id 
                        FROM user_tag 
                        WHERE uid = '" . $uid . "' AND tag_id = '" . $tag_id. "' ;";

                $query_user_tag_exist = $this->db_connection->query($sql);

                if ($query_user_tag_exist->num_rows == 1) { //update Profile

                    $sql = "UPDATE user_tag_id 
                            SET count = '" . $count . "'
                            WHERE uid = '" . $uid . "' AND tag_id = '" . $tag_id. "' ;";

                    $query_update_user_tag = $this->db_connection->query($sql);

                    if ($query_update_user_tag) {
                        
                        $this->messages[] = "User tag has been updated successfully.";
                        //$this->showProfile();
                    } else {
                        
                        $this->errors[] = "Sorry, your profile can not updated. Please go back and try again.";
                    }


                } elseif ($query_user_tag_exist->num_rows == 0) { //create new User tag(INSERT)

                    $sql = "INSERT INTO user_tag
                            (uid, tag_id, count ) 
                            VALUES('" . $uid . "', '" . $tag_id . "', '" . $count . "');";
                            
                    $query_insert_new_user_tag = $this->db_connection->query($sql);

                    if ($query_insert_new_user_tag) {

                        $this->messages[] = "User tag has been created successfully.";
                        //header("Location: profile.php?uid=" . $uid."");
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

    public function searchByTag($tag_id, $uid)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {

            $this->errors[] = $this->db_connection->error;
        }

        $arr_users = array(); 

        if (!$this->db_connection->connect_errno) {

            $sql = "SELECT user.username as username, user_tag.count as tag_count
                    FROM user_tag, user
                    WHERE user_tag.uid = user.uid AND user_tag.uid != '" . $uid.  "' AND user_tag.tag_id = '" . $tag_id . "'
                    GROUP BY username;";

            $result_users = $this->db_connection->query($sql);

            $sql2 = $sql = "SELECT user.username as username, user_tag.count as tag_count, SUM(user_tag.count) As sum_tag
                    FROM user_tag, user
                    WHERE user_tag.uid = user.uid AND user_tag.uid != '" . $uid.  "' AND user_tag.tag_id = '" . $tag_id . "';";

            $result_users_sum = $this->db_connection->query($sql2);

            $row_users_sum  = $result_users_sum->fetch_array(MYSQLI_ASSOC);
            $count_sum = $row_users_sum["sum_tag"];

            if ($result_users) { 

                $i = 0;

                while ($result_row = $result_users->fetch_array(MYSQLI_ASSOC)) {

                    $arr_users[$i] = $result_row;
                    $i++;

                }

                $arr_users["count_sum"] = $count_sum;

                return $arr_users;

            } else {
                return $arr_users;
            }
        } else {
            return $arr_users;
        }
    }

}

?>