const loginModal = document.getElementById("login-modal")
const signupModal = document.getElementById("signup-modal")
const loginBtn = document.getElementById("login-btn")
const signupBtn = document.getElementById("signup-btn")


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

function checkPassword(event) {
    const pass = document.getElementById("sign-pass-input")
    const repass = document.getElementById("sign-rep-pass-input")
    const warning = document.getElementById("signup-warning")

    if (pass !== repass) {
        console.log("passwords check failed")
        event.preventDefault()
        warning.style.display = "block"
        warning.innerHTML = "Passwords don't match!"
    }

}

loginBtn.addEventListener("click", () => { showLogin() })
signupBtn.addEventListener("click", () => { showSignup() })
