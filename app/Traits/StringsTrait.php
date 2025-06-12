<?php

namespace App\Traits;

trait StringsTrait
{
    public function generate_token($length=5)
    {
        $num_length = intval(pow(9*10,$length));
        return rand(pow(10,$length), $num_length);
    }

    public function generateString($length = 15)
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $length);
    }

    function removeAccents($str)
    {
        return trim(preg_replace('~[^0-9a-z]+~i', ' ', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8'))), ' ');
    }


}
