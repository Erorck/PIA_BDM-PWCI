<?php

include "../classes/Section/section-contr.classes.php";

//Actualizacion de sección mediante ajax
if (isset($_POST["ajax_update_section_attr"])) {
    $idCategory = $_POST["id_category"];
    $name = $_POST["name"];
    $color = $_POST["color"];
    $order = $_POST["order"];
    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $sectionTemp =  SectionControler::withId($idCategory, $name, $color, $order, $updated_by);
    if ($sectionTemp->nameIsAvailable()) {
        $sectionTemp->updateSection();
        echo 'Seccion actualizada';
    } else {
        echo 'nameNotAvailable';
    }
}

//Actualizacion de nombre de sección mediante ajax
if (isset($_POST["ajax_update_section_name"])) {
    $idCategory = $_POST["id_category"];
    $name = $_POST["name"];   
    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $sectionTemp =  SectionControler::withId($idCategory, $name, 0, 0, $updated_by);
    if ($sectionTemp->nameIsAvailable()) {
        $sectionTemp->updateSectionName();
        echo 'Seccion actualizada';
    } else {
        echo 'nameNotAvailable';
    }
}

//Inserción de sección mediante ajax
if (isset($_POST["ajax_insert_section"])) {
    $name = $_POST["name"];
    $color = $_POST["color"];
    $order = $_POST["order"];
    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $sectionTemp =  SectionControler::withId(0, $name, $color, $order, $updated_by);
    if ($sectionTemp->nameIsAvailable()) {
        $sectionTemp->insertSection();
        echo 'Seccion insertada';
    } else {
        echo 'nameNotAvailable';
    }
}

//Modificación de estatus de sección mediante ajax
if (isset($_POST["ajax_mod_section_status"])) {
    $idCategory = $_POST["id_category"];
    $statusCategory = $_POST["new_status"];
    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    if ($statusCategory == 'H')
        SectionControler::withId($idCategory, 0, 0, 0, $updated_by)->activateSection();
    else if ($statusCategory == 'E')
        SectionControler::withId($idCategory, 0, 0, 0, $updated_by)->deleteSection();
}

//Reactivación de sección mediante ajax
if (isset($_POST["ajax_reactivate_section"])) {
    $idCategory = $_POST["idCategory"];
    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    SectionControler::withId($idCategory, 0, 0, 0, $updated_by)->activateSection();
}
