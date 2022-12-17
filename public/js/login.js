// phần ẩn hiện from login 
let openLogin = $$("#open-login");
let bgLogin = $$("#bg-login");
let showLogin = $$("#show-from");
let closeLogin = $$("#close");
let formLogin = $$("#form-login");
let formSign = $$("#form-sign");

let userNameSig = $$('#account-1');
let firstPass = $$('#password-1');
let secondPass = $$('#password-2');
let form__inputs = $$l('.form__input');
let listEroor = $$l('.error.noti-error')
openLogin.onclick = () => {
    bgLogin.classList.remove('hidden');
    formSign.classList.add('hidden');
    offAll();
};

closeLogin.onclick = () => {
    bgLogin.classList.add('hidden');
    formSign.classList.remove('hidden');
};
// hết phần ẩn hiện from

// phần ẩn hiện from sign in 
let openSign = $$(".open-sign");
let closeSign = $$("#close-sign");

openSign.onclick = () => {
    bgLogin.classList.remove('hidden');
    formLogin.classList.add('hidden');
    offAll();

    hideoffall();
};

closeSign.onclick = () => {
    bgLogin.classList.add('hidden');
    formLogin.classList.remove('hidden');
};
// hết phần ẩn hiện sign in


// Hideof all
function hideoffall() {
    Array.from(form__inputs).forEach(input => {
        input.value = '';
        input.classList.remove('border-error-from');
    });
    Array.from(listEroor).forEach(element => {
        element.innerHTML = '';
    });
}
// chuyển form 
let changeFormSign = $$('#switch-sign');
let changeFormLog = $$('#switch-log');

changeFormSign.addEventListener('click', function () {
    hideForm(formSign, formLogin);
});

changeFormLog.addEventListener('click', function () {
    hideForm(formLogin, formSign);
});

function hideForm(formHide, formShow) {
    // ẩn form đăng nhập 
    formHide.classList.remove('hidden');

    // hiện form đăng ký
    formShow.classList.add('hidden');
    hideoffall();
}
// end chuyển form

// kiểm tra from
let formLog = $$("#form-login");
let formSig = $$("#form-sign");

formLog.addEventListener('submit', e => {  //login
    e.preventDefault();

    checkInputFormLog();
});

formSig.addEventListener('submit', e => {   //sign
    e.preventDefault();

    checkInputFormSig();
});

function checkInputFormLog() {   /// kiểm tra login
    let userName = $$('#account');
    let passUser = $$('#password');

    let accout = userName.value.trim();
    let pass = passUser.value.trim();

    if (accout === '') {
        setError(userName, "Trường username không được để trống !");
    } else {
        successForm(userName);
    }

    if (pass === '') {
        setError(passUser, "Trường password không được để trống !");
    } else {
        successForm(passUser);
    }
    if (accout && pass) {
        $.get('/formlogin', { action: 'login', username: accout, password: pass }, function (data) {

            if (data.messUsername) {
                setError(userName, data.messUsername);
            } else {
                successForm(userName);
                if (data.messPassword) {
                    setError(passUser, data.messPassword);
                } else {
                    successForm(passUser);
                }
            }
            if (data.status == 200) {
                creatLocal('username').setLocal(accout);
                toastMessage("Đăng Nhập Thành công");
                $$("#open-changepassword").classList.remove("hidden");

                openlogout();
                username = accout;

                fetch('/albums?action=getvalue')
                    .then(res => res.json())
                    .then(data => {
                        let recent = data.dbhistory.map(id => id.id_song)
                        let playlist = data.dbalbums.map(id => id.id_song)

                        localStorage.setItem('recent', JSON.stringify(recent));
                        localStorage.setItem('playlist', JSON.stringify(playlist));
                    })

                closeLogin.click();
                creatLocal("username").setLocal(accout);
            }
        })
    }
}

function checkInputFormSig() {       // kiểm tra sign in
    let accoutSig = userNameSig.value.trim();
    let firstValuePass = firstPass.value.trim();
    let secondValuePass = secondPass.value.trim();

    if (!accoutSig) {
        setError(userNameSig, "Trường username không được để trống !");
    } else {
        if (accoutSig.length < 5) {
            setError(userNameSig, "Trường username ít nhất 5 kí tự !");
        }
        else successForm(userNameSig);
    }



    if (firstValuePass && secondValuePass) {
        if (firstValuePass != secondValuePass && firstValuePass > 5) {
            setError(secondPass, "Passwork không trùng khớp !");
        } else {
            successForm(secondPass);
            if (accoutSig) {
                $.get('/form', { action: 'regester', username: accoutSig, password: firstValuePass }, function (data) {
                    if (data.status == 200) {
                        creatLocal('username').setLocal(accoutSig);
                        toastMessage("Đăng ký tài khoản thành công!");
                        username = accoutSig;
                        openlogout();
                        fetch('/albums?action=getvalue')
                            .then(res => res.json())
                            .then(data => {
                                let recent = data.dbhistory.map(id => id.id_song)
                                let playlist = data.dbalbums.map(id => id.id_song)

                                localStorage.setItem('recent', JSON.stringify(recent));
                                localStorage.setItem('playlist', JSON.stringify(playlist));
                            })


                        closeSign.click();
                        creatLocal("username").setLocal(accoutSig);
                    }
                    if (data.message) {
                        setError(userNameSig, data.message);

                    } else {
                        successForm(userNameSig);
                    }

                })
            }
        }
    } else {
        if (firstValuePass == '') {
            setError(firstPass, "Trường password không được để trống !");
        } else {
            if (firstValuePass.length < 5) {
                setError(firstPass, "Trường password ít nhất 5 ký tự !");
            }
            else successForm(firstPass);
        }

        if (secondValuePass == '') {
            setError(secondPass, "Trường confilm password không được để trống !");
        } else {
            successForm(secondPass);
        }
    }

}
userNameSig.addEventListener('blur', function (e) {
    let username = e.target.value;
    if (username && username.length<40) {
        if (username.length >= 5) {
            $.get('/form', { action: 'check', username: username }, function (data) {
                if (data.message) {
                    setError(userNameSig, data.message);
                } else {
                    successForm(userNameSig);
                }
            })
        }
    }
})

Array.from(form__inputs).forEach(input => {
    if (!input.value) {
        input.addEventListener('blur', function (e) {
            let nameInput = e.target.getAttribute('data-name');
            if (e.target.value) {
                if (e.target.value.length < 5) {
                    setError(input, `Trường ${nameInput} ít nhất 5 ký tự !`);
                }else if(e.target.value.length>40){
                    setError(input, `Trường ${nameInput} vượt quá 40 kí tự !`);
                }
                 else {
                    successForm(input);
                }
            } else setError(input, `Trường ${nameInput} không được để trống ! `);
        })
    }
})

function openlogout() {
    $$("#logout").classList.remove("hidden");

    fetch('/upload?action=getvalue')
        .then(res => res.json())
        .then(data => {
            if (data[0].avata) {
                $$('#avatauser').src = data[0].avata;
            } else {
                $$('#avatauser').src = `image/newavata.png`;
            }
        })
}
function setError(element, message) {
    element.parentElement.querySelector('.error').innerHTML = message;
    element.parentElement.querySelector('.error').classList.remove('hidden');
    element.classList.add('border-error-from');
}

function successForm(element) {
    element.parentElement.querySelector('.error').classList.add('hidden');
    element.parentElement.querySelector('.error').innerHTML = '';
    element.classList.remove('border-error-from');
}
const userchange = $$("#changepassUser");
const passchange = $$("#change_password");
const newpasschange = $$("#change_newpassword");
userchange.addEventListener('blur', function (e) {
    if (e.target.value) {
        $.get('/changepassword', { username: userchange.value.trim() }, function (data) {
            if (data == 1) {
                setError(userchange, 'Trường username không tồn tại !');
            } else successForm(userchange);
        })
    } else {
        setError(userchange, 'Trường username không được để trống');
    }

})
passchange.addEventListener('blur', function (e) {
    if (e.target.value) {
        $.get('/changepassword', { username: userchange.value.trim(), password: e.target.value.trim() }, function (data) {
            if (data == 2) {
                setError(passchange, 'Mật khẩu sai');
            } else successForm(passchange);

        })
    }
})

$$(".open-changepassword").onclick = function () {
    let userchangeValue = userchange.value.trim();
    let passchangevalue = passchange.value.trim();
    let newpasschangeValeu = newpasschange.value.trim();
    if (!userchangeValue) {
        setError(userchange, 'Trường username không được để trống !');
    } else successForm(userchange);
    if (!passchangevalue) {
        setError(passchange, 'Trường password không được để trống !');
    } else if (userchangeValue) {
        $.get('/changepassword', { username: userchangeValue, password: passchangevalue }, function (data) {
            if (data == 2) {
                setError(passchange, 'Mật khẩu sai');
            } else successForm(passchange);

        })
    };
    if (!newpasschangeValeu) {
        setError(newpasschange, 'Trường mật khẩu mới không được để trống !');
    } else if (passchangevalue && newpasschange && passchangevalue == newpasschangeValeu) {
        setError(newpasschange, 'Mật khẩu mới trùng với mật khẩu cũ !');
    }
    if (newpasschangeValeu  && passchangevalue != newpasschangeValeu && !$$("#error__pas").value && !$$("#error__newpass").value) {
        $.get('/changepassword', { action: "change", username: userchangeValue, password: passchangevalue, newpassword: newpasschangeValeu }, function (data) {
            passchange.value='';
            newpasschange.value='';
            toastMessage("Đổi mật khẩu thành công !");
            closeChangepassword();
        })

    };
}
$$("#open-changepassword").onclick=function(){
    $$(".bg-changepasswork").classList.remove('hidden');
}
function closeChangepassword(){
    $$(".bg-changepasswork").classList.add("hidden");
}