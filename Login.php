<?php
session_start();

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $lang['login_title']; ?></title>
</head>
<body class="b1">
    <div class="loginBox" id="login">
        <form action="register.php" method="post">
            <div class="loginheader">
                <header><?php echo $lang['login_header']; ?></header>
            </div>
            <div class="inputBox">
                <input type="text" name="email" class="input-field" placeholder="<?php echo $lang['email']; ?>" autocomplete="off" required>
            </div>
            <div class="inputBox">
                <input type="password" name="password" class="input-field" placeholder="<?php echo $lang['password']; ?>" autocomplete="off" required>
            </div>
            <div class="forgetPass">
                <section>
                    <input type="checkbox" id="check">
                    <label for="check"><?php echo $lang['remember_me']; ?></label>
                </section>
                <section>
                    <a href="#"><?php echo $lang['forget_password']; ?></a>
                </section>
            </div>
            <div class="inputSubmit">
                <button class="submit-btn" id="submit" name="signIn"></button>
                <label for="submit"><?php echo $lang['sign_in']; ?></label>
            </div>
            <div class="sign-up-link">
                <p><?php echo $lang['no_account']; ?> &nbsp<a href="#" id="signUpbtn"><?php echo $lang['sign_up']; ?></a></p>
            </div>
        </form>
    </div>

    <div class="RegisterBox" id="register" style="display: none;">
        <form action="register.php" method="post">
            <div class="Registerheader">
                <header><?php echo $lang['register_header']; ?></header>
            </div>
            <div class="inputBox">
                <input type="text" name="fName" class="input-field" placeholder="<?php echo $lang['first_name']; ?>" autocomplete="off" required>
            </div>
            <div class="inputBox">
                <input type="text" name="lName" class="input-field" placeholder="<?php echo $lang['last_name']; ?>" autocomplete="off" required>
            </div>
            <div class="inputBox">
                <input type="text" name="email" class="input-field" placeholder="<?php echo $lang['email']; ?>" autocomplete="off" required>
            </div>
            <div class="inputBox">
                <input type="password" name="password" class="input-field" placeholder="<?php echo $lang['password']; ?>" autocomplete="off" required>
            </div>
            <div class="inputSubmit">
                <button class="submit-btn" id="submit" name="signUp"></button>
                <label for="submit"><?php echo $lang['sign_up']; ?></label>
            </div>
            <div class="sign-in-link">
                <p><?php echo $lang['already_account']; ?> &nbsp<a href="#" id="signInbtn"><?php echo $lang['sign_in']; ?></a></p>
            </div>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>