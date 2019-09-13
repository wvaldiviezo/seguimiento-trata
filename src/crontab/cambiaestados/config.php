<?php
//RECUPERA VARIABLES DE INICIO DE SESION
$nom_aux = '';
$perf_aux = 0;
$usuid_aux= 0;

    $nom_aux = 'admin';
    $perf_aux = 40;
    $usuid_aux= 1;

//DEFINE DIRECTORIOS BASE PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('DIR_ABS',dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/");
define('DIR_ABS_ROOT',dirname(dirname(__FILE__))."/seguimiento-tratav2/");
define('DIR_ABS_SRC',DIR_ABS."src/");
define('DIR_ABS_SEGUIMIENTO_DESPACHO',DIR_ABS."/seguimiento_despacho/");
//DEFINE DIRECTORIOS RELATIVOS NO PHP

//define('DIR_REL',"/seguimiento_prueba/");
define('DIR_REL',"/seguimiento-trata/");
define('DIR_REL_ROOT',"/");
define('DIR_REL_CSS',DIR_REL."css/");
define('DIR_REL_IMG',DIR_REL."img/");
define('DIR_REL_JS',DIR_REL."js/");
define('DIR_REL_SRC',DIR_REL."src/");
define('DIR_REL_SEGUIMIENTO_DESPACHO',DIR_REL."seguimiento_despacho/");
//CONFIGURACION CONEXIONES
define('BASE_DATOS_LOGIN', "seguimientotrata");
define('BASE_DATOS_SISTEMA', "seguimientotrata");
define('BASE_DATOS_SISTEMA_MYSQL', "intranetsnap");
define('BASE_DATOS_SISTEMA_MYSQL_ASISTENCIA', "fulltime");
//define('BASE_DATOS_SISTEMA_MYSQL', "fulltime");

define('USUARIO', "postgres");
//a la clave le falta un $ y eso se pone directo en la cadena de conexion prefijo $ invalido $nap2015
$password='$3gu1m13nt0Tr4t4';
$password='M1c$B@S3';
define('CLAVE', $password);
//define('CLAVE', "M1c$B@S3");
define('SERVIDOR_BASE', "localhost");
//define('PUERTO', "5432");
define('PUERTO', "5433");

//cifradp
define('CLAVE_CRYPT', "[]A_n´¿!(!Ç@<=*Ç¨!!2o>k$}6{"); 
define('IV_CRYPT', ")(_!º$\-MQÇ*@<!=?¨!¿o<p.|¨[");

define('USUARIO_MYSQL', "root");
//a la clave le falta un $ y eso se pone directo en la cadena de conexion prefijo $ invalido $nap2015
define('CLAVE_MYSQL', "nap2015"); 
define('SERVIDOR_BASE_MYSQL', "localhost");
define('PUERTO_MYSQL', "3306");


define('USUARIO_MYSQL_ASISTENCIA', "root");
//a la clave le falta un $ y eso se pone directo en la cadena de conexion prefijo $ invalido $nap2015
define('CLAVE_MYSQL_ASISTENCIA', "root");
define('SERVIDOR_BASE_MYSQL_ASISTENCIA', "172.16.1.66");
define('PUERTO_MYSQL_ASISTENCIA', "3306");


//CALL CONEXIONES
//define('CONEXION_LOGIN', DIR_ABS_SRC."conexion/conexion_login.php");
define('CONEXION_CRON', DIR_ABS_SRC."conexion/conexion_crontab.php");
//define('CONEXION_SISTEMA_MYSQL', DIR_ABS_SRC."conexion/conexion_sistema_mysql.php");
//define('CONEXION_SISTEMA_MYSQL_ASISTENCIA', DIR_ABS_SRC."conexion/conexion_sistema_mysql_asistencia.php");
//FUNCIONES
define('FUN_IP',DIR_ABS_SRC."funciones/ip.php");
define('FUN_CLEAN',DIR_ABS_SRC."funciones/sanear.php");
define('FUN_SEGURIDAD',DIR_ABS_SRC."funciones/encriptacion_seguridad.php");
define('FUN_VALIDAR_SESION',DIR_ABS_SRC."funciones/validar_sesion.php");
define('FUN_VERIFICAR_VACIOS',DIR_ABS_SRC."funciones/verificar_vacio.php");
define('FUN_VERIFICAR_CHECK',DIR_ABS_SRC."funciones/verificar_check.php");
define('FUN_COMPARAR_FECHAS',DIR_ABS_SRC."funciones/comparar_fechas.php");
define('FUN_FORMATEAR_FECHA',DIR_ABS_SRC."funciones/formatear_fecha.php");
define('FUN_NUMEROS_A_LETRAS',DIR_ABS_SRC."funciones/numeros_a_letras.php");
define('FUN_ULTIMO_DIA_MES',DIR_ABS_SRC."funciones/ultimo_dia_mes.php");
define('FUN_QUITAR_TILDES',DIR_ABS_SRC."funciones/quitarTildes.php");
define('FUN_RELLENAR_ARRAY',DIR_ABS_SRC."funciones/rellenar_array.php");

//LIBRERIAS
define('LIB_XAJAX',DIR_ABS_SRC."lib/xajax/xajax.inc.php");
define('LIB_MAIL',DIR_ABS_SRC."lib/mail/funciones.php");
define('LIB_MAIL_ROLES',DIR_ABS_SRC."lib/mail/funciones_envio_roles.php");
define('LIB_MAIL_DEMO',DIR_ABS_SRC."lib/PHPMailer-master/PHPMailerAutoload.php");
define('LIB_TCPDF',DIR_ABS_SRC.'lib/tcpdf/examples/tcpdf_include.php');
define('LIB_TREE_DIR',DIR_ABS_SRC."lib/jquery.dynatree-1.2.5-all/");
define('LIB_PHPWORD',DIR_ABS_SRC."lib/PHPWord_0.6.2_Beta/");

//DEFINE DIRECTORIOS ABSOLUTOS PHP
define('DIR_PHP_JGRID',DIR_ABS_SRC."lib/jqSuitePHP_4_6_0/");
//DEFINE DIRECTORIOS RELATIVOS NO PHP
define('DIR_NOPHP_JGRID',DIR_REL_SRC."lib/jqSuitePHP_4_6_0/");
define('DIR_NOPHP_TREE',DIR_REL_SRC."lib/jquery.dynatree-1.2.5-all/");
define('DIR_NOPHP_TREE_FANCY',DIR_REL_SRC."lib/fancytree-master/");
define('DIR_NOPHP_ESTADISTICAS',DIR_REL_SRC."lib/Highcharts-4.0.4/");
define('DIR_NOPHP_CKEDITOR',DIR_REL_SRC."lib/ckeditor/");
define('DIR_NOPHP_SELECT2',DIR_REL_SRC."lib/select2-3.5.2/");
define('DIR_NOPHP_SISYPHUS',DIR_REL_SRC."lib/sisyphus-1.1/");
define('DIR_NOPHP_TOOLTIP',DIR_REL_SRC."lib/poshytip-1.2/");
define('DIR_NOPHP_GANTT',DIR_REL_SRC."lib/dhtmlxGantt_v3.1.0_gpl/");
define('DIR_NOPHP_LAYOUT',DIR_REL_SRC."lib/layout.w2ui/");
define('DIR_NOPHP_LAYOUT1',DIR_REL_SRC."lib/layout.jquery-1.2.0/");
define('DIR_NOPHP_EASYUI',DIR_REL_SRC."lib/jquery-easyui-1.4.4/");
define('DIR_NOPHP_UPLOAD',DIR_REL_SRC."lib/plupload-2.1.2/");
define('DIR_NOPHP_TIMEPICKER',DIR_REL_SRC."lib/jquery-ui-timepicker-0.3.3/");
define('DIR_NOPHP_AUTOSIZE_TEXTAREA',DIR_REL_SRC."lib/autosize-master-1.18/");
define('DIR_NOPHP_DATETIMEPICKER',DIR_REL_SRC."lib/datetimepicker-master_2.3.7/");
define('DIR_NOPHP_AJAXLOADING',DIR_REL_SRC."lib/ajax-loading-1.0.0/");

define ('CLA_MAIL',DIR_ABS."/seguimiento_despacho/src/crontab/cambiaestados/mail.class.php");
//define ('CLA_HTML',DIR_ABS."/class/elementosHTML.class.php");
//define ('CLA_ID',DIR_ABS."/class/id.class.php");

//para login con la intranet
define( '_JEXEC', 1 );
define('JPATH_BASE', DIR_ABS_ROOT );

define('ERROR',DIR_ABS."/index.html");
//variables de sesion

//CONFIG DE CALL CLASES
$GLOBALS["sis_login"]=1;
$GLOBALS["sis_lotaip"]=2;
$GLOBALS["sis_roles"]=14;
$GLOBALS["sis_permisos"]=8;



require_once CONEXION_CRON;
$_consulta_sistema=new conexion_sistema();
//require_once CONEXION_LOGIN;
//$_consulta_login=new conexion();





require_once FUN_FORMATEAR_FECHA;
require_once FUN_IP;
require_once CLA_MAIL;

/*require_once CLA_HTML;
$HTML= new _HTML();*/

//constantes
//en estas variables debe cargarse las variables del login para los permisos
if(!isset($GLOBALS["id_portal"])){
		/*require_once CLA_LOGIN1;
		$login=new c_login();
		$login->_sistema=8;
		$id=$login->f_devuelvePersona();
		$perfil=$login->f_devuelvePerfil();
		$nombres=$login->f_devuelveNombres();*/
}


$GLOBALS["id_portal"]=2;
$id=$usuid_aux;
//$id=2 ;
$nombres=$nom_aux ;
if($perf_aux==40){
    $perfil=array(40);
}elseif($perf_aux==41){
    $perfil=array(41);
}elseif($perf_aux==42){
    $perfil=array(42);
}elseif($perf_aux==43){
    $perfil=array(43);
}elseif($perf_aux==44){
    $perfil=array(44);
}




/*$GLOBALS["id_portal"]=2;
$id=2;
$perfil=array(40);
$nombres="Jonatan Díaz";
*/

?>