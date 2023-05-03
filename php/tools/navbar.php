<link rel="stylesheet" href="style.css">
<div class="navbar">
    <a href="index.php"><div class="name">Libr</div></a>
    <div class="options">
        <a href="search.php"><svg class="aicon" height="8vh" width="8vh" viewBox="0 0 21 20" width="21" xmlns="http://www.w3.org/2000/svg"><path d="m207.45515 134.343 1.4847 1.414-4.4541 4.243-1.48575-1.414zm8.14485-.343c-3.4734 0-6.3-2.692-6.3-6 0-3.309 2.8266-6 6.3-6 3.47445 0 6.3 2.691 6.3 6 0 3.308-2.82555 6-6.3 6zm0-14c-4.6389 0-8.4 3.582-8.4 8s3.7611 8 8.4 8c4.63995 0 8.4-3.582 8.4-8s-3.76005-8-8.4-8z" transform="translate(-203 -120)"/></svg></a>
        <div class="hamburger-icon"><svg xmlns="http://www.w3.org/2000/svg" height="8vh" width="8vh"stroke="#EDF2F4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="hamburger-icon" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg></div>
    </div>
</div>
<div class="hamburger-menu">
    <ul class="menu">
        <li><a href="search.php">søk</a></li>
        <?php
        if (isset($_SESSION['loggedin'])) {
            echo '<li><a href="profile.php">profil</a></li>';
            echo '<li><a href="selfloan.php">lån en bok</a></li>';
            echo '<li><a href="auth/logout.php">log ut</a></li>';
        } else {
            echo '<li><a href="login.html">log in</a></li>';
        }
        ?>
    </ul>
</div>
<script>
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const menu = document.querySelector('.menu');

    hamburgerIcon.addEventListener('click', () => {
        menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
    });
</script>