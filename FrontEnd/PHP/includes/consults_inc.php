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

if (isset($_POST["ajax_get_news_f_journalist"])) {

    $journalist = 0;
    session_start();
    if(isset($_SESSION["user"])){
        $journalist = $_SESSION["user"]["ID_USER"];
    }
    $consult = new ConsultsControler();
    $news= $consult->getJournalistNews($journalist);
    echo json_encode($news);

}

if (isset($_POST["ajax_get_news_details"])) {

    $reportId = $_POST['reportId'];
    
    $consult = new ConsultsControler();
    $report= $consult->getReportById($reportId);
    echo json_encode($report);

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

if (isset($_POST["ajax_get_report_sections"])) {
    $reportId = $_POST["reportId"];

    $consult = new ConsultsControler();
    $sections= $consult->getReportCtgs($reportId);
    echo json_encode($sections);
}

if (isset($_POST["ajax_get_active_tags"])) {

    $consult = new ConsultsControler();
    $activeTags = $consult->getATags();
    echo json_encode($activeTags);
}

if (isset($_POST["ajax_get_report_tags"])) {
    $reportId = $_POST["reportId"];

    $consult = new ConsultsControler();
    $tags= $consult->getReportTags($reportId);
    echo json_encode($tags);
}

if (isset($_POST["ajax_get_report_imgs"])) {
    $reportId = $_POST["reportId"];

    $consult = new ConsultsControler();
    $images= $consult->getReportImages($reportId);
    echo json_encode($images);
}

if (isset($_POST["ajax_get_report_videos"])) {
    $reportId = $_POST["reportId"];

    $consult = new ConsultsControler();
    $videos= $consult->getReportVideos($reportId);
    echo json_encode($videos);
}