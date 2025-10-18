<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<title>naha</title>
</head>
<body>

    <form action="connex.php" method="post">
        <label>Email : <input type="email" name="mail" value="<?php if(isset($_GET['mail'])) echo $_GET['mail'];?>"></label><br>
        <label>Mot de passe : <input type="password" name="pswrd" required></label><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>