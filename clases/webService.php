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
        $info = ws::getText("http://uhunt.felix-halim.net/api/subs/" . $id);
        $info = json_decode($info);
        $options = json_decode($info->subs);
        return $options;
    }

    static function getInfoProblem($id, $data) {
        $info = ws::getText("http://uhunt.felix-halim.net/api/p/num/" . $id);
        $info = json_decode($info);
        return $info->{$data};
    }

    static function getInfoProblem2($id, $data) {
        $info = ws::getText("http://uhunt.felix-halim.net/api/p/id/" . $id);
        $info = json_decode($info);
        return $info->{$data};
    }

}

?>
