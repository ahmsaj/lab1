<?
$_token='';
if($_SERVER['REQUEST_METHOD']!='POST'){    
    $_token=genToken();
    $_SESSION['_token']=$_token;
}else{
    if(isset($_SESSION['_token'])){
        $_token=$_SESSION['_token'];
        if($_POST['_token']!=$_SESSION['_token']){
            die('you can\'t access');
        }
    }else{
        die('you can\'t access');
        header('Location:');
    }
}
if(!$_token){die('you can\'t access');}
define('_token',$_token);
//echo _token;
function genToken(){
    $n=64;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {$index = rand(0, strlen($characters) - 1);$randomString .= $characters[$index];}
   return $randomString;
}
?>
