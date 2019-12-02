<?php

if (!isset($_SESSION['login'])):
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="?action=publicPage">Checklist website</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="?action=publicPage">Public</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="?action=loginPage">Connexion</a>
            </li>
        </ul>
    </div>
</nav>

<?php else: ?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="?action=publicPage">Checklist website</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="?action=publicPage">Public</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=private">Private</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=profile">Profile</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="?action=logout">Disconnect</a>
            </li>
        </ul>
    </div>
</nav>
<?php endif; ?>