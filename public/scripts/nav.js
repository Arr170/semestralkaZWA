const loginModal = document.getElementById("login-modal")
const signupModal = document.getElementById("signup-modal")
const loginBtn = document.getElementById("login-btn")
const signupBtn = document.getElementById("signup-btn")
const loginForm = document.getElementById("login-form")
const logoutBtn = document.getElementById("logout-btn")
const signupForm = document.getElementById("signup-form")
const signupWarning = document.getElementById("signup-warning")
const loginWarning = document.getElementById("login-warning")


console.log(logoutBtn)

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
        console.log("passwords check failed")
        event.preventDefault()
        warning.style.display = "block"
        warning.innerHTML = "Passwords don't match!"
        return false
    }
    return true
}

async function handleLogin(event) {
    event.preventDefault()
    const form = new FormData()
    try {
        const formData = new FormData(loginForm)
        const response = await fetch("/user/login", {
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
        const response = await fetch("/user/signup", {
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
    console.log("logging out")
    try {
        const response = await fetch("/user/logout", {
            method: 'POST'
        })
        if (response.ok) {
            console.log(response)
            document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
            location.reload()
        }
    }
    catch (error) {
        console.log(error)
    }
}


signupBtn.addEventListener("click", () => showSignup())
loginForm.addEventListener("submit", (event) => handleLogin(event))

signupForm.addEventListener("submit", (event) => handleSignup(event))
if(logoutBtn){
    logoutBtn.addEventListener("click", () => handleLogout())
}
if (loginBtn) {
    loginBtn.addEventListener("click", () => showLogin())
}