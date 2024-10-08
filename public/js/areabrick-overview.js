pimcore.registerNS('neusta.areabrick_config.areabrick_overview');

neusta.areabrick_config.areabrick_overview = Class.create({

    tabId: 'neusta-areabrick-overview-tab',
    panel: null,

    initialize: function () {
        this.getTabPanel();
    },

    getTabPanel: function () {
        if (!this.panel) {
            this.panel = Ext.create('Ext.panel.Panel', {
                id: this.tabId,
                title: t('neusta_areabrick_config.areabrick_overview'),
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
            tabPanel.setActiveItem(this.tabId);

            this.panel.on('destroy', function () {
                pimcore.globalmanager.remove(this.tabId);
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

            document.getElementById(this.tabId).addEventListener('click', event => {
                const el = event.target.closest('#neusta_areabrick_config a[data-page-id]');

                if (el) {
                    pimcore.helpers.openDocument(el.dataset.pageId, el.dataset.pageType);
                }
            });
        }

        return this.panel;
    },

});
