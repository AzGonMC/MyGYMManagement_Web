<?php

$routineObjectives = Routine_m::getRoutineObjectives();
$routineDifficulties = Routine_m::getRoutineDifficulties();

if(isset($_POST['objective'])) {
    if(isset($_POST['difficulty'])) {
        if($_POST['objective'] == "all" && $_POST['difficulty'] == "all") {
            $routines = Routine_m::getAdminRoutines();
        }
        else {
            if($_POST['objective'] == "all") {
                $routines = Routine_m::getAdminRoutinesByDifficulty($_POST['difficulty']);
            }
            else {
                if($_POST['difficulty'] == "all") {
                    $routines = Routine_m::getAdminRoutinesByObjective($_POST['objective']);
                }
                else {
                    $routines = Routine_m::getAdminRoutinesByObjectiveAndDifficulty($_POST['objective'], $_POST['difficulty']);
                }
            }
        }
    }
    else {
        if($_POST['objective'] == "all") {
            $routines = Routine_m::getAdminRoutines();
        }
        else {
            $routines = Routine_m::getAdminRoutinesByObjective($_POST['objective']);
        }
    }
}
else {
    if(isset($_POST['difficulty'])) {
        if($_POST['difficulty'] == "all") {
            $routines = Routine_m::getAdminRoutines();
        }
        else {
            $routines = Routine_m::getAdminRoutinesByDifficulty($_POST['difficulty']);
        }
    }
    else {
        $routines = Routine_m::getAdminRoutines();
    }
}
?>
<section>
    <div class="row my-3">
        <div class="col-12">
            <h3>Explorar rutinas</h3>
        </div>
        <div class="col-12">
            <div class="row">
                <aside class="col-3">
                    <div class="list-group">
                        <form action="explore" method="POST">
                            <?php
                                if(isset($_POST['difficulty'])) {
                                    ?>
                                    <input type="hidden" name="difficulty" value="<?= $_POST['difficulty'] ?>">
                                    <?php
                                }
                            ?>
                            <input type="hidden" name="objective" value="all">              
                            <input type="submit" class="list-group-item list-group-item-action 
                            <?php
                            if(!isset($_POST['objective']) || $_POST['objective']== "all") {
                                echo 'active';
                            }
                           ?> " value="Cualquier objetivo">
                        </form>
                    <?php
                    foreach ($routineObjectives as $routineObjective) { ?>
                        <form action="explore" method="POST">
                            <?php
                                if(isset($_POST['difficulty'])) {
                                    ?>
                                    <input type="hidden" name="difficulty" value="<?= $_POST['difficulty'] ?>">
                                    <?php
                                }
                            ?>
                            <input type="hidden" name="objective" value="<?= $routineObjective['cod_objective'] ?>">              
                            <input type="submit" class="list-group-item list-group-item-action <?= $routineObjective['cod_objective']==$_POST['objective'] ? 'active' : '' ?>" value="<?= $routineObjective['type'] ?>">
                        </form>
                    <?php
                    } 
                    ?>
                    </div>
                </aside>
                <aside class="col-9">
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="explore">
                                <?php
                                    if(isset($_POST['objective'])) {
                                        ?>
                                        <input type="hidden" name="objective" value="<?= $_POST['objective'] ?>">
                                        <?php
                                    }
                                ?>
                                <div class="col-10">
                                    <div class="form-group row">
                                        <label class="col-6" for="difficulty">Introduzca la dificultad de la rutina:</label>
                                        <div class="col-3">
                                            <select class="form-control form-control-sm" name="difficulty" id="difficulty">
                                                <option value="all">Todas</option>
                                                <?php
                                                foreach($routineDifficulties as $routineDifficulty) {
                                                    if($_POST['difficulty'] == $routineDifficulty['cod_difficulty']){
                                                        ?>
                                                        <option value="<?= $routineDifficulty['cod_difficulty'] ?>" selected="true"><?= $routineDifficulty['type'] ?></option>
                                                        <?php
                                                        }
                                                    else {
                                                        ?>
                                                        <option value="<?= $routineDifficulty['cod_difficulty'] ?>"><?= $routineDifficulty['type'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type="submit" value="Filtrar" class="btn btn-primary btn-sm">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                        <?php
                        foreach($routines as $routine) {
                            $routineObjective = Routine_m::getRoutineObjectiveById($routine['objective']);
                            $routineDifficulty = Routine_m::getRoutineDifficultyById($routine['difficulty']);
                            ?>
                            <div class="col-12">
                                <div class="card my-2">
                                    <form method="POST" action="exroutine">
                                        <input name="routine" type="hidden" value="<?= $routine['cod_routine']; ?>">
                                        <div class="card-body">
                                            <h4><?php echo $routine['name']; ?></h4>
                                            <p class="card-text"><?php echo $routine['info']; ?></p>
                                            <div class="row">
                                                <div class="col-2">
                                                    <h5>Objetivo</h5>
                                                    <p class="card-text"><?php echo $routineObjective['type']; ?></p>
                                                </div>
                                                <div class="col-2">
                                                    <h5>Dificultad</h5>
                                                    <p class="card-text"><?php echo $routineDifficulty['type']; ?></p>
                                                </div>
                                                <div class="col-2">
                                                    <input type="submit" value="Ver" class="btn btn-primary btn-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </aside>
            </div>
        </div>    
    </div>
</section>