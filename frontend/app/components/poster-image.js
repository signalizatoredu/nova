import Ember from 'ember';

export default Ember.Component.extend({
    attributeBindings: ['style'],
    classNames: ['image'],
    height: 200,
    width: 133,
    poster: null,
    showLoader: true,

    imageUrl: function() {
        var width = this.get('width');
        var height = this.get('height');
        var poster = this.get('poster');

        return NovaENV.API.HOST + '/movies/' + poster + '/poster/' + width + '/' + height;
    }.property(),

    loadError: function() {
        this.set('showLoader', false);
    },

    loadSuccess: function() {
        this.set('showLoader', false);
    },

    style: function() {
        var width = this.get('width');
        var height = this.get('height');

        return 'height:' + height + 'px;width:' + width + 'px;';
    }.property('height'),

    didInsertElement: function() {
        var img = this.$('img:first');

        if (!img.complete) {
            img.on('error', function() {
                this.trigger('loadError');
            }.bind(this));

            img.on('load', function() {
                this.trigger('loadSuccess');
            }.bind(this));
        } else {
            this.trigger('loadSuccess');
        }
    },

    willDestroyElement: function() {
        // Remove custom event listeners
        this.$('img:first').off('error load');
    }
});
