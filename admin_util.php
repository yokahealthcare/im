<?php

function validateAdminLogin($username, $password): ReturnValue
{
    global $db, $rt;
    $sql="SELECT * FROM admin_account WHERE username='$username';";
    try {
        $isAccountExist = $db->isDataExists($sql);
        if ($isAccountExist) {
            $accountData = $db->fetchAllRow($sql);
            $accountPassword = $accountData[0]->password;
            if (password_verify($password, $accountPassword)) {
                $accountUsername = $accountData[0]->username;

                // User session storing
                $_SESSION['username'] = $accountUsername;

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