$( document ).ready(function() {

    // add handlers
    $("input[name='login']").click(login);
    $("input[name='register']").click(register);

    $('#login-form-link').click(function(e) {
        
        $('#register-form').hide(500);
        $('#flash').hide();
        $('#login-form').show(500);

    });

    $('#register-form-link').click(function(e) {
        $('#login-form').hide(500);
        $('#flash').hide();
        $('#register-form').show(500);

    });

});


/**
 * after checking if the value are formatted correctly, send an
 * ajax request for checking if username / password is correct, and 
 * eventually, redirect the user to homepage.
 */
function login() {
    var username = $("input[name='username-log']").val();
    var password = $("input[name='password-log']").val();

    if(username == "" || password == "") 
    {
        showNotificationBar("Riempi tutti i campi");
        return;
    }
    var data = {op: 'login', username: username, password: password};
    $.post("/public/login/doLogin", data, function(response) {
        handleLogin(response);

    }, "json");
}
/**
 * after checking if the value are formatted correctly, send an
 * ajax request for trying to register a new usermame. 
 */
function register() {
    var username = $("input[name='username']").val();
    var name = $("input[name='name']").val();
    var surname = $("input[name='surname']").val();
    var password = $("input[name='password']").val();
    var email = $("input[name='email']").val();
    if(username == "" || name == "" || surname == "" || password == "" || !isEmail(email))
    {
        showNotificationBar("Formato sbagliato, ricontrolla i dati");
        return
    }
    var data = {op: 'register', username: username, name: name, surname: surname, password: password, email: email };
    $.post("login", data, function(response) {
        console.log(response);
        handleRegister(response);

    }, "json");

}

/**
 * Check if a value could be a correct email with a regex
 * @param {*} email 
 */
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
  


/**
 * if login returns a success code, redirect to home
 * @param {*} data response from ajax 
 */
function handleLogin(data) {
    if(data.code) {
        showNotificationBar(data['description']);
        window.location = 'home';
    }
    else {
        showNotificationBar(data['description']);
    }
}

/**
 * if register returns a success code, redirect to home
 * @param {*} data response from ajax 
 */
function handleRegister(data) {
    if(data.code) {
        showNotificationBar(data['description']);
        window.location = 'home';

    }
    else {
        showNotificationBar(data['description']);
    }

}