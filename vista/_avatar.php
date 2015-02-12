<div class="row-fluid">
    <div class="span12">
        <div class="span10 offset1">
            <div class="row-fluid">
                <h3 class="pull-left">Select your Avatar</h3> <span class='pull-right'><a href='curso.php'><i class='icon icon-share-alt'> Back</i></a></span>
            </div>            
            <div class="row-fluid">
                <form method="post" action="avatar.php?option=actualizar">
                    <div class="span12">



                        <?php
                        for ($i = 1; $i <= 28; $i++) {
                            ?>
                            <span style='margin: 10px;'>
                                <img src='./public/img/avatars/<?php echo $i ?>.png'>
                                <input  type="radio" name="avatar" value="<?php echo $i ?>"></span>

                        <?php }
                        ?>

                        <br>
                    </div>


                    <center ><button class='btn btn-success' style="margin-top: 20px;"><i class='icon icon-save'></i> Save</button></center>

                </form>   
            </div> <br>
            <br>

        </div>
    </div>s