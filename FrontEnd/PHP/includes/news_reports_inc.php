<?php

include "../classes/News_Reports/news_reports-contr.classes.php";
include "../classes/News_Categories/news_ctgs-contr.classes.php";
include "../classes/News_Tags/news_tags-contr.classes.php";
include "../classes/Image/image-contr.classes.php";
include "../classes/Video/videos-contr.classes.php";


//Inserción de noticia mediante ajax
if (isset($_POST["ajax_insert_report"])) {
    //$id_ReportT = $_POST["idUser"];
    $signT = $_POST["signT"];
    $streetT = $_POST["streetT"];
    $neighbourhoodT = $_POST["neighbourhoodT"];
    $cityT = $_POST["cityT"];
    $countryT = $_POST["countryT"];
    $event_date = $_POST["event_date"];
    $headerT = $_POST["headerT"];
    $descriptionT = $_POST["descriptionT"];
    $contentT = $_POST["contentT"];
    $thumbnailT = $_POST["thumbnailT"];

    if (isset($_POST["tags"]))
        $tags = $_POST["tags"];

    $categories = $_POST["sections"];

    if (isset($_POST["extra_pics"]))
        $extra_pics = $_POST["extra_pics"];

    if (isset($_POST["extra_vids"]))
        $extra_vids = $_POST["extra_vids"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $reportTemp =  News_ReportsControler::withInfo($signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by);

    $new_insert = $reportTemp->insertNewsReport();

    if ($new_insert == 0) {
        echo 'No se logro insertar con la noticia: ';
    } else {

        foreach ($categories as $ctg) {
            News_CategoriesContr::withId($ctg, $new_insert, $updated_by)->insert();
        }

        if (isset($_POST["tags"])) {
            foreach ($tags as $tag) {
                News_TagsContr::withId($tag, $new_insert, $updated_by)->insert();
            }
        }

        if (isset($_POST["extra_pics"])) {
            foreach ($extra_pics as $pic) {
                ImageContr::withImage($pic, $new_insert)->insert();
            }
        }

        if (isset($_POST["extra_vids"])) {
            foreach ($extra_vids as $video) {
                VideoContr::withVideo($video, $new_insert, $updated_by)->insert();
            }
        }


        echo 'Se logro c:';
    }
}

//Actualizacion de noticia mediante ajax
if (isset($_POST["ajax_update_report"])) {
    $id_ReportT = $_POST["reportIdT"];
    $signT = $_POST["signT"];
    $streetT = $_POST["streetT"];
    $neighbourhoodT = $_POST["neighbourhoodT"];
    $cityT = $_POST["cityT"];
    $countryT = $_POST["countryT"];
    $event_date = $_POST["event_date"];
    $headerT = $_POST["headerT"];
    $descriptionT = $_POST["descriptionT"];
    $contentT = $_POST["contentT"];
    $thumbnailT = $_POST["thumbnailT"];

    if (isset($_POST["tags"]))
        $tags = $_POST["tags"];

    if (isset($_POST["sections"]))
        $categories = $_POST["sections"];

    if (isset($_POST["extra_pics"]))
        $extra_pics = $_POST["extra_pics"];

    if (isset($_POST["extra_vids"]))
        $extra_vids = $_POST["extra_vids"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $reportTemp =  News_ReportsControler::withId($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by);

    $reportTemp->updateNewsReport();


    if (isset($_POST["sections"])) {
        foreach ($categories as $ctg) {
            News_CategoriesContr::withId($ctg, $id_ReportT, $updated_by)->insert();
        }
    }

    if (isset($_POST["tags"])) {
        foreach ($tags as $tag) {
            News_TagsContr::withId($tag, $id_ReportT, $updated_by)->insert();
        }
    }

    if (isset($_POST["extra_pics"])) {
        foreach ($extra_pics as $pic) {
            ImageContr::withImage($pic, $id_ReportT)->insert();
        }
    }

    if (isset($_POST["extra_vids"])) {
        foreach ($extra_vids as $video) {
            VideoContr::withVideo($video, $id_ReportT, $updated_by)->insert();
        }
    }


    echo 'Se logro c:';
}


if(isset($_POST['ajax_delete_news_category'])){
    $sectionIdT = $_POST["sectionidT"];
    $id_ReportT = $_POST["reportIdT"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $news_categoryTemp =  News_CategoriesContr::withId($sectionIdT, $id_ReportT, $updated_by);

    $news_categoryTemp->delete();
}

if(isset($_POST['ajax_delete_news_tag'])){
    $tagT = $_POST["tagT"];
    $id_ReportT = $_POST["reportIdT"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $news_tagTemp =  News_TagsContr::withId($tagT, $id_ReportT, $updated_by);

    $news_tagTemp->delete();
}

if(isset($_POST['ajax_delete_image'])){
    $imageIdT = $_POST["imageIdT"];
    $id_ReportT = $_POST["reportIdT"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $imageTemp =  ImageContr::withId($imageIdT, $id_ReportT);

    $imageTemp->delete();
}

if(isset($_POST['ajax_delete_video'])){
    $videoIdT = $_POST["videoIdT"];
    $id_ReportT = $_POST["reportIdT"];

    session_start();
    $updated_by = $_SESSION["user"]["ID_USER"];

    $videoTemp =  VideoContr::withId($videoIdT, $id_ReportT);

    $videoTemp->delete();
}