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


class ReturnValue {
    public $code;
    public $message;
}
$rt = new ReturnValue();

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

function sendVerificationEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "New Account Verification";
    $message = "Thank you for joining with us. One more step, we need to verify your account by clicking this link, http://$server:$port/api/user/account/verified?email=$email";

    sendEmail($email, $subject, $message);
}


function validateSendResetPasswordEmail($email): void
{
    global $db;

    $sql="SELECT * FROM account WHERE email='$email';";
    $isAccountExist = $db->isDataExists($sql);
    if ($isAccountExist) {
        sendResetPasswordEmail($email);
    }
}

function sendResetPasswordEmail($email): void
{
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $subject = "Reset Password";
    $message = "Sorry for your lost password. One more step, we need to reset your password account by clicking this link, http://$server:$port/user_reset_password.php?email=$email";

    sendEmail($email, $subject, $message);
}