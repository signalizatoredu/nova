import authenticator from "../authenticators/api";
import authorizer from "../authorizers/api";

export default {
    name: 'authentication',
    initialize: function(container, application) {
        container.register("authenticator:api", authenticator);
        container.register("authorizer:api", authorizer);

        Ember.SimpleAuth.setup(container, application, {
            authorizerFactory: "authorizer:api",
            crossOriginWhitelist: [ENV.API.HOST],
            storeFactory: "ember-simple-auth-session-store:local-storage"
        });
    }
};
