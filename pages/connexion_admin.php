
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/connexionAdmin.css">
    <title>Sign In Admin</title>
</head>

<body>

    <div class="login">
        <h1>Log In</h1>
        <form method="post" action="./../pages/admin_conn.php" name="form-login">

            <input type="text" name="admin_name" autocomplete="off" />
            <input type="password" name="mdp_user" />
            <input type="submit" name="valider" placeholder="Let me in"/>

        </form>
    </div>
</body>

</html>