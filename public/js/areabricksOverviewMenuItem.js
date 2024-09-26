// /public/js/exportPage.js

pimcore.registerNS("neusta.areabrick_config.menu_item");

neusta.areabrick_config.menu_item = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
    },

    preMenuBuild: function (e) {
        let menu = e.detail.menu;
        // get the user to check for permissions
        const user = pimcore.globalmanager.get('user');
        const perspectiveCfg = pimcore.globalmanager.get("perspective");

        if (user.isAllowed("areabricks") && perspectiveCfg.inToolbar("tools.areabricks")) {
            // simply push the new menu item in a existing menu
            menu.extras.items.push({
                text: t("neusta_pimcore_areabrick_config.areabricks.overview.title"),
                iconCls: "pimcore_nav_icon_areabricks", // make sure your icon class exists
                priority: 31, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom menu items
                itemId: 'pimcore_menu_tools_areabricks', // specify your custom itemId here
                handler: this.openAreabrickOverview
            });
        }
    },

    openAreabrickOverview: function(e) {
        try {
            pimcore.globalmanager.get("neusta_areabrick_config").activate();
        } catch (e) {
            pimcore.globalmanager.add("neusta_areabrick_config", new neusta.areabrick_config.tab_panel());
        }
    },

});

var NeustaPimcoreAreabrickConfigBundlePlugin = new neusta.areabrick_config.menu_item();
