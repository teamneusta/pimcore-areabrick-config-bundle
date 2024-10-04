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
                        .querySelectorAll('#neusta_areabrick_config ul.additional-properties > li')
                        .forEach(el => {
                            const name = el.querySelector('span').textContent;
                            const rgb = this.hslToRgb(this.textToHSL(name));

                            el.style.backgroundColor = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
                            el.style.color = this.contrastingColor(rgb);
                        });
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

    // https://gist.github.com/0x263b/2bdd90886c2036a1ad5bcf06d6e6fb37#hsl
    textToHSL: function (string, opts = {}) {
        const hash = [...string].reduce((s, c) => Math.imul(31, s) + c.charCodeAt(0) | 0, 0);
        const {
            hue = [0, 360],
            sat = [0, 100],
            lit = [0, 100],
        } = opts;

        function range(num, min, max) {
            const diff = max - min;

            return (((num % diff) + diff) % diff) + min;
        }

        return {
            h: range(hash, hue[0], hue[1]),
            s: range(hash, sat[0], sat[1]),
            l: range(hash, lit[0], lit[1]),
        };
    },

    // https://en.wikipedia.org/wiki/HSL_and_HSV#HSL_to_RGB_alternative
    hslToRgb: function (hsl) {
        const h = hsl.h;
        const s = hsl.s / 100;
        const l = hsl.l / 100;

        function f(n) {
            const k = (n + h / 30) % 12;
            const a = s * Math.min(l, 1 - l);

            return l - a * Math.max(-1, Math.min(k - 3, 9 - k, 1));
        }

        return {
            r: Math.round(f(0) * 255),
            g: Math.round(f(8) * 255),
            b: Math.round(f(4) * 255),
        };
    },

    // https://www.w3.org/TR/WCAG21/#dfn-relative-luminance
    rgbToRelativeLuminance: function (rgb) {
        const srgb = this.mapObject(rgb, c => c / 255);
        const {r, g, b} = this.mapObject(srgb, c => {
            return c <= 0.04045
                ? c / 12.92
                : ((c + 0.055) / 1.055) ** 2.4;
        });

        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    },

    // https://dev.to/louis7/how-to-choose-the-font-color-based-on-the-background-color-402a
    contrastingColor: function (rgb) {
        return this.rgbToRelativeLuminance(rgb) > 0.179 ? '#000' : '#fff';
    },

    mapObject: function (obj, func) {
        return Object.fromEntries(Object.entries(obj).map(([k, v]) => [k, func(v)]));
    },

});
