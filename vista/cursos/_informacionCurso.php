<div class="row-fluid">
    <div class="span12">
        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Name:</span><span class=''> <?php echo "{$_data['curso']['nombre']}" ?></span></p>
        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Registration code:</span><span class=''> <?php echo "{$_data['curso']['codigo']}" ?></span></p>
        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Creation date:</span><span class=''> <?php echo "{$_data['curso']['fecha_creacion']}" ?></span></p>
        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Number of students:</span><span class=''> <?php echo "{$_data['curso']['numero_estudiantes']}" ?></span></p>
        <p><i class='icon icon-ok-circle'></i> <span class='text-big'>Number of topics:</span><span class=''> <?php echo "{$_data['curso']['numero_temas']}" ?></span></p>
        <!--<p><i class='icon icon-ok-circle'></i> <span class='text-big'>Número de Ejercicios:</span><span class=''> <?php echo "{$_data['curso']['numero_ejercicios']}" ?></span></p>-->

    </div>
</div>

<style>

    .text-big{
        font-size: 20px;
    }
</style>