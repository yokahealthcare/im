<?php

use App\DB;
use App\EmailSender;
use JetBrains\PhpStorm\NoReturn;

$db = new DB();


/*
 * FETCH
 */

function fetchUserProfile($email): bool|string
{
    global $db;
    $sql = "SELECT * FROM user_account WHERE email='$email';";

    $customers = $db->fetchAllRow($sql);
    return json_encode($customers);
}

function fetchUserApply($email): bool|string
{
    global $db;
    $sql = "SELECT * FROM vacancy WHERE EXISTS (SELECT * FROM apply WHERE vacancy.id = apply.vacancy_id) AND status = 'open';";
    $applies = $db->fetchAllRow($sql);
    return json_encode($applies);
}






/*
 * VALIDATOR
 */


function validateUserLogin($email, $password)
{
    global $db, $rt;
    $sql="SELECT * FROM user_account WHERE email='$email';";
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

                // User session storing
                $_SESSION['name'] = $accountName;
                $_SESSION['email'] = $accountEmail;
                $_SESSION['about'] = $accountAbout;
                $_SESSION['address'] = $accountAddress;

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


function validateUserSignup($name, $email, $password)
{
    global $db, $rt;
    $encryptedPassword = encryptPassword($password);
    $sql = "INSERT INTO user_account (email, name, password) VALUES ('$email', '$name', '$encryptedPassword');";

    try {
        $isDataInsertedSuccessfully = $db->insertRow($sql);
        if ($isDataInsertedSuccessfully) {
            sendUserVerificationEmail($email);

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
function validateUserVerifyAccount($email)
{
    global $db, $rt;
    $sql = "UPDATE user_account SET verified=1 WHERE email='$email';";

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

function validateUserUpdateAccount($email, $name, $about, $address)
{
    global $db, $rt;
    $sql = "UPDATE user_account SET name='$name', about='$about', address='$address' WHERE email='$email';";

    try {
        $isProfileUpdated = $db->updateData($sql);
        if ($isProfileUpdated) {
            # Session being updated also
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['about'] = $about;
            $_SESSION['address'] = $address;

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


function validateUserUpdatePassword($email, $password)
{
    global $db, $rt;
    $encryptedPassword = encryptPassword($password);
    $sql = "UPDATE user_account SET password='$encryptedPassword' WHERE email='$email';";

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

function validateUserApplyVacancy($id, $user_id, $vacancy_id)
{
    global $db, $rt;
    $sqlCheckRow = "SELECT * FROM apply WHERE user_id='$user_id' AND vacancy_id='$vacancy_id';";
    $sqlInsert = "INSERT INTO apply (apply_id, user_id, vacancy_id) VALUES ('$id', '$user_id', '$vacancy_id');";
    try {
        $isApplyExist = $db->isDataExists($sqlCheckRow);
        if ($isApplyExist) {
            $rt->code = 400;
            $rt->message = "apply_already_exist";
            return $rt;
        }

        $isDataInserted = $db->insertRow($sqlInsert);
        if ($isDataInserted) {
            $rt->code = 200;
            $rt->message = "apply_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "apply_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}

function validateUserRemoveVacancy($vacancy_id)
{
    global $db, $rt;
    $sqlRemove = "DELETE FROM apply WHERE vacancy_id='$vacancy_id';";

    try {
        $isApplyDeleted = $db->deleteRow($sqlRemove);
        if ($isApplyDeleted) {
            $rt->code = 200;
            $rt->message = "apply_remove_success";
            return $rt;
        }

        $rt->code = 400;
        $rt->message = "apply_remove_failed";
        return $rt;
    } catch (PDOException $e) {
        $rt->code = 500;
        $rt->message = "database_error : $e";
        return $rt;
    }
}




