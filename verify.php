    <?php
    
session_start();
require_once 'connexion.php';
$cost=['cost' => 12];
$password=password_hash($password, PASSWORD_BCRYPT, $cost);

if(isset($_POST['email']) && isset($_POST['password']))
{
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);


    $check = $db->prepare('SELECT email, password FROM utilisateur WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    if($row == 1)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            
            if(password_verify($password, $data['password']))
            {
                $cost=['cost' => 12];
                $password=password_hash($password, PASSWORD_BCRYPT, $cost);
                $_SESSION['user'] = $data['email'];
                header('Location:http://localhost/simply-count/create.php');
            }else{ header('Location: index.php?login_err=password'); die(); }
        }else{ header('Location: index.php?login_err=email'); die(); }
    }else{ header('Location: index.php?login_err=already'); die(); }
}
?>




