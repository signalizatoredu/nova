export default Ember.View.extend({
    keyPress: function(e) {
        this.get("controller").send("updateKey", e.keyCode);
    }
});
