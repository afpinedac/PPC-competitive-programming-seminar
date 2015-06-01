<?php

class ws {

    function __construct() {
        
    }

    static function getText($page) {
        $url = fopen($page, "r");
        if ($url) {
            $texto = "";
            while (!feof($url)) {
                $texto.=fgets($url, 255);
            }
            return $texto;
        } else {
            throw new Exception("No se pudo leer el archivo");
        }
    }

    static function getIdUser($username) {
        //  echo "ws:: " . $username;
        return ws::getText("http://uhunt.felix-halim.net/api/uname2uid/" . $username);
    }

    static function getSubmissions($id) {
        $info = ws::getText("http://uhunt.felix-halim.net/api/subs-user/" . $id);
        $info = json_decode($info);
        $options = $info->subs;
        return $options;
    }

    static function getInfoProblem($id, $data) {
        $info = ws::getText("http://uhunt.felix-halim.net/api/p/num/" . $id);
        $info = json_decode($info);
        return isset($info->{$data}) ? $info->{$data} : NULL;
    }

    static function getInfoProblem2($id, $data) {
        $info = ws::getText("http://uhunt.felix-halim.net/api/p/id/" . $id);
        $info = json_decode($info);
        return $info->{$data};
    }

    static function getVerdictID($verdict) {
        switch ($verdict) {
            case 10:
                return 'Submission error';
                break;
            case 15:
                return 'Can\'t be judged';
                break;
            case 20:
                return 'In queue';
                break;
            case 30:
                return ' Compile error';
                break;
            case 35:
                return 'Restricted function';
                break;
            case 40:
                return 'Runtime error';
                break;
            case 45:
                return 'Output limit';
                break;
            case 50:
                return 'Time limit';
                break;
            case 60:
                return 'Memory limit';
                break;
            case 70:
                return 'Wrong answer';
                break;
            case 80:
                return 'PresentationE';
                break;
            case 90:
                return 'Accepted';
                break;
        }
    }

}

?>
