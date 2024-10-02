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

                    document.getElementById(this.tabId)
                        .querySelectorAll('#neusta_areabrick_config .accordion a')
                        .forEach(el => {
                            const bgColor = this.toHSL(el.textContent);
                            // The threshold at which colors are considered "light."
                            // Range: integers from 0 to 100, recommended 50-70.
                            // Any lightness value below the threshold will result in white,
                            // any above will result in black.
                            const threshold = 50;

                            el.style.backgroundColor = `hsl(${bgColor.h}, ${bgColor.s}%, ${bgColor.l}%)`;
                            // https://css-tricks.com/switch-font-color-for-different-backgrounds-with-css/#aa-applying-the-trick-to-our-font-color-declaration
                            // soon™: https://developer.mozilla.org/en-US/docs/Web/CSS/color_value/color-contrast
                            el.style.color = `hsl(0, 0%, calc((${bgColor.l} - ${threshold}) * -100%))`;
                        })
                }.bind(this),
            });

            this.handleClick('#neusta_areabrick_config a[data-page-id]', el => {
                pimcore.helpers.openDocument(el.dataset.pageId, el.dataset.pageType);
            })
        }

        return this.panel;
    },

    handleClick: function (selector, handler) {
        document.getElementById(this.tabId).addEventListener('click', event => {
            const el = event.target.closest(selector);

            if (el) {
                handler(el, event);
            }
        });
    },

    // https://gist.github.com/0x263b/2bdd90886c2036a1ad5bcf06d6e6fb37
    toHSL: function (string, opts) {
        opts = opts || {};
        opts.hue = opts.hue || [0, 360];
        opts.sat = opts.sat || [75, 100];
        opts.lit = opts.lit || [40, 60];

        const range = function (hash, min, max) {
            const diff = max - min
            const x = ((hash % diff) + diff) % diff

            return x + min
        };

        let hash = 0
        for (let i = 0; i < string.length; i++) {
            hash = string.charCodeAt(i) + ((hash << 5) - hash);
            hash = hash & hash;
        }

        const h = range(hash, opts.hue[0], opts.hue[1]);
        const s = range(hash, opts.sat[0], opts.sat[1]);
        const l = range(hash, opts.lit[0], opts.lit[1]);

        return {h, s, l};
    },

});
