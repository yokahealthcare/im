<?php

use App\DB;
use App\EmailSender;
use JetBrains\PhpStorm\NoReturn;

$db = new DB();

/*
 * FETCH
 */

function fetchCompanyProfile($email): bool|string
{
    global $db;
    $sql = "SELECT * FROM company_account WHERE email='$email';";

    $customers = $db->fetchAllRow($sql);
    return json_encode($customers);
}

function fetchCompanyVacancy($company_id, $search=''): bool|string
{
    global $db;
    $sql = "SELECT * FROM vacancy WHERE company_id='$company_id' AND title LIKE '%$search%';;";

    $customers = $db->fetchAllRow($sql);
    return json_encode($customers);
}

function fetchCompanyApply($vacancy_id): bool|string
{
    global $db;
    $sql = "SELECT * FROM apply WHERE vacancy_id='$vacancy_id';";
    $applies = $db->fetchAllRow($sql);
    return json_encode($applies);
}





/*
 * VALIDATOR
 */

function validateCompanyLogin($email, $password): ReturnValue
{
    global $db, $rt;
    $sql="SELECT * FROM company_account WHERE email='$email';";
    try {
        $isAccountExist = $db->isDataExists($sql);
        if ($isAccountExist) {
            $accountData = $db->fetchAllRow($sql);
            $accountPassword = $accountData[0]->password;
            if (password_verify($password, $accountPassword)) {
                $accountVerified = $accountData[0]->verified;
                if($accountVerified == "0") {
                    $rt->code = 400;
                    $rt->message = "account_not_verified";
                    return $rt;
                }

                $accountName = $accountData[0]->name;
                $accountEmail = $accountData[0]->email;
                $accountAbout = $accountData[0]->about;
                $accountAddress = $accountData[0]->address;
                $accountWebsite = $accountData[0]->website;
                $accountIndustry = $accountData[0]->industry;
                $accountFounded = $accountData[0]->founded;
                $accountSize = $accountData[0]->size;

                // User session storing
                $_SESSION['name'] = $accountName;
                $_SESSION['email'] = $accountEmail;
                $_SESSION['about'] = $accountAbout;
                $_SESSION['address'] = $accountAddress;
                $_SESSION['website'] = $accountWebsite;
                $_SESSION['industry'] = $accountIndustry;
                $_SESSION['founded'] = $accountFounded;
                $_SESSION['size'] = $accountSize;

                $rt->code = 200;
                $rt->message = "login_success";
            } else {
                $rt->code = 400;
                $rt->message = "invalid_credential";
            }
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "account_not_exist";
        return $rt;

    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateCompanySignup($name, $email, $password, $industry, $founded, $size): ReturnValue
{
    global $db, $rt;
    $encryptedPassword = encryptPassword($password);
    $sql = "INSERT INTO company_account (email, name, password, industry, founded, size) VALUES ('$email', '$name', '$encryptedPassword', '$industry', '$founded', '$size');";

    try {
        $isDataInsertedSuccessfully = $db->insertRow($sql);
        if ($isDataInsertedSuccessfully) {
            sendCompanyVerificationEmail($email);

            $rt->code = 200;
            $rt->message = "signup_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "signup_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateCompanyVerifyAccount($email)
{
    global $db, $rt;
    $sql = "UPDATE company_account SET verified=1 WHERE email='$email';";

    try {
        $isVerifiedUpdated = $db->updateData($sql);
        if ($isVerifiedUpdated) {
            $rt->code = 200;
            $rt->message = "verified_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "verified_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateCompanyUpdateAccount($email, $name, $about, $address, $website, $industry, $founded, $size)
{
    global $db, $rt;
    $sql = "UPDATE company_account SET name='$name', about='$about', address='$address', website='$website', industry='$industry', founded='$founded', size='$size' WHERE email='$email';";

    try {
        $isProfileUpdated = $db->updateData($sql);
        if ($isProfileUpdated) {
            # Session being updated also
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['about'] = $about;
            $_SESSION['address'] = $address;
            $_SESSION['website'] = $website;
            $_SESSION['industry'] = $industry;
            $_SESSION['founded'] = $founded;
            $_SESSION['size'] = $size;

            $rt->code = 200;
            $rt->message = "update_account_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "update_account_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}


function validateCompanyUpdatePassword($email, $password)
{
    global $db, $rt;
    $encryptedPassword = encryptPassword($password);
    $sql = "UPDATE company_account SET password='$encryptedPassword' WHERE email='$email';";

    try {
        $isPasswordUpdated = $db->updateData($sql);
        if ($isPasswordUpdated) {
            $rt->code = 200;
            $rt->message = "password_update_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "password_update_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateCompanyUpdateVacancy($id, $title, $location, $description, $workplace_type, $job_type, $status)
{
    global $db, $rt;
    $sql = "UPDATE vacancy SET 
                   title='$title', 
                   location='$location',
                   description='$description',
                   workplace_type='$workplace_type',
                   job_type='$job_type',
                   status='$status'
               WHERE id='$id';";
    echo $sql;
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


function validateCompanyCreateVacancy($id, $title, $location, $description, $workplace_type, $job_type, $status, $company_id)
{
    global $db, $rt;
    $sql = "INSERT INTO vacancy (id, title, location, description, workplace_type, job_type, status, company_id) VALUES ('$id', '$title', '$location', '$description', '$workplace_type', '$job_type', '$status', '$company_id');";
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
    $sqlApplyTable = "DELETE FROM apply WHERE vacancy_id='$id';";
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