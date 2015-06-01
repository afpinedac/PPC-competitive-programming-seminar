<?php

class conector_mysql {

    var $host;
    var $bd;
    var $usuario;
    var $password;
    var $link;
    var $result;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new conector_mysql();
        }
        return self::$instance;
    }

    function __construct() {
        $this->host = 'localhost';
        $this->bd = 'ppc';
        //  $this->puerto = 5432;
        $this->usuario = 'root';
        $this->password = 'root';        
        $link = mysqli_connect($this->host, $this->usuario, $this->password, $this->bd) or die("No se pudo conectar");        
        $this->link = $link;
    }

//
//    function __construct() {
//        $this->host = 'localhost';
//        $this->bd = 'ppc';
//        //  $this->puerto = 5432;
//        $this->usuario = 'root';
//        $this->password = '';
//        $link = mysql_connect($this->host, $this->usuario, $this->password) or die("No se pudo conectar");
//        mysql_selectdb($this->bd, $link);
//        $this->link = $link;
//    }
    //FUNCIONES DE LOGIN
    //funcion que verifica si un usuario se puede loguear
    function checkLogin($user, $pass) {
        // echo "#u : $user , p: $pass";
        $id = $this->getID($user, $pass);
        //var_dump($id);
        if (!$this->isEmpty($id)) {
            return $id;
        } return false;
    }

    function validarCodigo($code, $user) {
        $query = "SELECT id_course FROM course WHERE registration_code='$code'";
        $id = $this->getOneData($this->realizarConsulta($query));
        if (!$this->isEmpty($id)) {
            $query = "SELECT * FROM participant WHERE id_course='$id' AND id_user='$user'";
            $n = $this->numFilas($this->realizarConsulta($query));
            if ($n == 0)
                return $id;
            return false;
        } else {
            return false;
        }
    }

    //FUNCIONES DE LECTURA DE DATOS;
    //USUARIO
    function getInfoUser($id) {

        return $this->realizarConsulta("SELECT * FROM user WHERE id_user='$id'");
    }

    function getInfoUserByCorreo($email) {
        return $this->realizarConsulta("SELECT * FROM user WHERE email='$email'");
    }

    function getID($username, $pass) { // veriifico si existe el user
        $query = "SELECT id_user FROM user WHERE username='$username' AND password='$pass'";
        // echo " # $query";
        return $this->getOneData($this->realizarConsulta($query));
    }

    function registrarUser($data) {
        extract($data);
        $rol = (isset($profesor)) ? 1 : 0;

        $query = "INSERT INTO user(name,lastName,username,password,email,university,rol) VALUES('$name','$lastName','$username','$password','$email','$university',$rol)";
        $this->realizarConsulta($query);
        $id = $this->getOneData($this->realizarConsulta("SELECT max(id_user) FROM user"));
        if ($rol == 1) {
            $query = "INSERT INTO teacher VALUES($id)";
        } else {
            $query = "INSERT INTO student VALUES($id)";
        }
        $this->realizarConsulta($query);
    }

    //CURSOS
    //retorna los cursos que tiene un participante
    function getInfoCurso($id) {
        $query = "SELECT * FROM course WHERE id_course='$id'";
        return $this->realizarConsulta($query);
    }

    function getMyCursos($user) {
        $query = "SELECT id_course FROM participant WHERE id_user='$user'";
        $result = $this->realizarConsulta($query);
        $n = $this->numFilas($result);
        if ($n == 0)
            return false;
        return $result;
    }

    function getMyCursosCreados($user) {
        $query = "SELECT id_course FROM course WHERE id_user='$user'";
        $result = $this->realizarConsulta($query);
        $n = $this->numFilas($result);
        if ($n == 0)
            return false;
        return $result;
    }

    function registrarCurso($user, $name, $code) {
        $query = "SELECT * FROM course WHERE registration_code='$code'";
        $id = $this->getOneData($this->realizarConsulta($query));
        //var_dump($id);
        if ($this->isEmpty($id)) {
            $query = "INSERT INTO course(id_user,name,registration_code) VALUES('$user','$name','$code')";
            $this->realizarConsulta($query);
            return true;
        } else {
            return false;
        }
    }

    function eliminarCursoCreado($curso, $user) {
        //eliminamos primero en participante
        $query = "DELETE FROM participant WHERE id_course='$curso' and id_user='$user'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM course WHERE id_course='$curso' and id_user='$user'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM topic WHERE id_course='$curso'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM position WHERE id_course='$curso'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM sucesor WHERE id_course='$curso'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM problem  WHERE id_course='$curso'";
        $this->realizarConsulta($query);
    }

    function editarCurso($id, $name, $code) {
        $query = "UPDATE course SET name='$name', registration_code='$code' WHERE id_course='$id'";
        //  echo "$query";
        $this->realizarConsulta($query);
    }

    function get_all_participants($course) {
        $query = "SELECT * FROM participant p ,user u  WHERE p.id_course='$course' AND u.id_user = p.id_user ORDER BY u.username";
        return $this->realizarConsulta($query);
    }

    //TOPIC 
    function getInfoTopic($idTopic, $idCourse) {
        $query = "SELECT * FROM topic WHERE id_topic='$idTopic' AND id_course='$idCourse'";
        //  echo $query;
        return $this->realizarConsulta($query);
    }

    function getAllTopics($idCourse) {
        $query = "SELECT * FROM topic WHERE id_course='$idCourse'";
        //echo $query;
        return $this->realizarConsulta($query);
    }

    function generateIdTopic($course, $x, $y) {
        $query = "SELECT coalesce(max(id_topic),0) + 1 FROM topic WHERE id_course='$course'";
        $last = $this->getOneData($this->realizarConsulta($query));
        $query = "INSERT INTO topic(id_topic,id_course,name,minimum_solved) VALUES('$last','$course','Nombre','0')";
        $this->realizarConsulta($query);
        $query = "INSERT INTO position VALUES('$last','$course','$x','$y')";
        $this->realizarConsulta($query);
        return $last;
    }

    function eliminarTopic($id, $curso) {
        $query = "DELETE FROM topic WHERE id_topic='$id' AND id_course='$curso'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM position WHERE id_topic='$id' AND id_course='$curso'";
        $this->realizarConsulta($query);
        $query = "DELETE FROM sucesor WHERE id_course='$curso' AND ( parent = '$id'  or child = '$id' ) ";
        $this->realizarConsulta($query);
        $query = "DELETE FROM problem  WHERE id_course='$curso' AND id_topic = '$id'";
        $this->realizarConsulta($query);
    }

    function editarTopic($idTopic, $idCourse, $name, $minimum) {
        $query = "UPDATE topic SET name='$name', minimum_solved='$minimum' WHERE id_topic='$idTopic' AND id_course='$idCourse'";
        $this->realizarConsulta($query);
    }

    function getTopicParents($curso, $topic) {
        $query = "SELECT * FROM sucesor WHERE child='$topic' AND id_course='$curso'";
        return $this->realizarConsulta($query);
    }

    //SUCCESSOR
    function getAllSucesor($current_course) {
        $query = "SELECT * FROM sucesor WHERE id_course='$current_course' AND id_course1='$current_course'";
        return $this->realizarConsulta($query);
    }

    function existeConexionTopic($child, $parent, $current_course) {
        $query = "SELECT count(*) FROM sucesor WHERE parent='$child' AND child='$parent' AND id_course='$current_course' AND id_course1='$current_course'";
        $n = $this->getOneData($this->realizarConsulta($query));
        return $n == 0 ? false : true;
    }

    function conectarTopic($parent, $child, $current_course) {
        $query = "INSERT INTO sucesor(parent,id_course,child,id_course1) VALUES('$parent','$current_course','$child','$current_course')";
        $this->realizarConsulta($query);
    }

    function eliminarSucesor($parent, $child, $current_course) {
        $query = "DELETE FROM sucesor WHERE parent='$parent' AND child='$child' AND id_course='$current_course' AND id_course1='$current_course'";
        //echo $query;
        $this->realizarConsulta($query);
    }

    //POSITION  
    function getInfoPosition($idTopic, $idCourse) {
        $query = "SELECT * FROM position WHERE id_topic='$idTopic' AND id_course='$idCourse'";
        return $this->realizarConsulta($query);
    }

    function editarPosition($idTopic, $idCourse, $x, $y) {
        $query = "UPDATE position SET x=$x,y=$y WHERE id_topic='$idTopic' AND id_course='$idCourse'";
        //  echo "$query";
        $this->realizarConsulta($query);
    }

    //PROBLEMA    

    function isSolved($user, $problem) {
        $query = "SELECT count(*) FROM  solved WHERE id_user='$user' AND id_problem='$problem'";
        //  echo $query;
        $result = $this->realizarConsulta($query);
        $data = $this->getOneData($result);
        // echo $data;
        return $data == 1 ? true : false;
    }

    function getInfoProblema($idProblema, $idTopic, $idCourse) {
        $query = "SELECT * FROM problem WHERE id_problem='$idProblema' AND id_topic='$idTopic' AND id_course='$idCourse'";
        return $this->realizarConsulta($query);
    }

    function getAllProblemas($idCourse, $idTopic) {
        $query = "SELECT problem.id_problem,problem.name,uva_problems.level,uva_problems.id_problem as n_problem FROM problem,uva_problems  WHERE n_problem = problem.id_problem  AND  id_course='$idCourse' AND id_topic='$idTopic' ORDER BY level desc";
        return $this->realizarConsulta($query);
    }

    function insertarProblema($idProblem, $idTopic, $idCourse, $name) {
        $query = "INSERT INTO problem(id_problem,id_topic,id_course,name) VALUES('$idProblem','$idTopic','$idCourse','$name')";
        $this->realizarConsulta($query);
    }

    function getProblemNumber($id) {
        $query = "SELECT n_problem FROM uva_problems WHERE id_problem=$id";
        $result = $this->realizarConsulta($query);
        return $this->getOneData($result);
    }

    function getInfoUVAProblem($problem) {
        $query = "SELECT title FROM uva_problems WHERE id_problem = '$problem'";
        return $this->realizarConsulta($query);
    }

    function getNumberOfProblemsSolved($user, $curso, $topic) {
        $query = "SELECT count(*) FROM problem WHERE id_course='$curso' AND id_topic='$topic' AND id_problem IN (SELECT id_problem FROM solved WHERE id_user='$user')";
        //echo $query;
        $result = $this->realizarConsulta($query);
        return $this->getOneData($result);
    }

    function getNumberOfProblems($curso, $topic) {
        $query = "SELECT count(*) FROM  problem WHERE id_course='$curso' AND id_topic='$topic'";
        $result = $this->realizarConsulta($query);
        return $this->getOneData($result);
    }

    function get_problems_to_solve($user, $course) {
        $query = "SELECT distinct(pr.id_problem) FROM topic t, participant p , problem pr WHERE p.id_user = '$user' AND t.id_course = '$course' AND t.id_course = p.id_course AND pr.id_course = t.id_course AND pr.id_topic = t.id_topic";
        return $this->realizarConsulta($query);
    }

    //CONTEO
    function getNumeroEstudiantes($idCourse) {
        $query = "SELECT count(*) FROM participant WHERE id_course='$idCourse'";
        return $this->getOneData($this->realizarConsulta($query));
    }

    function getNumeroProblemas($curso) {
        $query = "SELECT count(*) FROM topic t, problem p WHERE t.id_topic=p.id_topic AND t.id_course=p.id_course AND t.id_course='$curso'";
        return $this->getOneData($this->realizarConsulta($query));
    }

    function getNumeroTemas($curso) {
        $query = "SELECT count(*) FROM topic WHERE id_course='$curso'";
        return $this->getOneData($this->realizarConsulta($query));
    }

    function getProblemsSolvedCourse($idUser, $idCurso) {
        $query = "SELECT count(distinct(solved.id_problem))
FROM participant,solved,problem
WHERE participant.id_user=solved.id_user AND solved.id_problem=problem.id_problem AND participant.id_user='$idUser' AND participant.id_course='$idCurso'  AND problem.id_course='$idCurso'";
        //echo $query;
        $result = $this->realizarConsulta($query);
        return $this->getOneData($result);
    }

    function get_is_owner($user, $course) {
        $query = "SELECT count(*) FROM course WHERE id_course = '$course' AND id_user='$user'";
        return $this->getOneData($this->realizarConsulta($query));
    }

    //PARTICIPANTE
    function registrarParticipante($user, $course) {
        $query = "INSERT INTO participant(id_user,id_course) VALUES('$user','$course')";
        $this->realizarConsulta($query);
    }

    function getInfoParticipant($course, $user) {
        $query = "SELECT * FROM participant WHERE id_course='$course' AND id_user='$user'";
        return $this->realizarConsulta($query);
    }

    function eliminarParticipante($user, $course) {
        $query = "DELETE FROM participant WHERE id_user='$user' AND id_course='$course'";
        $this->realizarConsulta($query);
    }

    //funcion que retorna el numero de filas de una consulta
    function numFilas($result) {      
        return mysqli_num_rows($result);
    }

    function realizarConsulta($query) {
        if (!$this->result = mysqli_query($this->link, $query)) {
            throw new Exception("Se ha generado un error realizando la consulta: " . $query);
        }
        return $this->result;
    }

    function cerrarConexion() {
        mysqli_close($this->link);
    }

    function getProblems($idNode) {
        $query = "select divs,name from problema where divs = " . $idNode;
        return $this->realizarConsulta($query);
    }

    function getAllTemas() {
        $query = "select id,x,y from divs";
        return $this->realizarConsulta($query);
    }

    //FUNCIONES UTILES
    function getOneData($result) {
      
        $d = mysqli_fetch_array($result);
        return $d[0];
    }

    function getOneField($result, $attr) {      
        mysqli_data_seek($result, 0);
        $d = mysqli_fetch_array($result);
        //var_dump($d);
        //echo " $attr  = $d[$attr]";
        return $d[$attr];
    }

    function existeProblemaEnTema($tema, $problema) {
        $data = $this->realizarConsulta("select count(*) as total from divs, problema where divs.id=problema.divs and divs.id=$tema and problema.name='$problema'");
        $c = $this->getOneData($data);
        return $c == 0 ? false : true;
    }

    //funcion que retorna los recursos
    function getRecursos($curso) {
        $query = "SELECT r.url,u.username,r.description,r.id_resource,r.id_user FROM resource r,user u WHERE u.id_user=r.id_user AND r.id_course='$curso'";
        return $this->realizarConsulta($query);
    }

    //funcioon que crea un recurso
    function crearRecurso($curso, $data) {
        $query = "INSERT INTO resource(id_course,url,description,id_user) VALUES('$curso','{$data['url']}','{$data['description']}','{$data['id_user']}')";
        $this->realizarConsulta($query);
    }

    function getRankingCurso($curso) {
        $query = "SELECT user.id_user,username,count(distinct(problem.id_problem)) AS c,user.foto
FROM ((user NATURAL JOIN participant) LEFT JOIN solved ON (user.id_user=solved.id_user)) LEFT JOIN problem ON(problem.id_problem=solved.id_problem)
WHERE participant.id_course = '$curso' AND problem.id_course = '$curso'
GROUP BY username
ORDER BY c DESC
";
        //  echo $query;
        $result = $this->realizarConsulta($query);
        return $result;
    }

    function eliminarRecurso($data) {
        $query = "DELETE FROM resource  WHERE id_resource = '{$data['id_resource']}' AND id_user = '{$data['id_user']}'";
        $this->realizarConsulta($query);
    }

    //funciones utiles
    function isEmpty($data) {
        if ($data == null || $data == "") {
            return true;
        }
        return false;
    }

    //PERFIL

    function get_number_of_exercises_solved_by_topic($user, $course) {
        $query = "SELECT t.name as tema, count(s.id_problem) as solved
                 FROM topic t LEFT JOIN problem p ON (p.id_topic = t.id_topic AND p.id_course = t.id_course ) LEFT JOIN solved s ON (p.id_problem = s.id_problem)
                 WHERE  t.id_course='$course' AND s.id_user='$user'
                 GROUP BY t.id_topic
                 ORDER BY t.name";

        return $this->realizarConsulta($query);
    }

    //AVATAR

    function actualizar_avatar($data) {
        $query = "UPDATE user SET foto = '{$data['foto']}' WHERE id_user = '{$data['id_user']}'";
        $this->realizarConsulta($query);
    }

    function get_programador_semana($curso) {
        $time = time();
        $query = "SELECT u.username, count(*) as total, u.foto
FROM participant p, user u,solved s, problem pr
WHERE p.id_user = u.id_user AND  u.id_user = s.id_user AND pr.id_problem = s.id_problem AND pr.id_course = '$curso' AND p.id_course = '$curso' AND s.date > $time - 60 * 60 * 24 * 7
GROUP BY u.username
ORDER BY total DESC 
LIMIT 1";
        return mysqli_fetch_array($this->realizarConsulta($query));
    }

    function get_number_of_solved_in_days($username, $curso, $days) {
        $time = time();
        $query = "SELECT  count(*) as total
FROM participant p, user u,solved s, problem pr
WHERE p.id_user = u.id_user AND  u.id_user = s.id_user AND pr.id_problem = s.id_problem AND pr.id_course = '$curso' AND p.id_course = '$curso' AND s.date > $time - 60 * 60 * 24 * 7
AND u.username = '$username';
    ";
        $value = mysqli_fetch_array($this->realizarConsulta($query));
        return $value['0'];
    }

    function eliminar_problema_de_topic($data) {
        $query = "DELETE FROM problem WHERE id_problem = '{$data['id_problem']}' AND id_topic = '{$data['id_topic']}' AND id_course = '{$data['id_course']}'";
        $this->realizarConsulta($query);
    }

    function correo_exists($email) {
        $query = "SELECT count(*) FROM user WHERE email = '$email'";
        $result = $this->getOneData($this->realizarConsulta($query));
        return $result == 1 ? true : false;
    }

    function cambiar_password($data) {
        $query = "UPDATE user SET password = '{$data['password']}'  WHERE email = '{$data['email']}'";
        $this->realizarConsulta($query);
    }

}

?>
