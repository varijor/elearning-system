window.onload = function () {
    const signUpButton = document.getElementById('signUp');
    const container = document.getElementById('container');
    const h = document.getElementById('hideme');

    console.log(window.location.pathname);
    if(window.location.pathname == '/index.php' || window.location.pathname == '/' || window.location.pathname == '/elearning%20system/'){

        const signInButton = document.getElementById('signIn');
        
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            h.style.display = 'block';
        });
    
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
            h.style.display = 'none';
        });
    }
};

function verifyReg() {
    if (verifyRegUsername()) {
        if (verifyName()) {
            if (verifySurname()) {
                /*if (verifyPhone()) {*/
                    if (verifyEmail()) {
                        if (verifyRegPassword()) {
                            document.forms["regform"].submit();
                        }
                    }
                /*}*/
            }
        }
    }
    return false;
}

function verifyRegTeacher() {
    if (verifyRegUsername()) {
        if (verifyName()) {
            if (verifySurname()) {
                if (verifyEmail()) {
                    if (verifyRegPassword()) {
                        document.forms["regucitel"].submit();
                    }
                }
            }
        }
    }
    return false;
}

function verifyRegUsername() {
    var username = document.getElementById("regusername").value;
    const userlabel = document.getElementById("hidden-username");
    username_length = username.length;
    if (username_length > 4 && username_length < 15) {
        userlabel.classList.add('hidden');
        return true;
    } else {
        userlabel.classList.remove('hidden');
        document.getElementById("regusername").focus();
    }
}

function verifyName() {
    var name = document.getElementById("name").value;
    const namelabel = document.getElementById("hidden-name");
    name_length = name.length;
    if (name_length > 2 && name_length < 15) {
        namelabel.classList.add('hidden');
        return true;
    } else {
        namelabel.classList.remove('hidden');
        document.getElementById("name").focus();
    }
}

function verifySurname() {
    var surname = document.getElementById("surname").value;
    const surnamelabel = document.getElementById("hidden-surname");
    surname_length = surname.length;
    if (surname_length > 2 && surname_length < 15) {
        surnamelabel.classList.add('hidden');
        return true;
    } else {
        surnamelabel.classList.remove('hidden');
        document.getElementById("surname").focus();
    }
}

function verifyEmail() {
    var email = document.getElementById("email").value;
    var mailformat =/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    const emaillabel = document.getElementById("hidden-email");
    if (email.match(mailformat)) {
        emaillabel.classList.add('hidden');
        return true;
    } else {
        emaillabel.classList.remove('hidden');
        document.getElementById("email").focus();
    }
}

function verifyPhone() {
    var phone = document.getElementById("phone").value;
    const phonelabel = document.getElementById("hidden-phone");
    var phoneformat = /^\d{10}$/;
    if ((phone.charAt(0) == "+")) {
        phone = phone.substring(1);
        if(phone.charAt(0)=="0"&&phone.charAt(1)=="9"){
            if (phone.match(phoneformat)) {
                phonelabel.classList.add('hidden');
                return true;
            } else {
                phonelabel.classList.remove('hidden');
                document.getElementById("phone").focus();
            }
        } else {
            phonelabel.classList.remove('hidden');
            document.getElementById("phone").focus();
        }
    } else {
        phonelabel.classList.remove('hidden');
        document.getElementById("phone").focus();
    }
}

function verifyRegPassword() {
    var password = document.getElementById("regpassword").value;
    var password_again = document.getElementById("znovaregpassword").value;
    const passlabel = document.getElementById("hidden-password");
    const passAgainlabel = document.getElementById("hidden-password-again");
    if (password.length > 5 && password.length < 15) {
        passlabel.classList.add('hidden');
        if (password == password_again){
            passAgainlabel.classList.add('hidden');
            return true;
        } else {
            passAgainlabel.classList.remove('hidden');
            document.getElementById("znovaregpassword").focus();
        }
    } else {
        passlabel.classList.remove('hidden');
        document.getElementById("regpassword").focus();
    }
}