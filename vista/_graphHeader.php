<div class="navbar" id="navbar1">
    <div class="navbar-inner">
        <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="#"><i class='icon icon-bookmark'></i> <?php echo strtoupper($COURSE_NAME) ?></a>

            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <ul class="nav">
                    <li >
                        <a href="#" id="save" onClick="save(1);"><i class="icon icon-hdd"></i> Guardar</a>
                    </li>
                    <!--                    <li >
                                            <a href="#">Link2</a>
                                        </li>-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Información
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a href="#">Mis Estadisticas</a><li>
                            <li> <a href="#">Ranking del curso</a><li>



                        </ul>    
                    </li>    
                </ul>  
                <ul class="nav pull-right">
                    <li> <a href="curso.php"><i class="icon icon-share-alt"></i> Regresar</a><li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><?php echo ' ' . $_SESSION['user']['name'] ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a href="#"><i class="icon icon-edit"></i> Editar Información</a><li>
                            <li class="divider"></li>   
                            <li> <a href="curso.php?option=logout"><i class="icon icon-off"></i> Salir</a><li>

                        </ul>    
                    </li>   


                    <ul>   
                        </div>

                        </div>
                        </div>
                        </div>
                        <br/>

                        <script>
                            $(document).ready(function(){
                                $(".dropdown-toggle").dropdown();
      
                            });
    
    
                        </script>    