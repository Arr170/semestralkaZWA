const loginModal = document.getElementById("login-modal")
const signupModal = document.getElementById("signup-modal")
const loginBtn = document.getElementById("login-btn")
const signupBtn = document.getElementById("signup-btn")
const loginForm = document.getElementById("login-form")
const logoutBtn = document.getElementById("logout-btn")
const signupForm = document.getElementById("signup-form")
const signupWarning = document.getElementById("signup-warning")
const loginWarning = document.getElementById("login-warning")


let BASE_URL = ""
const url = window.location.href
if (url.includes("~kupriars")) {
    BASE_URL = "/~kupriars"
}


window.onclick = function (event) {
    if (event.target == loginModal || event.target == signupModal) {
        loginModal.style.display = "none"
        signupModal.style.display = "none"
    }
}

function showLogin() {
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

function checkPasswords(event) {
    const pass = document.getElementById("sign-pass-input")
    const repass = document.getElementById("sign-rep-pass-input")

    if (pass !== repass) {
        event.preventDefault()
        warning.style.display = "block"
        warning.innerHTML = "Passwords don't match!"
        return false
    }
    if(!validatePassword(pass)){
        event.preventDefault()
        warning.style.display = "block"
        warning.innerHTML = "Password must be at least 8 characters long and include both numbers and letters!"
        return false
    }
    return true
}

function validatePassword(password) {
    const minLength = 8;
    const containsNumber = /\d/;
    const containsLetter = /[a-zA-Z]/;

    return password.length >= minLength && containsNumber.test(password) && containsLetter.test(password);
}

async function handleLogin(event) {
    event.preventDefault()
    const form = new FormData()
    try {
        const formData = new FormData(loginForm)
        const response = await fetch(BASE_URL + "/user/login", {
            method: 'POST',
            body: formData,
        })
        const result = await response.json()
        if (response.ok) {
            closeModals()
            location.reload()
        } else {
            loginWarning.style.display = "block"
            loginWarning.innerHTML = result.message;
        }


    } catch (error) {
        console.error(error)
    }

}

async function handleSignup(event) {
    event.preventDefault()
    try {
        const formData = new FormData(signupForm)
        const response = await fetch(BASE_URL + "/user/signup", {
            method: 'POST',
            body: formData,
        })
        const result = await response.json()
        if (response.ok) {
            closeModals()
            location.reload()
        } else {
            signupWarning.style.display = "block"
            signupWarning.innerHTML = result.message;
        }


    } catch (error) {
        console.error(error)
    }

}

async function handleLogout() {
    try {
        const response = await fetch(BASE_URL + "/user/logout")
        if (response.ok) {
            //is not needed, but to be on the safe side delete cookies in all possible ways
            document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
            document.cookie = "user_role=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
            location.href = BASE_URL + '/'
        }
    }
    catch (error) {
        console.log(error)
    }
}


signupBtn.addEventListener("click", () => showSignup())
loginForm.addEventListener("submit", (event) => handleLogin(event))

signupForm.addEventListener("submit", (event) => handleSignup(event))
if (logoutBtn) {
    logoutBtn.addEventListener("click", () => handleLogout())
}
if (loginBtn) {
    loginBtn.addEventListener("click", () => showLogin())
}

document.addEventListener("DOMContentLoaded", () => {
    const burgerBtn = document.getElementById("burger-btn");
    const navbarLinks = document.getElementById("navbar-links");

    burgerBtn.addEventListener("click", () => {
        navbarLinks.classList.toggle("active");
    });
});