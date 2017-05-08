<?php
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $title = $content = '';
    
    $title = e($_POST['title']);
    $content = e($_POST['content']);
    $errors['title'] = validateTitle($title);
    $errors['content'] = validateContent($content);
    

    if (!$errors['title'] && !$errors['content']) {
    $didInsertWork = addTopic($dbh, $title, $content, $_SESSION['id']);
          
    addMessage('success', "You have successfully added a topic");
    redirect("index.php");

}

    





}

require 'partials/header.php';
require 'partials/navigation.php';



?>
<div id="app">



    <!-- Start of Dashboard form -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Dashboard
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="dashboard.php">
                            
                            <div class="form-group">
                                <label class="col-md-4">
                                    Add new Topic
                                </label>
                            </div>

                            
                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="" autofocus="">
                                </div>
                                <span class="text-danger"><?= !empty($errors['title']) ? $errors['title'] : ''  ?></span>
                            </div>

                            
                            <div class="form-group">
                                <label for="content" class="col-md-4 control-label">Content</label>

                                <div class="col-md-6">
                                    <textarea id="content" type="text" class="form-control" name="content" value="" autofocus="" ></textarea>
                                </div>
                                <span class="text-danger"><?= !empty($errors['content']) ? $errors['content'] : ''  ?></span>
                            </div>

                          
                            
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-info">
                                        Add
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
    <!-- End of Content -->
</div>

<?php
require 'partials/footer.php';
?>

