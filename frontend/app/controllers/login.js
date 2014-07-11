import Ember from 'ember';
import AuthenticationControllerMixin from 'simple-auth/mixins/authentication-controller-mixin';

export default Ember.Controller.extend(AuthenticationControllerMixin, {
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
