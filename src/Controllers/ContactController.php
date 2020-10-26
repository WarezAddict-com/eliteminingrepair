<?php

// Namespace
namespace Elite\Controllers;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// ContactController
class ContactController extends \Elite\Controllers\Controller
{
    /** POST Route **/
    public function post(Request $request, Response $response, array $args)
    {

        // If AJAX POST
        if ($request->isXhr()) {

            // Set Vars
            $name = filter_var($_POST['cName'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['cEmail'], FILTER_SANITIZE_STRING);
            $phone = filter_var($_POST['cPhone'], FILTER_SANITIZE_STRING);
            $message = filter_var($_POST['cMessage'], FILTER_SANITIZE_STRING);

            // Log Data
            $logData = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message
            );

            // Log To File
            $this->logger->info('CONTACT', $logData);

            // Setup Email Message
            $content = "From: " . $name . "\n" . "Email: " . $email . "\n" . "Phone: " . $phone . "\n" . "Message: " . $message . "\n";
            $sendTo = getenv('SEND_TO');
            $emailSubject = getenv('EMAIL_SUB');
            $mailHeader = 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'X-Mailer: PHP/' . phpversion();

            // Try Sending Email
            if (mail($sendTo, $emailSubject, $content, $mailHeader)) {
                // Success Message
                $data = [
                    'type' => 'success',
                    'message' => 'Thank you! I will contact you ASAP or call us at (304)465-0513',
                ];
                // Return (Success) Response
                return $response->withJson($data);
            } else {
                // Error Message
                $data = [
                    'type' => 'danger',
                    'message' => 'Error! Please try again later or call us at (304) 465-0513',
                ];
                // Return (Error) Response
                return $response->withJson($data);
            }
        } else {
            // NOT AJAX Message
            $data = [
                'type' => 'danger',
                'message' => 'Error! Please try again later or call us at (304) 465-0513',
            ];
            // Return (NOT AJAX) Response
            return $response->withJson($data);
        }
    }

    // GET Route
    public function get(Request $request, Response $response, array $args)
    {
        // GET Error Message
        $data = [
            'error' => 'Error! Visit https://www.eliteminingrepair.com'
        ];
        // Return (Error) Message
        return $response->withJson($data);
    }
}
