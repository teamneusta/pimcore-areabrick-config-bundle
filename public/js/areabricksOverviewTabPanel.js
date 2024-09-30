pimcore.registerNS("neusta.areabrick_config.tab_panel");

neusta.areabrick_config.tab_panel = Class.create({

    initialize: function () {
        this.getTabPanel();
    },

    getTabPanel: function () {
        if (!this.panel) {
            this.panel = Ext.create('Ext.panel.Panel', {
                id: 'neusta-areabrick-overview-tab',
                title: t('neusta_pimcore_areabrick_config.areabricks.overview.title'),
                iconCls: 'pimcore_icon_areabrick',
                border: false,
                layout: 'fit',
                flex: 1,
                width: '100%',
                scrollable: true,
                closable: true,
            });

            const tabPanel = Ext.getCmp('pimcore_panel_tabs');
            tabPanel.add(this.panel);
            tabPanel.setActiveItem('neusta-areabrick-overview-tab');

            this.panel.on('destroy', function () {
                pimcore.globalmanager.remove('neusta-areabrick-overview-tab');
            }.bind(this));

            Ext.Ajax.request({
                url: Routing.generate('neusta_areabrick_config_areabrick_overview'),
                success: function(response) {
                    this.panel.add({
                        html: response.responseText,
                        autoScroll: true,
                    });
                }.bind(this),
            });
        }

        return this.panel;
    },

});
