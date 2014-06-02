export default DS.Model.extend({
    type: DS.attr("string"),

    directories: DS.hasMany("directory")
});
