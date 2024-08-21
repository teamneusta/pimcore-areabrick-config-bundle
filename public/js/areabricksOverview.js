// /public/js/exportPage.js

pimcore.registerNS("pimcore.plugin.areabrick_overview");

pimcore.plugin.NeustaPimcoreAreabrickConfigBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.areabrick_overview";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    prepareDocumentTreeContextMenu: function (menu, tree, record) {
        // Export all pages into zip file
        menu.add("-");
        menu.add(new Ext.menu.Item({
            text: 'Areabrick Overview',
            iconCls: "pimcore_icon_list",
            handler: function () {
                Routing.generate('areabrick_overview', {id: record.data.id});
            }
        }));
    },

});

var NeustaPimcoreAreabrickConfigBundlePlugin = new pimcore.plugin.NeustaPimcoreAreabrickConfigBundle();
