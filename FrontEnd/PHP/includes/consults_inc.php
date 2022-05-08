<?php

include "../classes/Consult/consult-contr.classes.php";

//Obtener los reporteros mediante formulario
if (isset($_POST["ajax_get_journalists"])) {

    $consult = new ConsultsControler();
    $journalists = $consult->getAllJournalists();
    echo json_encode($journalists);
}

if (isset($_POST["ajax_get_users"])) {

    $consult = new ConsultsControler();
    $users= $consult->getAllRUsers();
    echo json_encode($users);
}

if (isset($_POST["ajax_get_active_sections_PE"])) {

    $consult = new ConsultsControler();
    $activeSections= $consult->getASections();
    echo json_encode($activeSections);
}

if (isset($_POST["ajax_get_deleted_sections_PE"])) {

    $consult = new ConsultsControler();
    $deletedSections= $consult->getESections();
    echo json_encode($deletedSections);
}