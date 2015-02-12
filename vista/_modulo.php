<div class="navbar" >
    <div class="navbar-inner">
        <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="modulo.php"><i class='icon icon-star'></i> <?php echo strtoupper($COURSE_NAME) ?></a>

            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <ul class="nav">
                    <li >
                        <a href="modulo.php?option=verRecursos"><i class='icon-folder-open icon'></i> Resources</a>
                    </li>
                    <li> <a href="http://uhunt.felix-halim.net/id/<?php echo $info['uva_id']; ?>" target="_blank"> My UVA</a><li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon icon-th'></i> Information
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <!--    <li> <a href="#">Mis Estadisticas</a><li> -->
                            <li> <a href="modulo.php?option=verRanking"><i class='icon icon-list-ol'></i> Ranking</a><li>
                            <li> <a href="modulo.php?option=estadisticas"><i class='icon icon-signal'></i> Statistics</a><li>



                        </ul>    
                    </li>    
                </ul>  
                <ul class="nav pull-right">
                    <li> <a href="curso.php"><i class='icon icon-share-alt'></i> Back </a><li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><?php echo ' ' . $_SESSION['user']['name'] ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a href="curso.php?option=editarInformacion"><i class='icon icon-edit'></i> Edit information</a><li>
                            <li class="divider"></li>   
                            <li> <a href="curso.php?option=logout"><i class='icon icon-off'></i> Log out</a><li>

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