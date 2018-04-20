
var helper = (function () {
    return {
        onSignInCallback: function (authResult) {
            if (authResult.isSignedIn.get()) {
                helper.profile();
            } else {
                if (authResult['error'] || authResult.currentUser.get().getAuthResponse() == null) {
                    console.log('There was an error: ' + authResult['error']);
                }
            }
        },

        disconnect: function () {
            auth2.disconnect();
        },

        profile: function () {
            gapi.client.people.people.get({
                'resourceName': 'people/me',
                'personFields': 'names,occupations,emailAddresses,genders'
            }).
                then(function (res) {
                    var profile = res.result;
                    var event = new Event('change');
                    inputNombre = document.querySelector('#inputNombre');
                    inputNombre.value = profile.names[0].givenName || "";
                    inputNombre.dispatchEvent(event);
                    inputApellidos = document.querySelector('#inputApellidos');
                    inputApellidos.value = profile.names[0].familyName || "";
                    inputApellidos.dispatchEvent(event);
                    inputOcupacion = document.querySelector('#inputOcupacion');
                    inputOcupacion.value = profile.occupations[0].value || "";
                    inputOcupacion.dispatchEvent(event);
                    inputEmail = document.querySelector('#inputEmail');
                    inputEmail.value = profile.emailAddresses[0].value || "";
                    inputEmail.dispatchEvent(event);
                    gender = (profile.genders[0].value == 'male') ? 'H' : ((profile.genders[0].value == 'female') ? 'M' : "");
                    inputGenero = document.querySelector('#inputGenero');
                    inputGenero.value = gender || ""
                    inputGenero.dispatchEvent(event);

                    console.log(profile);

                }, function (err) {
                    var error = err.result;
                    console.log(error);
                });
        }
    };
})();


var updateSignIn = function (signed) {
    console.log('update sign in state');
    if (signed) {
        helper.onSignInCallback(gapi.auth2.getAuthInstance());

    }
   // if (auth2.isSignedIn.get()) {
     //   console.log('signed in');
       // helper.onSignInCallback(gapi.auth2.getAuthInstance());
    // } 
    else {
        console.log('signed out');
       // helper.onSignInCallback(gapi.auth2.getAuthInstance());
    }
}

function startApp() {
    gapi.load('auth2', function () {
        //gapi.client.load('plus', 'v1').then(function () {
        gapi.client.load('https://people.googleapis.com/$discovery/rest?version=v1').then(function () {
            gapi.auth2.init({
                fetch_basic_profile: false,
                scope: 'https://www.googleapis.com/auth/plus.login'
            }).then(
                function () {
                    console.log('init');
                    auth2 = gapi.auth2.getAuthInstance();
                    auth2.isSignedIn.listen(updateSignIn);
                    auth2.then(updateSignIn);
                });
        });
    });
}

function signIn() {
    console.log('I am passing signIn');
    var auth2 = gapi.auth2.getAuthInstance();
    // Sign the user in, and then retrieve their ID.
    auth2.signIn().then(function () {
        auth2.then(updateSignIn);
        console.log(auth2.currentUser.get().getId());
    });
}