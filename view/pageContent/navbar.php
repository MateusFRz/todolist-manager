<?php

if (!Validation::isUser($_SESSION['user'])):
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="?action=publicPage" style="font-size: 25px;"><span class="fas fa-clipboard-list"></span   > For you</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link fas fa-users  btn-lg" style="font-size: 30px;" href="?action=publicPage" title="Public"></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link fas fa-sign-in-alt" style="font-size: 30px;" href="?action=loginPage" title="Connection"></a>
            </li>
        </ul>
    </div>
</nav>

<?php else: ?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="?action=publicPage" style="font-size: 25px;"><span class="fas fa-clipboard-list"></span   > For you</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link fas fa-users" style="font-size: 30px;" href="?action=publicPage" title="Public"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link fas fa-user-lock" style="font-size: 30px;" href="?action=private" title="Private"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link fas fa-address-card" style="font-size: 30px;" href="?action=profile" title="Profile"></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="fas fa-sign-out-alt nav-link" style="font-size: 30px;" href="?action=logout" title="Disconnection"></a>
            </li>
        </ul>
    </div>
</nav>
<?php endif; ?>