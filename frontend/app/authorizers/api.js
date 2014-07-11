import AuthorizerBase from 'simple-auth/authorizers/base';

export default AuthorizerBase.extend({
    authorize: function(jqXHR, requestOptions) {
        requestOptions.xhrFields = {
            withCredentials: true
        };
    }
});
