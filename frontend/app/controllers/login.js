import Ember from 'ember';

export default Ember.Controller.extend(Ember.SimpleAuth.AuthenticationControllerMixin, {
    authenticatorFactory: 'authenticator:api',

    identification: null,
    password: null,
    remember: false,

    actions: {
        authenticate: function() {
            var data = this.getProperties('identification', 'password', 'remember');
            this.set('password', null);
            this._super(data);
        }
    }
});
