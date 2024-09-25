// /public/js/exportPage.js

pimcore.registerNS("neusta.areabrick_config.tab_panel");

neusta.areabrick_config.tab_panel = Class.create({

    initialize: function () {
        this.getTabPanel();
    },

    getTabPanel: function () {

        if (!this.panel) {

            var me = this;

            this.panel = Ext.create('Ext.panel.Panel', {
                id: 'neusta-areabrick-overview-tab',
                title: t('neusta_pimcore_areabrick_config.menu.areabrick_overview'),
                iconCls: 'pimcore_icon_areabrick',
                border: false,
                layout: 'fit',
                closable: true
            });


            var tabPanel = Ext.getCmp('pimcore_panel_tabs');
            tabPanel.add(this.panel);
            tabPanel.setActiveItem('neusta-areabrick-overview-tab');

            this.panel.on('destroy', function () {
                pimcore.globalmanager.remove('neusta-areabrick-overview-tab');
            }.bind(this));

            // Ajax-Anfrage zum Abrufen des HTML-Inhalts vom Controller
            Ext.Ajax.request({
                url: '/admin/areabricks/list', // URL zu deinem Controller
                success: function(response) {
                    var htmlContent = response.responseText; // HTML-Content vom Controller
                    alert(htmlContent);
                    // Neuen Tab mit dem dynamischen HTML-Content hinzufügen
                    this.panel.setHtml(htmlContent);
                },
                failure: function() {
                    Ext.Msg.alert('Fehler', 'Der HTML-Inhalt konnte nicht geladen werden.');
                }
            });
        }

        return this.panel;
    },

});
