<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="../public/styles/style.css">
    <title>
        test
    </title>
</head>


<body class="bg-light">

    <div class="modal" name="login-modal" id="login-modal">

        <div class="modal-content">

            <form class="bg-lightgrey">
                <div class="inputdiv">
                    <label class="form-label" for="email-input">E-mail:</label>
                    <input class="form-input" t ype="email" id="email-input" name="email-input" required/>
                </div>
                <div class="inputdiv">
                    <label class="form-label" for="pass-input">Password:</label>
                    <input class="form-input" t ype="password" id="pass-input" name="pass-input" required/>
                </div>
                <div class="inputdiv">
                    <button type="submit" class="form-btn bg-lightgrey2 text-secondary">Submit</button>
                </div>
                <p>Don't have account yet? <a onclick="showSignup()" class="link-active">sign up</a></p>
            </form>
        </div>
    </div>

    <div class="modal" name="signup-modal" id="signup-modal">

        <div class="modal-content">

            <form class="bg-lightgrey" onsubmit="checkPassword(event)">
                <div class="inputdiv">
                    <label class="form-label" for="email-input">E-mail:</label>
                    <input class="form-input" type="email" id="sign-email-input" name="email-input" required/>
                </div>
                <div class="inputdiv">
                    <label class="form-label" for="pass-input">Password:</label>
                    <input class="form-input" type="password" id="sign-pass-input" name="pass-input" pattern=".{8,}" required/>
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
        <a href="./index.html" class="navbar-name">
            TEst
        </a>
        <a href="./profile.html" class="navbar-item">profile</a>
        <a onclick="showLogin()" class="navbar-item">login</a>
    </nav>

    <div class="page-body">
        <h1 class="center">Popular sets:</h1>
        <div class="grid-box center">
            <div class="card bg-warning">
                <span class="card-content">
                    <h1 class="card-icon">A</h1>
                    <p class="card-title">algebra</p>

                </span>
            </div>
            <div class="card bg-warning">
                <div class="card-content">
                    2
                </div>
            </div>
            <div class="card bg-warning">3</div>
            <div class="card bg-warning">4</div>
            <div class="card bg-warning">5</div>
            <div class="card bg-warning">6</div>
            <div class="card bg-warning">7</div>
            <div class="card bg-warning">8</div>
            <div class="card bg-warning">9</div>
            <div class="card bg-warning">10</div>
            <div class="card bg-warning">
                <div class="card-content">
                    <a href="/setCreator/index">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                    </a>
                    
                </div>

            </div>
        </div>
    </div>

</body>

</html>

<script>
    const loginModal = document.getElementById("login-modal")
    const signupModal = document.getElementById("signup-modal")


    window.onclick = function (event) {
        if (event.target == loginModal || event.target == signupModal) {
            loginModal.style.display = "none"
            signupModal.style.display = "none"
        }
    }

    function showLogin() {
        console.log("show")
        loginModal.style.display = "block"
        signupModal.style.display = "none"
    }

    function showSignup() {
        signupModal.style.display = "block"
        loginModal.style.display = "none"
    }

    function closeModals() {
        signupModal.style.display = "none"
        loginModal.style.display = "none"
    }

    function checkPassword(event){
        const pass = document.getElementById("sign-pass-input")
        const repass = document.getElementById("sign-rep-pass-input")
        const warning = document.getElementById("signup-warning")
        
        if(pass !== repass){
            console.log("passwords check failed")
            event.preventDefault()
            warning.style.display = "block"
            warning.innerHTML = "Passwords don't match!"
        }   

    }


</script>