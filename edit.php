<?php
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  updateTopic (e($_POST['id']), $dbh, e($_POST['title']), e($_POST['content']));
  redirect('index.php');

}

$editTopic = editTopic($_GET['id'], $dbh);

require 'partials/header.php';
require 'partials/navigation.php';
?>


<div class="container">

  <div class="row">
    <div class="col-md-12">
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="edit.php">
            <input id="id" type="hidden" name="id" value="<?= $editTopic['id'] ?>">



       
            <div class="form-group">
              <label class="col-md-4">
                Edit Topic
              </label>
            </div>

            <div class="form-group">
              <label for="projectName" class="col-md-4 control-label">Title</label>

              <div class="col-md-6">
                <input id="title" type="text" class="form-control" name="title" value="<?= $editTopic['title'] ?>" required="" autofocus="">
              </div>
            </div>

           
            <div class="form-group">
              <label for="content" class="col-md-4 control-label">Content</label>

              <div class="col-md-6">
                <input id="content" type="text" class="form-control" name="content" value="<?= $editTopic['content'] ?>" autofocus="">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Update
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
    
      <div class="form-group">
      </div>
    </div>
  </div>
</div>


<?php
require 'partials/footer.php';
?>