export default Ember.SimpleAuth.Authenticators.Base.extend({
    serverTokenEndpoint: ENV.API.HOST + "/authentication",

    restore: function() {
        var that = this;

        return new Ember.RSVP.Promise(function(resolve, reject) {
            var config = {
                url: ENV.API.HOST + "/verify",
                type: "POST"
            };

            that.makeRequest(config).then(
                function() {
                    Ember.run(function() {
                        resolve();
                    });
                },
                function() {
                    Ember.run(function() {
                        reject(new Error());
                    });
                }
            );
        });
    },

    authenticate: function(credentials) {
        var that = this;

        return new Ember.RSVP.Promise(function(resolve, reject) {
            var config = {
                data: {
                    username: credentials.identification,
                    password: credentials.password,
                    remember: credentials.remember
                }
            };

            that.makeRequest(config).then(
                function(response) {
                    Ember.run(function() {
                        resolve(response.auth);
                    });
                },
                function(xhr) {
                    Ember.run(function() {
                        reject(xhr.responseJSON || xhr.responseText);
                    });
                }
            );
        });
    },

    invalidate: function() {
        var that = this;

        return new Ember.RSVP.Promise(function(resolve) {
            that.makeRequest({
                type: "DELETE",
            }).then(function() {
                resolve();
            });
        });
    },

    makeRequest: function(config) {
        if (!Ember.SimpleAuth.Utils.isSecureUrl(this.serverTokenEndpoint)) {
            Ember.Logger.warn("Credentials are transmitted via an insecure connection - use HTTPS to keep them secure.");
        }

        return Ember.$.ajax({
            data: JSON.stringify(config.data ? config.data : {}),
            dataType: "json",
            type: config.type ? config.type : "POST",
            url: config.url ? config.url : this.serverTokenEndpoint,
            beforeSend: function(xhr, settings) {
                xhr.setRequestHeader("Accept", settings.accepts.json);
            }
        });
    }
});
