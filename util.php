<?php

session_start();

use App\DB;
use App\EmailSender;
use JetBrains\PhpStorm\NoReturn;

$db = new DB();

function encryptPassword($plain_password): string
{
    return password_hash($plain_password, PASSWORD_DEFAULT);
}

#[NoReturn] function send200($path, $message): void
{
    $params = "?code=200&message=$message";
    redirectTo($path . $params);
}

#[NoReturn] function send400($path, $message): void
{
    $params = "?code=400&message=$message";
    redirectTo($path . $params);
}

#[NoReturn] function send500($path, $message="server_error"): void
{
    $params = "?code=500&message=$message";
    redirectTo($path . $params);
}

#[NoReturn] function redirectTo($path): void
{
    header("Location: $path");
    exit();
}

/*
 * SESSION MANAGEMENT
 */
function isLogged(): bool
{
    if (isset($_SESSION['email']) && isset($_SESSION['name']))
        return true;
    else
        return false;
}

function isLoggedAdmin(): bool
{
    if (isset($_SESSION['username']))
        return true;
    else
        return false;
}

function getSessionUsername()
{
    return $_SESSION['admin_username'];
}

function getSessionName()
{
    return $_SESSION['name'];
}

function getSessionEmail()
{
    return $_SESSION['email'];
}
function getSessionAbout()
{
    return $_SESSION['about'];
}

function getSessionAddress()
{
    return $_SESSION['address'];
}

function getSessionWebsite()
{
    return $_SESSION['website'];
}

function getSessionIndustry()
{
    return $_SESSION['industry'];
}

function getSessionFounded()
{
    return $_SESSION['founded'];
}

function getSessionSize()
{
    return $_SESSION['size'];
}


class ReturnValue {
    public $code;
    public $message;
}
$rt = new ReturnValue();

function fetchAllVacancy($search='', $literal_all=false): bool|string
{
    global $db;
    if($literal_all)
        $sql = "SELECT * FROM vacancy WHERE NOT EXISTS (SELECT * FROM apply WHERE vacancy.id = apply.vacancy_id) AND title LIKE '%$search%';";
    else
        $sql = "SELECT * FROM vacancy WHERE NOT EXISTS (SELECT * FROM apply WHERE vacancy.id = apply.vacancy_id) AND title LIKE '%$search%'AND status = 'Open';";

    $vacancies = $db->fetchAllRow($sql);
    return json_encode($vacancies);
}

function fetchVacancyInfo($vacancy_id): bool|string
{
    global $db;
    $sql = "SELECT * FROM vacancy WHERE id='$vacancy_id';";
    $vacancy = $db->fetchAllRow($sql);
    return json_encode($vacancy);
}

function fetchCompanyInfo($company_id): bool|string
{
    global $db;
    $sql = "SELECT * FROM company_account WHERE email='$company_id';";
    $vacancy = $db->fetchAllRow($sql);
    return json_encode($vacancy);
}

function sendEmail($to, $subject, $message): int
{
    $email = new EmailSender();
    try {
        // email address - who to send
        $email->mail->addAddress($to);
        // email content
        $email->mail->isHTML(true);
        $email->mail->Subject = $subject;
        $email->mail->Body    = $message;
        // Send the email
        $email->mail->send();

        return 200;
    } catch (Exception $e) {
        return 500;
    }
}

function validateLogout(): int
{
    session_unset();
    session_destroy();
    return 200;
}

function validateUserSendResetPasswordEmail($email): void
{
    global $db;

    $sql="SELECT * FROM user_account WHERE email='$email';";
    $isAccountExist = $db->isDataExists($sql);
    if ($isAccountExist) {
        sendUserResetPasswordEmail($email);
    }
}

function validateCompanySendResetPasswordEmail($email): void
{
    global $db;

    $sql="SELECT * FROM company_account WHERE email='$email';";
    $isAccountExist = $db->isDataExists($sql);
    if ($isAccountExist) {
        sendCompanyResetPasswordEmail($email);
    }
}

function validateCompanySendVacancyApproveEmail($email, $company_name, $job_title, $vacancy_id): void
{
    global $db;

    $sql="SELECT * FROM user_account WHERE email='$email';";
    $isAccountExist = $db->isDataExists($sql);
    if ($isAccountExist) {
        sendCompanyVacancyApproveEmail($email, $company_name, $job_title);

        # delete the data
        $sqlRemove = "DELETE FROM apply WHERE user_id='$email' AND vacancy_id='$vacancy_id';";
        $db->deleteRow($sqlRemove);
    }
}

function sendUserResetPasswordEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "InternMatch - Reset Password";
    $message = "Sorry for your lost password. One more step, we need to reset your password account by clicking this link, http://$server:$port/user_reset_password.php?email=$email";

    sendEmail($email, $subject, $message);
}

function sendCompanyResetPasswordEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "InternMatch - Reset Password";
    $message = "Sorry for your lost password. One more step, we need to reset your password account by clicking this link, http://$server:$port/company_reset_password.php?email=$email";

    sendEmail($email, $subject, $message);
}

function sendUserVerificationEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "InternMatch - New Account Verification";
    $message = "Thank you for joining with us. One more step, we need to verify your account by clicking this link, http://$server:$port/api/user/account/verified?email=$email";

    sendEmail($email, $subject, $message);
}

function sendCompanyVerificationEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "InternMatch - New Account Verification";
    $message = "Thank you for joining with us. One more step, we need to verify your account by clicking this link, http://$server:$port/api/company/account/verified?email=$email";

    sendEmail($email, $subject, $message);
}


function sendCompanyVacancyApproveEmail($email, $company_name, $job_title): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "InternMatch - Congratulations!";
    $message = "We are pleased to inform you that you have been selected as a potential candidate for the <b>$job_title</b> position at <b>$company_name</b>. Your application stood out among a competitive pool, and we'd like to learn more about your qualifications and how you could contribute to our team. <br><br> We will hold a follow-up session, namely an interview session, you can determine the day and time by replying to this email. <br><br> Thank You <br> <b>$company_name</b>";

    sendEmail($email, $subject, $message);
}