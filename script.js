const signUpbtn = document.getElementById("signUpbtn")
const signInbtn = document.getElementById("signInbtn")
const registerPage = document.getElementById("register")
const loginPage = document.getElementById("login")


signUpbtn.addEventListener('click', function(){
    loginPage.style.display="none";
    registerPage.style.display="block";
})

signInbtn.addEventListener('click', function(){
    loginPage.style.display="block";
    registerPage.style.display="none";
})
