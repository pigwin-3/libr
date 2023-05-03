<?php
echo $_GET['id'];
?>
<form action="../auth/changepassword.php" method="post">
    <input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
    <input type="password" name="password" id="password" placeholder="skriv in nytt passord">
    <input type="password" name="password2" id="password2" placeholder="gjenta nye passord">
    <input type="submit" value="submit">
</form>