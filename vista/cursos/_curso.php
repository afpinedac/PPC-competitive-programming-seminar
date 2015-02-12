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
            <a class="brand" href="curso.php"><i class='icon-star'></i> Programming Practice Center</a>

            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <ul class="nav">
                    <!--<li class=>
                        <a href="http://unalmed.3eeweb.com/uva/" target="_blank"><i class='icon-list-alt'></i> Ranking Unalmed</a>
                    </li>-->

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon-book'></i> Courses
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a href="curso.php"> My courses</a><li>
                            <li> <a href="curso.php?option=inscribir">Register new</a><li>
                                <?php if ($_SESSION['user']['rol'] == 1): ?>                                    
                                <li> <a href="curso.php?option=crearNuevo">Create new</a><li>
                                <?php endif; ?>

                        </ul>    
                    </li>    
                </ul>  
                <ul class="nav pull-right">
                    <li> <a href="http://uhunt.felix-halim.net/id/<?php echo $info['uva_id']; ?>" target="_blank"> My UVA</a><li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><?php echo ' ' . $_SESSION['user']['name'] ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a href="curso.php?option=editarInformacion"><i class='icon-edit'></i> Edit Information</a><li>
                            <li class="divider"></li>   
                            <li> <a href="curso.php?option=logout"><i class='icon-off'></i> Log out</a><li>

                        </ul>    
                    </li>   


                    <ul>   
                        </div>

                        </div>
                        </div>
                        </div>
                        <br/>

                        <script>
                            $(document).ready(function() {
                                $(".dropdown-toggle").dropdown();

                            });


                        </script>    