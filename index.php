<?php
require 'includes/config.php';

$topics = getTopics($dbh);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if ($_POST["_method"] == "delete") {
    $id=e($_POST['id']);
    deleteTopic($id, $dbh);
    redirect('index.php');
  }

  if ($_POST["_method"] == "edit") {
    $id=e($_POST['editid']);
            // editProject($id, $dbh);
    redirect('edit.php?id=' . $id);
  }

  if ($_POST["_method"] == "view") {
    $id=$_POST['viewid'];
            // editProject($id, $dbh);
    redirect('view.php?id=' . $id);
  }
}

require 'partials/header.php';
require 'partials/navigation.php';

?>


<!-- Start of Forum Posts -->
<div class="container">
<div class="background">
<div class="row">
<div class="col-md-12"><?= showMessages() ?>
</div>
</div>
<h3>Recent Posts:</h3>

  


    

  <div class="row">
  
 
    <?php foreach ($topics as $topic):?>

   
     <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading panel-header">
        
        </div>

        <div class="panel-body">


          <p class="lead"><?= substr ($topic['title'], 0, 20) ?></p><br>

          <p class="second"><?= substr ($topic['content'], 0, 500) ?></p>
          <br>
          <p class="third">Posted by <?= substr ($topic['username'], 0, 80) ?> - <?= formatTime(strtotime($topic['created_at'])) ?></p><br>
          
          <form method="POST" action="index.php" style="display: inline-block;">
            <input name="_method" type="hidden" value="view">
            <input name="viewid" type="hidden" value="<?= $topic['id'] ?>">
            <button type="submit" class="btn btn-primary btn-xs">
              <i class="icon ion-eye">
              </i> View
            </button>
          </form>


          <!-- edit button -->
          <div class="pull-right">
          
            <?php if(isAdmin() || userOwns($topic['user_id'])) : ?>
          
              <form method="POST" action="index.php" style="display: inline-block;">
                <input name="_method" type="hidden" value="edit">
                <input name="editid" type="hidden" value="<?= $topic['id'] ?>">
                <button type="submit" class="btn btn-warning btn-xs">
                 <i class="icon ion-edit">
                 </i> Edit
               </button>
             </form>
             <!-- delete button -->
             <form method="POST" action="index.php" style="display: inline-block;">
               <input name="_method" type="hidden" value="delete">
               <input name="id" type="hidden" value="<?= $topic['id'] ?>">
               <button onclick="return confirm('Are you sure you want to delete this item?');" type="submit" class="btn btn-danger btn-xs btn-danger">
                 <i class="icon ion-ios-close-outline">
                 </i> Delete
               </button>
             </form>
           <?php endif; ?>

         </div>
       </div>
     </div>
   </div>
 <?php endforeach; ?>
</div>
</div>
</div>



<?php
require 'partials/footer.php';
?>