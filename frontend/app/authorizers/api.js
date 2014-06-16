export default Ember.SimpleAuth.Authorizers.Base.extend({
    authorize: function(jqXHR, requestOptions) {
        requestOptions.xhrFields = {
            withCredentials: true
        };
    }
});
