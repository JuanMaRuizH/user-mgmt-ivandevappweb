
var discoveryDocs = ["https://people.googleapis.com/$discovery/rest?version=v1"];
var scopes = 'profile';
var clientId = '308612886182-5gbmi9iqmsjnlaqlsrftk96d8nhmnj52.apps.googleusercontent.com';
var apiKey = 'AIzaSyBrr-VtPrN852IJbkdX8QkkXBEmsZBuJms';

var fillButton = document.getElementById('rellenaperfil');

var helper = (function () {
    return {
        onSignInCallback: function (authResult) {
            if (authResult.isSignedIn.get()) {
                helper.profile();
                authResult.disconnect();
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


function loadClient() {
    // Load the API client and auth2 library
    gapi.load('client:auth2', initClient);
}

function initClient() {
    gapi.client.init({
        apiKey: apiKey,
        discoveryDocs: discoveryDocs,
        clientId: clientId,
        scope: scopes
    }).then(function () {
        fillButton.onclick = signIn;
    }, function (error) {
        console.log(error);
    });
}

function signIn() {
    console.log('I am passing signIn');
    var auth2 = gapi.auth2.getAuthInstance();
    // Sign the user in, and then retrieve their ID.
    auth2.signIn().then(function () {
        //auth2.then(updateSignIn);
        auth2.then(helper.onSignInCallback(gapi.auth2.getAuthInstance()));
        console.log(auth2.currentUser.get().getId());
    });
}