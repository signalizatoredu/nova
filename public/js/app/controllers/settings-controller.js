App.SettingsController = Ember.ArrayController.extend({
    sortProperties: ["path"],
    sortAscending: true,
    selectedDirectoryType: null,

    directoriesCount: function() {
        return this.get("model.length");
    }.property("@each"),

    directoryTypes: function() {
        return this.store.find("directoryType");
    }.property(),

    actions: {
        createDirectory: function() {
            var path = this.get("path");
            var type = this.get("selectedDirectoryType");

            console.log(path, type);
            if (!path.trim()) { return; }

            var record = this.store.createRecord("directory", {
                path: path,
                directoryType: type
            });

            record.save();

            this.set("path", "");
        },
        delete: function(directory) {
            directory.deleteRecord();
            directory.save();
        }
    }
});
