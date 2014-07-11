import Authenticator from 'nova/authenticators/api';
import Authorizer from 'nova/authorizers/api';

window.ENV = window.ENV || {};
window.ENV['simple-auth'] = {
    authorizer: 'authorizer:api',
    crossOriginWhitelist: [NovaENV.API.HOST]
};

export default {
    name: 'authentication',
    initialize: function(container) {
        container.register('authenticator:api', Authenticator);
        container.register('authorizer:api', Authorizer);
    }
};
