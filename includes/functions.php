<?php

function dd($data)
{
  die(var_dump($data));
}


function loggedIn() {
  return !empty($_SESSION['username']);
}

// -----------------------------------------------------------------------------
// user specific function for editing and deleting
// -----------------------------------------------------------------------------

function userOwns($id) {
  if (loggedIn() && $_SESSION['id'] === $id){
   return true;
 }
 return false;
}

function isAdmin() {
  if (loggedIn() && $_SESSION['admin'] == 1){
    return true;
  }
}



function redirect($url)
{
  header ('Location: ' . $url);
  die();
}

// -----------------------------------------------------------------------------
// showing htmlspecialchars function
// -----------------------------------------------------------------------------

function e($value)
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function validateTitle($title) {

  if (empty($title)) {
    return "Title is required";
  }
  
  else if(strlen ($title) >= 40){
    return "Title cannot be longer than 40 characters";
  }
  
  return false;
}

function validateContent($content) {

  if (empty($content)) {
    return "Content is required";
  }
  
  else if(strlen ($content) >= 200){
    return "Content cannot be longer than 200 characters";
  }
  
  return false;
}





function validateName($username) {

  if (empty($username)) {
    return "Username is required";
  }
  
  else if(strlen ($username) >= 40){
    return "Username cannot be longer than 40 characters";
  }
  
  return false;
}



function ValidateEmail($email) {
  if (empty($email)) {
  return "Email is required";
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "Please enter a correct Email Address";
  }
  else if($email > 100){
  return "Email cannot be longer than 100 characters";
  }
  return false;
}


function ValidatePassword($password) {
  if (empty($password)) {
  return "Password is required";
  }
}


// function ValidateAddress($address) {
//   if (empty($address)) {
//   return "Address is required";
//   }
//   else if (!preg_match("/^[0-9]+\ +[a-zA-Z]/", $address)) {
//      return "Please enter a correct address";
//   }
//   else if(strlen($address) > 200){
//   return "Address cannot be longer than 200 characters";
//   }
//   return false;
// }

// -----------------------------------------------------------------------------
// showing timestamp function
// -----------------------------------------------------------------------------
/**
 * Returns a human-readable time from a timestamp
 * @param timestamp $timestamp
 * @return string
 */
function formatTime($timestamp)
{
  // Get time difference and setup arrays
  $difference = time() - $timestamp;
  $periods = array("second", "minute", "hour", "day", "week", "month", "years");
  $lengths = array("60","60","24","7","4.35","12");

  // Past or present
  if ($difference === 0) {
    return 'Just now';
  }
  if ($difference >= 0)
  {
    $ending = "ago";
  }
  else
  {
    $difference = -$difference;
    $ending = "to go";
  }

  
  $arr_len = count($lengths);
  for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)
  {
    $difference /= $lengths[$j];
  }

  
  $difference = round($difference);

  if($difference != 1)
  {
    $periods[$j].= "s";
  }

  $text = "$difference $periods[$j] $ending";

  
  if($j > 2)
  {
  
    if($ending == "to go")
    {
      if($j == 3 && $difference == 1)
      {
        $text = "Tomorrow at ". date("g:i a", $timestamp);
      }
      else
      {
        $text = date("F j, Y \a\\t g:i a", $timestamp);
      }
      return $text;
    }

    if($j == 3 && $difference == 1) 
    {
      $text = "Yesterday at ". date("g:i a", $timestamp);
    }
    else if($j == 3) 
    {
      $text = date("l \a\\t g:i a", $timestamp);
    }
    else if($j < 6 && !($j == 5 && $difference == 12)) 
    {
      $text = date("F j \a\\t g:i a", $timestamp);
    }
    else 
    {
      $text = date("F j, Y \a\\t g:i a", $timestamp);
    }
  }

  return $text;
}

// -----------------------------------------------------------------------------
// connect to database function
// -----------------------------------------------------------------------------


function connectDatabase($host,$database,$user,$pass){
	try{
		$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		return  $dbh;

	} catch (PDOException $e){
		print('Error! ' . $e->getMessage() . '<br>');
		die();
	}
}



/**
 * Insert into "users" table
 * @param type $dbh 
 * @param type $username 
 * @param type $email 
 * @param type $password 
 * @return type
 */
function addUser($dbh, $username, $email, $password) {


	$sth = $dbh->prepare("INSERT INTO users VALUES (NULL, :username, :email, :password, 0)");




	$sth->bindValue(':username', $username, PDO::PARAM_STR);
	$sth->bindValue(':email', $email , PDO::PARAM_STR);
	$sth->bindValue(':password', $password , PDO::PARAM_STR);
	


	$success = $sth->execute();    
	return true;
}



// -----------------------------------------------------------------------------
// show success or error messages
// -----------------------------------------------------------------------------

function showMessages($type = null)
{
  $messages = '';
  if(!empty($_SESSION['flash'])) {
    foreach ($_SESSION['flash'] as $key => $message) {
      if(($type && $type === $key) || !$type) {
        foreach ($message as $k => $value) {
          unset($_SESSION['flash'][$key][$k]);
          $key = ($key == 'error') ? 'danger': $key;
          $messages .= '<div class="alert alert-' . $key . '">' . $value . '</div>' . "\n";
        }
      }
    }
  }
  return $messages;
}


/**
 * Add a message to the session
 * @param string $type
 * @param string $message
 * @return void
 */
function addMessage($type, $message) {
  $_SESSION['flash'][$type][] = $message;
}


// -----------------------------------------------------------------------------
// insert into "topics" table
// -----------------------------------------------------------------------------


function addTopic($dbh, $title, $content, $userid) {


	$sth = $dbh->prepare("INSERT INTO topics VALUES (NULL, :title, :content, :user_id, NOW(), NOW())");



	$sth->bindValue(':title', $title, PDO::PARAM_STR);
	$sth->bindValue(':content', $content , PDO::PARAM_STR);
	$sth->bindValue(':user_id', $userid , PDO::PARAM_INT);


	$success = $sth->execute();    
	return $success;
}





function getUser($dbh, $username) {
  $sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username OR email = :email');

  $sth->bindValue(':username', $username, PDO::PARAM_STR);
  $sth->bindValue(':email', $username, PDO::PARAM_STR);


  $sth->execute();

  $row = $sth->fetch();

  if (!empty($row)) {
    return $row;
  }
  return false;
}

function getTopics($dbh) {
   
  $sth = $dbh->prepare('SELECT topics.id, topics.title, topics.content, topics.user_id, topics.updated_at, topics.created_at, users.username FROM topics INNER JOIN users ON topics.user_id = users.id ORDER BY topics.created_at DESC');

    
    $sth->execute();

    $row = $sth->fetchAll();

    if (!empty($row)) {
      return $row;
    }
    return false;
}

// -----------------------------------------------------------------------------
// edit and delete topics function
// -----------------------------------------------------------------------------


function editTopic($id, $dbh) {
	
	$sth = $dbh->prepare("SELECT * FROM topics WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

function updateTopic($id, $dbh, $title, $content) {
	$sth = $dbh->prepare("UPDATE topics SET title = :title, content = :content WHERE id = :id LIMIT 1");
	
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	
	$sth->bindParam(':title', $title, PDO::PARAM_STR);
	

	
	$sth->bindParam(':content', $content, PDO::PARAM_STR);
	
	 
	$result = $sth->execute();
	return $result;
}

function deleteTopic($id, $dbh) {
	
	$result = $dbh->prepare("DELETE FROM topics WHERE id= :id LIMIT 1");
	$result->bindParam(':id', $id);
	$result->execute();
}

// -----------------------------------------------------------------------------
// view topics functions
// -----------------------------------------------------------------------------

function viewTopic($id, $dbh) {
	
	$sth = $dbh->prepare("SELECT * FROM topics WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}


// -----------------------------------------------------------------------------
// Gravatar Image Profile function
// -----------------------------------------------------------------------------

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
  $url = 'https://www.gravatar.com/avatar/';
  $url .= md5( strtolower( trim( $email ) ) );
  $url .= "?s=$s&d=$d&r=$r";
  if ( $img ) {
    $url = '<img src="' . $url . '"';
    foreach ( $atts as $key => $val )
      $url .= ' ' . $key . '="' . $val . '"';
    $url .= ' />';
  }
  return $url;
}

// -----------------------------------------------------------------------------
// get Comments functions
// -----------------------------------------------------------------------------
function getComments($id, $dbh) {
  $sth = $dbh->prepare("SELECT comments.id, comments.content, comments.topic_id, comments.user_id, comments.updated_at, comments.created_at, users.username, users.email  FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.topic_id = :id ORDER BY comments.created_at DESC");

    
  $sth->bindParam(':id', $id, PDO::PARAM_STR);
  $sth->execute();
  $row = $sth->fetchAll();

  if (!empty($row)) {
    return $row;
  }
  return false;
}

// -----------------------------------------------------------------------------
// add Comments function
// -----------------------------------------------------------------------------



function addComment($dbh, $topic_id, $content) {
 $sth = $dbh->prepare("INSERT INTO comments (content, user_id, topic_id, created_at, updated_at) VALUES (:content, :user_id, :topic_id, NOW(), NOW())");
 $sth->bindParam(':content', $content, PDO::PARAM_STR);
 $sth->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
 $sth->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
 $success = $sth->execute();
 return $success;
}

// -----------------------------------------------------------------------------
// delete Comments function
// -----------------------------------------------------------------------------



function deleteComment($dbh, $id) {
  // prepare statement that will be executed
  $result = $dbh->prepare("DELETE FROM comments WHERE id= :id LIMIT 1");
  $result->bindParam(':id', $id);
  $result->execute();
}
