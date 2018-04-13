
var auth2 = {};
var helper = (function () {
    return {
        /**
         * Hides the sign in button and starts the post-authorization operations.
         *
         * @param {Object} authResult An Object which contains the access token and
         *   other authentication information.
         */
        onSignInCallback: function (authResult) {

            if (authResult.isSignedIn.get()) {
                helper.profile();
            } else {
                if (authResult['error'] || authResult.currentUser.get().getAuthResponse() == null) {
                    // There was an error, which means the user is not signed in.
                    // As an example, you can handle by writing to the console:
                    console.log('There was an error: ' + authResult['error']);
                }

            }
            console.log('authResult', authResult);
        },
        /**
         * Calls the OAuth2 endpoint to disconnect the app for the user.
         */
        disconnect: function () {
            // Revoke the access token.
            auth2.disconnect();
        },

        /**
         * Gets and renders the currently signed in user's profile data.
         */
        profile: function () {
            gapi.client.plus.people.get({
                'userId': 'me'
            }).then(function (res) {
                var profile = res.result;
                var event = new Event('change');
                inputNombre = document.querySelector('#inputNombre');
                inputNombre.value = profile.name.givenName || ""; 
                inputNombre.dispatchEvent(event);
                inputApellidos = document.querySelector('#inputApellidos');
                inputApellidos.value = profile.name.familyName || "";
                inputApellidos.dispatchEvent(event);
                inputOcupacion = document.querySelector('#inputOcupacion');
                inputOcupacion.value = profile.occupation || "";
                inputOcupacion.dispatchEvent(event);
                inputEmail = document.querySelector('#inputEmail');
                inputEmail.value = profile.emails[0].value || "";
                inputEmail.dispatchEvent(event);
                gender = (profile.gender == 'male') ? 'H' : ((profile.gender == 'female') ? 'M' : "");
                inputGenero = document.querySelector('#inputGenero');
                inputGenero.value = gender  || ""
                inputGenero.dispatchEvent(event);

                console.log(profile);
                console.log(profile.givenName);

            }, function (err) {
                var error = err.result;
                console.log(error);
            });
        }
    };
})();
/**
 * jQuery initialization
 */
$(document).ready(function () {
    $('#disconnect').click(helper.disconnect);
    $('#loaderror').hide();
});
/**
 * Handler for when the sign-in state changes.
 *
 * @param {boolean} isSignedIn The new signed in state.
 */
var updateSignIn = function () {
    console.log('update sign in state');
    if (auth2.isSignedIn.get()) {
        console.log('signed in');
        helper.onSignInCallback(gapi.auth2.getAuthInstance());
    } else {
        console.log('signed out');
        helper.onSignInCallback(gapi.auth2.getAuthInstance());
    }
}
/**
 * This method sets up the sign-in listener after the client library loads.
 */
function startApp() {
    gapi.load('auth2', function () {
        gapi.client.load('plus', 'v1').then(function () {
            gapi.auth2.init({
                fetch_basic_profile: false,
                scope: 'https://www.googleapis.com/auth/plus.login'
            }).then(
                function () {
                    console.log('init');
                    auth2 = gapi.auth2.getAuthInstance();
                    auth2.isSignedIn.listen(updateSignIn);
                    //auth2.then(updateSignIn);
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