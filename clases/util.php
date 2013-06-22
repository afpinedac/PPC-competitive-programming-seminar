<?php

class util {

    static function generateID($posx, $posy) {
        $posx = round($posx);
        $posy = round($posy);
        return "x_" . $posx . "_y_" . $posy;
    }

    static function escapar(&$var) {
        foreach ($var as $key => $value) {
            if (!is_array($value))
                $var[$key] = trim(addslashes($value));
        }
    }

}

?>
