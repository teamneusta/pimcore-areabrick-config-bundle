// /public/js/exportPage.js

pimcore.registerNS("neusta.areabrick_config");

neusta.areabrick_config = Class.create({

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
                text: t("neusta_pimcore_areabrick_config.menu.areabrick_overview"),
                iconCls: "pimcore_nav_icon_areabricks", // make sure your icon class exists
                priority: 31, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom menu items
                itemId: 'pimcore_menu_tools_areabricks', // specify your custom itemId here
                handler: function() {
                    alert('Bin hier');
                    this.showAllAreabricks();
                    alert('Bin da');
                }
            });
        }
    },

    showAllAreabricks: function () {
        new pimcore.element.Tab({
            id: 'areabrick-overview-tab',
            title: 'Areabrick Overview',
            url: '/admin/areabricks/list',
            iconCls: 'pimcore_icon_areabrick',
            closable: true
        }).open();

    },

});

var NeustaPimcoreAreabrickConfigBundlePlugin = new neusta.areabrick_config();
