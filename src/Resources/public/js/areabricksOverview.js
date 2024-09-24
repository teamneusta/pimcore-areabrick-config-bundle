// /public/js/exportPage.js

pimcore.registerNS("pimcore.plugin.areabrick_overview");

pimcore.plugin.NeustaPimcoreAreabrickConfigBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.areabrick_overview";
    },
    initialize: function () {
        document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
    },

    preMenuBuild: function (e) {
        let menu = e.detail.menu;
        // get the user to check for permissions
        const user = pimcore.globalmanager.get('user');
        const perspectiveCfg = pimcore.globalmanager.get("perspective");

        if (menu.tools && user.isAllowed("areabricks") && perspectiveCfg.inToolbar("tools.areabricks")) {
            // simply push the new menu item in a existing menu
            menu.tools.items.push({
                text: t("areabricks"),
                iconCls: "pimcore_nav_icon_areabricks", // make sure your icon class exists
                priority: 3, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom menu items
                itemId: 'pimcore_menu_tools_areabricks', // specify your custom itemId here
                handler: this.showAllAreabricks, // define a handler what should happen if you click on the menu item
            });
        }
    },

    showAllAreabricks: function (menu, tree, record) {
        menu.add("-");
        menu.add(new Ext.menu.Item({
            text: 'Areabrick Overview',
            iconCls: "pimcore_icon_list",
            handler: function () {
                Routing.generate('areabrick_overview');
            }
        }));
    },

});

var NeustaPimcoreAreabrickConfigBundlePlugin = new pimcore.plugin.NeustaPimcoreAreabrickConfigBundle();
