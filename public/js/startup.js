pimcore.registerNS('neusta.areabrick_config.startup');

neusta.areabrick_config.startup = Class.create({

    initialize: function () {
        if (pimcore.events.preMenuBuild) {
            document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
        } else {
            // Todo: remove when we drop Pimcore 10 support
            document.addEventListener(pimcore.events.pimcoreReady, this.preMenuBuild.bind(this));
        }
    },

    preMenuBuild: function (e) {
        if (!pimcore.globalmanager.get('perspective').inToolbar('extras.areabricks')) {
            return;
        }

        if (!pimcore.globalmanager.get('user').isAllowed('neusta_areabrick_config.areabrick_overview')) {
            return;
        }

        const items = {
            text: t('neusta_areabrick_config.areabrick_overview'),
            iconCls: 'pimcore_nav_icon_objectbricks',
            priority: 31,
            itemId: 'pimcore_menu_tools_areabricks',
            handler: this.openAreabrickOverview,
        }

        if (e.type === pimcore.events.preMenuBuild) {
            e.detail.menu.extras.items.push(items);
        } else {
            // Todo: remove when we drop Pimcore 10 support
            pimcore.globalmanager.get('layout_toolbar').extrasMenu.insert(4, items);
        }
    },

    openAreabrickOverview: function() {
        try {
            pimcore.globalmanager.get('neusta_areabrick_config_areabrick_overview').activate();
        } catch (e) {
            pimcore.globalmanager.add('neusta_areabrick_config_areabrick_overview', new neusta.areabrick_config.areabrick_overview());
        }
    },

});

new neusta.areabrick_config.startup();
