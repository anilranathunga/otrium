<?php


namespace src\utils;


class Session
{

    public static function setFlash(string $type, string $message)
    {
        $_SESSION['messages'][$type] = [];
        $_SESSION['messages'][$type][] = $message;
    }

    public static function getFlash(string $type)
    {
        $messages = [];
        if(array_key_exists('messages',$_SESSION)) {
            $messages = $_SESSION['messages'][$type];
            $_SESSION['messages'][$type] = [];
        }

        return $messages;
    }
}