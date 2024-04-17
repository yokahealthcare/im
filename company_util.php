<?php

use App\DB;
use App\EmailSender;
use JetBrains\PhpStorm\NoReturn;

$db = new DB();



function validateCompanyUpdateVacancy($id, $title, $description, $status)
{
    global $db, $rt;
    $sql = "UPDATE vacancy SET title='$title', description='$description', status='$status' WHERE id='$id';";

    try {
        $isVacancyUpdated = $db->updateData($sql);
        if ($isVacancyUpdated) {
            $rt->code = 200;
            $rt->message = "vacancy_update_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "vacancy_update_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}


function validateCompanyCreateVacancy($id, $title, $description, $status, $account)
{
    global $db, $rt;
    $sql = "INSERT INTO vacancy (id, title, description, status, account) VALUES ('$id', '$title', '$description', '$status', '$account');";
    try {
        $isVacancyDataInserted = $db->insertRow($sql);
        if ($isVacancyDataInserted) {
            $rt->code = 200;
            $rt->message = "vacancy_create_sucess";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "vacancy_create_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateCompanyRemoveVacancy($id)
{
    global $db, $rt;
    $sqlApplyTable = "DELETE FROM apply WHERE vacancy='$id';";
    $sqlVacancyTable = "DELETE FROM vacancy WHERE id='$id';";

    try {
        $isApplyTableDeleted = $db->deleteRow($sqlApplyTable);
        $isVancancyTableDeleted = $db->deleteRow($sqlVacancyTable);

        if ($isApplyTableDeleted && $isVancancyTableDeleted) {
            $rt->code = 200;
            $rt->message = "vacancy_remove_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "vacancy_remove_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}