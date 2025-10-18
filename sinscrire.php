<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<title>naha</title>
</head>
    <body>
    <div>
        <form action="inscription.php" method="post">
            <label>Nom : <input type="text" name="n"  value="<?php if (isset($_GET['n'])) echo $_GET['n'];?>"></label><br>
            <label>Prénom : <input type="text" name="p"  value="<?php if (isset($_GET['p'])) echo $_GET['p'];?>"></label><br>
            <label>Adresse : <input type="text" name="adr"  value="<?php if (isset($_GET['adr'])) echo $_GET['adr'];?>"></label><br>
            <label>Téléphone : <input type="text" name="num"  value="<?php if (isset($_GET['num'])) echo $_GET['num'];?>"></label><br>
            <label>Email : <input type="email" name="mail"  value="<?php if (isset($_GET['mail'])) echo $_GET['mail'];?>"></label><br>
            <label>Mot de passe : <input type="password" name="pswrd1" required></label><br>
            <label>Confirmer mot de passe : <input type="password" name="pswrd2" required></label><br>
            <button type="submit" class="btn-submit">inscrire</button>
        </form>
    </div>

</body>
</html>

