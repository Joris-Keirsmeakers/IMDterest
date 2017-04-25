<?php

spl_autoload_register(function($class){
    include_once("classes/" . $class . ".php");
});
//stuur de gebruiker weg als ze niet zijn ingelogd
if( isset( $_SESSION['user'] ) ){
}
else {
    header('Location: signin.php');
}

include_once('emptyStates.php');
?>

<div id="results"></div>

<?php if(isset($_SESSION['posts']) && $_SESSION['posts'] == true){ ob_start(); ?>

    <div class="loadMore">
        <button class="loadMoreBtn btn btn-primary">Load 20 more</button>
    </div>
<?php echo ob_get_clean(); }
else{
    shuffle($emptyStates);
    echo '<h1 class="emptyState">' . $emptyStates[0] . '</h1>'."\n".'<h1 class="emptyStateTxt">Oops, no posts found!</h1>';
}?>

        <div class="add">
            <button type="button" class="btn btn-success addBtn" id="addBtn">+</button>

            <button type="button" class="btn btn-success addBtn" id="imageBtn" data-toggle="modal"
                    data-target="#newImage"><img src="images/icons/image.svg" alt="image"></button>

            <button type="button" class="btn btn-success addBtn" id="linkBtn" data-toggle="modal"
                    data-target="#newLink"><img src="images/icons/link.svg" alt="image"></button>
        </div>

        <div class="modal fade" id="newImage" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create new post</h4>
                    </div>
                    <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data">

                            <input type="file" name="img" />

                            <hr>

                            <input type="text" id="title" name="title" placeholder=" Title" />

                            <textarea rows="3" name="imgDescription" id="imgDescription" placeholder=" Add a description..."></textarea>

                            <label for="imgTopic">Topic</label>
                            <select name="imgTopic" id="imgTopic">
                                <option value="none">Choose a topic</option>
                                <?php foreach ($_SESSION['topics'] as $t):?>
                                    <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="modal-footer">
                                <input type="submit" name="imgSubmit" class="btn btn-default submitBtn" value="Save" />
                            </div>


                        </form>

                    </div>

                </div>

            </div>
        </div>

        <div class="modal fade" id="newLink" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create new post</h4>
                    </div>
                    <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data">

                            <input type="url" name="link" placeholder="http://"/>

                            <hr>

                            <input type="text" name="title" id="title" placeholder=" Title">

                            <textarea rows="3" name="linkDescription" placeholder=" Add a description"></textarea>

                            <label for="linkTopic">Topic</label>
                            <select name="linkTopic" id="linkTopic">
                                <option value="none">Choose a topic</option>
                                <?php foreach ($_SESSION['topics'] as $t):?>
                                    <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="modal-footer">
                                <input type="submit" name="linkSubmit" class="btn btn-default submitBtn" value="Save" />
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>
