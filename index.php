<?php

use App\DB;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Initiate DB Instance
$db = new DB();

$app->get('/api', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Testing page, if you can see this page then it working!");
    return $response;
});

/*
 * FETCHING API
 */

$app->get('/api/user/profile/fetch', function (Request $request, Response $response) {
    $input = $request->getQueryParams();
    /*
     * input['email']           : User email
     */
    $customers = fetchUserProfile($input['email']);
    $response->getBody()->write($customers);
    return $response->withHeader('content-type', 'application/json')->withStatus(200);
});

$app->get('/api/user/vacancy/fetch', function (Request $request, Response $response, $args) {
    $input = $request->getQueryParams();
    /*
     * input['search']           : Search Vacancy by Query
     */
    if(isset($input['search']))
        $vacancies = fetchAllVacancy($input['search']);
    else
        $vacancies = fetchAllVacancy();

    $response->getBody()->write($vacancies);
    return $response->withHeader('content-type', 'application/json')->withStatus(200);
});

$app->get('/api/user/apply/fetch', function (Request $request, Response $response, $args) {
    $input = $request->getQueryParams();
    /*
     * input['email']           : User email
     */
    $applies = fetchUserApply($input['email']);
    $response->getBody()->write($applies);
    return $response->withHeader('content-type', 'application/json')->withStatus(200);
});


/*
 * UTILITY
 */
$app->get('/api/logout', function (Request $request, Response $response, $args) {
    validateLogout();
    send200("../welcome.php", "logout_success");
});


/*
 * USER
 */

$app->post('/api/user/email/send_reset_password', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['email']           : Recipient email
     */

    validateSendResetPasswordEmail($input['email']);
    send200("../../../user_login.php", "reset_password_email_sent_successfully");
});

/*
 * VALIDATOR API
 */

$app->post('/api/user/login', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['email']           : User email
     * input['password']        : User password
     */

    $status = validateUserLogin($input['email'], $input['password']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../user_dashboard.php", $message);
    } elseif ($code == 400) {
        send400("../../user_login.php", $message);
    } elseif ($code == 500) {
        send500("../../user_login.php", $message);
    }
    return $response;
});




$app->post('/api/user/signup', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['name']            : Name of the person
     * input['email']           : User email
     * input['password']        : User password
     */

    $status = validateUserSignup($input['name'], $input['email'], $input['password']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../user_email_verification.php", $message);
    } elseif ($code == 400) {
        send400("../../user_signup.php", $message);
    } elseif ($code == 500) {
        send500("../../user_signup.php", $message);
    }
    return $response;
});

$app->get('/api/user/account/verified', function (Request $request, Response $response, $args) {
    $input = $request->getQueryParams();
    /*
     * input['email']            : Email of the account
     */

    $status = validateUserVerifyAccount($input['email']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../user_login.php", $message);
    } elseif ($code == 400) {
        send400("../../../user_login.php", $message);
    } elseif ($code == 500) {
        send500("../../../user_login.php", $message);
    }

    return $response;
});

$app->post('/api/user/account/update', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['email']           : Email of the person
     * input['name']            : Name of the person
     * input['about']         : Description about that person (length: 1000)
     * input['address']         : Address of person
     */

    $status = validateUserUpdateAccount($input['email'], $input['name'], $input['about'], $input['address']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../user_profile.php", $message);
    } elseif ($code == 400) {
        send400("../../../user_profile.php", $message);
    } elseif ($code == 500) {
        send500("../../../user_profile.php", $message);
    }
    return $response;

});

$app->post('/api/user/password/update', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['email']           : User email
     * input['password']        : User new password
     */

    $status = validateUserUpdatePassword($input['email'], $input['password']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../user_login.php", $message);
    } elseif ($code == 400) {
        send400("../../../user_login.php", $message);
    } elseif ($code == 500) {
        send500("../../../user_login.php", $message);
    }
    return $response;
});


$app->post('/api/user/vacancy/apply', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['user_id']         : Account person who apply
     * input['vacancy_id']         : Vacancy ID that the person applied
     */

    $id = uniqid(); // Create new apply ID
    $status = validateUserApplyVacancy($id, $input['user_id'], $input['vacancy_id']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../user_vacancy.php", $message);
    } elseif ($code == 400) {
        send400("../../../user_vacancy.php", $message);
    } elseif ($code == 500) {
        send500("../../../user_vacancy.php", $message);
    }
    return $response;

});








/*
 *
 * COMPANY
 *
 */

$app->post('/api/company/vacancy/create', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['title']           : Title of the vacancy
     * input['description']     : Description of the vacancy
     * input['status']          : Status of the vacancy
     * input['account']         : Account ID creator
     */

    $id = uniqid(); // Create new apply ID
    $status = validateCompanyCreateVacancy($id, $input['title'], $input['description'], $input['status'], $input['account']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../vacancy.php", $message);
    } elseif ($code == 400) {
        send400("../../../vacancy.php", $message);
    } elseif ($code == 500) {
        send500("../../../vacancy.php", $message);
    }
    return $response;

});

$app->post('/api/company/vacancy/update', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['id']                  : Vacancy ID
     * input['title']               : Title of vacancy
     * input['description']         : Description of vacancy
     * input['status']              : Status of vacancy
     */

    $status = validateCompanyUpdateVacancy($input['id'], $input['title'], $input['description'], $input['status']);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../vacancy.php", $message);
    } elseif ($code == 400) {
        send400("../../../vacancy.php", $message);
    } elseif ($code == 500) {
        send500("../../../vacancy.php", $message);
    }
    return $response;
});

$app->post('/api/company/vacancy/remove', function (Request $request, Response $response, $args) {
    $input = (array)$request->getParsedBody();
    /*
     * input['id']         : Vacancy ID
     */

    $status = validateCompanyRemoveVacancy($input["id"]);
    $code = $status->code;
    $message = $status->message;

    if ($code == 200) {
        send200("../../../vacancy.php", $message);
    } elseif ($code == 400) {
        send400("../../../vacancy.php", $message);
    } elseif ($code == 500) {
        send500("../../../vacancy.php", $message);
    }
    return $response;
});

$app->run();