<?php require_once("init.php");?>

<?php
if(strpos(User::check_user_role(),'admin'))
{
    $photos = Photo::find_all();
}
else
{
    $photos = Photo::find_by_query("SELECT * FROM photos WHERE user_id = {$_SESSION['user_id']}");
}
?>

<div class="modal fade" id="photo-library">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Фото Галерија</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-9">
                    <div class="thumbnails row">

                        <!-- PHP LOOP HERE CODE HERE-->
                        <?php
                        if(count($photos) > 0)
                        {
                            foreach($photos as $photo) : ?>
                                <div class="col-xs-2">
                                    <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#"
                                       class="thumbnail">
                                        <img class="modal_thumbnails img-responsive"
                                             src="<?php echo $photo->picture_path(); ?>"
                                             data="<?php echo $photo->id; ?>">
                                    </a>
                                    <div class="photo-id hidden"></div>
                                </div>
                                <?php
                            endforeach;
                        }
                        else
                        {
                            echo "<h1>Немате прикачено слики!</h1>";
                        }
                        ?>
                        <!-- PHP LOOP HERE CODE HERE-->

                    </div>
                </div><!--col-md-9 -->

                <div class="col-md-3">
                    <div id="modal_sidebar"></div>
                </div>

            </div><!--Modal Body-->
            <div class="modal-footer">
                <div class="row">
                    <!--Closes Modal-->
                    <button id="set_user_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Ажурирај</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->