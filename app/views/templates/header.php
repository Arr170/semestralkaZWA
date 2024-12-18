<?php
echo ('
<script src="../public/scripts/nav.js" type="module" defer></script>
<div class="modal" name="login-modal" id="login-modal">

        <div class="modal-content">

            <form class="bg-lightgrey" id="login-form">
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
                <p>Do not have account yet? <a id="signup-btn" class="link-active">sign up</a></p>
            </form>
        </div>
    </div>

    <div class="modal" name="signup-modal" id="signup-modal">

        <div class="modal-content">

            <form class="bg-lightgrey" id="signup-form">
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

<nav class="page-navbar bg-lightgrey text-secondary">
    <a href="../" class="navbar-name">
        Test
    </a>
    <a href="../user" class="navbar-item">Profile</a>
    <a id="login-btn" class="navbar-item">Login</a>
</nav>

');
