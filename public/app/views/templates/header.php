<?php
$nav = '
<script src="' . BASE_URL . '/public/scripts/nav.js" type="module" defer></script>
<div class="modal" name="login-modal" id="login-modal">

    <div class="modal-content">

        <form class="bg-lightgrey form" id="login-form">
            <div class="inputdiv">
                <label class="form-label" for="email-input">E-mail:</label>
                <input class="form-input" type="email" id="email-input" name="email" required/>
            </div>
            <div class="inputdiv">
                <label class="form-label" for="pass-input">Password:</label>
                <input class="form-input" type="password" id="pass-input" name="password" required/>
            </div>
            <span id="login-warning" class="warning-sign"></span>
            <div class="inputdiv">
                <button type="submit" class="form-btn bg-lightgrey2 text-secondary">Submit</button>
            </div>
            <p class="form-sign">Do not have account yet? <a id="signup-btn" class="link-active">sign up</a></p>
        </form>
    </div>
</div>

<div class="modal" name="img-modal" id="img-modal">
    <div class="modal-content center">
        <img id="card-img-modal" alt="card image" class="in-modal-img center">
    </div>
</div>

<div class="modal" name="signup-modal" id="signup-modal">

    <div class="modal-content">

        <form class="bg-lightgrey form" id="signup-form">
            <div class="inputdiv">
                <label class="form-label" for="sign-email-input">E-mail:</label>
                <input class="form-input" type="email" id="sign-email-input" name="email" required/>
            </div>
                <div class="inputdiv">
                <label class="form-label" for="username">Username:</label>
                <input class="form-input" type="text" id="sign-username-input" name="username" required/>
            </div>
            <div class="inputdiv">
                <label class="form-label" for="pass-input">Password:</label>
                <input class="form-input" type="password" id="sign-pass-input" name="password" pattern=".{8,}" required/>
            </div>
            <div class="inputdiv">
                <label class="form-label" for="rep-pass-input">Repeat password:</label>
                <input class="form-input" type="password" id="sign-rep-pass-input" pattern=".{8,}" required/>
            </div>
            <span id="signup-warning" class="warning-sign"></span>
            <div class="inputdiv">
                <button type="submit" class="form-btn bg-lightgrey2 text-secondary">Submit</button>
            </div>
        </form>
    </div>
</div>
';

if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != null) {
    $nav = $nav . '
<nav class="page-navbar bg-lightgrey text-secondary">
    <div class="navbar-header">
        <a href="' . BASE_URL . '/" class="navbar-name">
            ZWA
        </a>
        <button class="burger-btn" id="burger-btn" aria-label="Toggle navigation">
            ☰
        </button>
    </div>
    
    <div class="navbar-links" id="navbar-links">
    <a href="' . BASE_URL . '/user" class="navbar-item">Profile</a>
    <a id="logout-btn" class="navbar-item">Logout</a>
    ';

    if (isset($_COOKIE["user_role"]) && $_COOKIE["user_role"] == "admin") {
        $nav = $nav . '
        <a id="admin-btn" href="' . BASE_URL . '/user/admin" class="navbar-item">Admin Dashboard</a>
    ';
    }
    $nav = $nav . '</div></nav>';
} else {
    $nav = $nav . '
<nav class="page-navbar bg-lightgrey text-secondary">

    <div class="navbar-header">
        <a href="' . BASE_URL . '/" class="navbar-name">
            ZWA
        </a>
        <button class="burger-btn" id="burger-btn" aria-label="Toggle navigation">
            ☰
        </button>
    </div>
    <div class="navbar-links" id="navbar-links">
        <a id="login-btn" class="navbar-item">Login</a>
    </div>
</nav>
';
}



echo $nav;