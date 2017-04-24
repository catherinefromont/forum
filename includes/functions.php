<?php

function dd($data)
{
  die(var_dump($data));
}


function loggedIn() {
  return !empty($_SESSION['username']);
}

// -----------------------------------------------------------------------------
// user specific function for editing and deleting.
// -----------------------------------------------------------------------------

function userOwns($id) {
  if (loggedIn() && $_SESSION['id'] === $id){
   return true;
 }
 return false;
}



function redirect($url)
{
  header ('Location: ' . $url);
  die();
}

// -----------------------------------------------------------------------------
// htmlspecialchars function.
// -----------------------------------------------------------------------------

function e($value)
{
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// -----------------------------------------------------------------------------
// show the time function.
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

  // Figure out difference by looping while less than array length
  // and difference is larger than lengths.
  $arr_len = count($lengths);
  for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)
  {
    $difference /= $lengths[$j];
  }

  // Round up
  $difference = round($difference);

  // Make plural if needed
  if($difference != 1)
  {
    $periods[$j].= "s";
  }

  // Default format
  $text = "$difference $periods[$j] $ending";

  // over 24 hours
  if($j > 2)
  {
    // future date over a day formate with year
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

    if($j == 3 && $difference == 1) // Yesterday
    {
      $text = "Yesterday at ". date("g:i a", $timestamp);
    }
    else if($j == 3) // Less than a week display -- Monday at 5:28pm
    {
      $text = date("l \a\\t g:i a", $timestamp);
    }
    else if($j < 6 && !($j == 5 && $difference == 12)) // Less than a year display -- June 25 at 5:23am
    {
      $text = date("F j \a\\t g:i a", $timestamp);
    }
    else // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
    {
      $text = date("F j, Y \a\\t g:i a", $timestamp);
    }
  }

  return $text;
}

// -----------------------------------------------------------------------------
//Connect to the database function.
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

//Prepare the statement that will be executed
	$sth = $dbh->prepare("INSERT INTO users VALUES (NULL, :username, :email, :password)");



//Bind the "$searchQuery" the SQL statement
	$sth->bindValue(':username', $username, PDO::PARAM_STR);
	$sth->bindValue(':email', $email , PDO::PARAM_STR);
	$sth->bindValue(':password', $password , PDO::PARAM_STR);
	

//Execute the statement
	$success = $sth->execute();    
	return true;
}



// -----------------------------------------------------------------------------
//Show the success or error message
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
// Insert into "projects" table
// -----------------------------------------------------------------------------


function addTopic($dbh, $title, $content, $userid) {

//Prepare the statement that will be executed
	$sth = $dbh->prepare("INSERT INTO topics VALUES (NULL, :title, :content, :user_id, NOW(), NOW())");



//Bind the "$searchQuery" the SQL statement
	$sth->bindValue(':title', $title, PDO::PARAM_STR);
	$sth->bindValue(':content', $content , PDO::PARAM_STR);
	$sth->bindValue(':user_id', $userid , PDO::PARAM_INT);

//Execute the statement
	$success = $sth->execute();    
	return $success;
}





function getUser($dbh, $username) {
  $sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username OR email = :email');

  $sth->bindValue(':username', $username, PDO::PARAM_STR);
  $sth->bindValue(':email', $username, PDO::PARAM_STR);

    // Execute the statement.
  $sth->execute();

  $row = $sth->fetch();

  if (!empty($row)) {
    return $row;
  }
  return false;
}

function getTopics($dbh) {
  $sth = $dbh->prepare('SELECT * FROM `topics` ');

    // Execute the statement.
  $sth->execute();

  $row = $sth->fetchAll();

  if (!empty($row)) {
    return $row;
  }
  return false;
}

// -----------------------------------------------------------------------------
// Edit and delelte projects functions
// -----------------------------------------------------------------------------


function editTopic($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM topics WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}

function updateTopic($id, $dbh, $title, $content) {
	$sth = $dbh->prepare("UPDATE topics SET title = :title, content = :content WHERE id = :id LIMIT 1");
	// bind the $id to the SQL statement
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	// bind the $name to the SQL statement
	$sth->bindParam(':title', $title, PDO::PARAM_STR);
	// bind the $email to the SQL statement

	// bind the $feedback to the SQL statement
	$sth->bindParam(':content', $content, PDO::PARAM_STR);
		// bind the $feedback to the SQL statement
	
	// execute the statement 
	$result = $sth->execute();
	return $result;
}

function deleteTopic($id, $dbh) {
	// prepare statement that will be executed
	$result = $dbh->prepare("DELETE FROM topics WHERE id= :id LIMIT 1");
	$result->bindParam(':id', $id);
	$result->execute();
}

// -----------------------------------------------------------------------------
// View projects functions
// -----------------------------------------------------------------------------

function viewTopic($id, $dbh) {
	// prepare statement that will be executed
	$sth = $dbh->prepare("SELECT * FROM topics WHERE id = :id LIMIT 1");
	$sth->bindParam(':id', $id, PDO::PARAM_STR);
	$sth->execute();

	$result = $sth->fetch();
	return $result;
}


// -----------------------------------------------------------------------------
// Get Gravatar Imange Profile function
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
// Get Comments functions
// -----------------------------------------------------------------------------
function getComments($id, $dbh) {
  $sth = $dbh->prepare("SELECT comments.id, comments.content, comments.topic_id, comments.user_id, comments.updated_at, comments.created_at, users.username, users.email  FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.topic_id = :id ORDER BY comments.created_at DESC");

    // Execute the statement.
  $sth->bindParam(':id', $id, PDO::PARAM_STR);
  $sth->execute();
  $row = $sth->fetchAll();

  if (!empty($row)) {
    return $row;
  }
  return false;
}

// -----------------------------------------------------------------------------
// Add Comments function
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
// Delete Comments function
// -----------------------------------------------------------------------------


// function deleteComment($dbh, $project_id, $content) {
//   // prepare statement that will be executed
//   $result = $dbh->prepare("DELETE FROM comments (content, user_id, project_id, created_at, updated_at) WHERE (:content, :user_id, :project_id, NOW(), NOW())");
//   $sth->bindParam(':content', $content, PDO::PARAM_STR);
//   $sth->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
//   $sth->bindParam(':project_id', $project_id, PDO::PARAM_INT);
//   $result->execute();
// }

function deleteComment($dbh, $id) {
  // prepare statement that will be executed
  $result = $dbh->prepare("DELETE FROM comments WHERE id= :id LIMIT 1");
  $result->bindParam(':id', $id);
  $result->execute();
}
