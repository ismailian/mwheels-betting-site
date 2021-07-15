<?php

class Response
{

    public static function json(String $status, array $data = ["message" => "No Message!"])
    {

        // send response in Json Format:
        header("Content-Type: application/json");
        http_response_code(200);

        echo json_encode(array_merge(["status" => $status], $data));
        exit(); //

    }

    public static function text(String $status, array $data = ["message" => "No Message!"])
    {

        // send response in text Format:
        header("Content-Type: html/text");
        http_response_code(200);

        echo json_encode(array_merge(["status" => $status], $data));
        exit(); //

    }

    // not found response:
    public static function notFound(String $message)
    {

        // send response in Json Format:
        header("Content-Type: application/json");
        http_response_code(404);

        echo json_encode(["status" => "404 Not Found", "info" => $message]);
        exit(); //

    }

    // not authorized response:
    public static function notAuthorized(String $message = null)
    {

        // send response in Json Format:
        header("Content-Type: application/json");
        http_response_code(401);

        $default = "You don't have permissions to perform this action.";

        echo json_encode([
            "status" => "401 Unauthorized",
            "info" => is_null($message) ? $default : $message,
        ]);
        exit(); //

    }

    public static function serverFailure(String $message)
    {

        // send response in Json Format:
        header("Content-Type: application/json");
        http_response_code(500);

        echo json_encode(["status" => "500 Internal Server Error", "info" => $message]);
        exit(); //

    }

    // response with and error:
    public static function default_error($message = null)
    {
        ## error ##
        Response::json("error", [
            "info" => !is_null($message) ? $message : "Sorry, something went wrong!",
        ]);
        ## error ##
    }

    // dump:
    public static function dump($message)
    {
        ## error ##
        Response::json("debug", $message);
        ## error ##
    }
}
