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
                            const hsl = this.toHSL(el.textContent);
                            const rgb = this.hslToRgb(hsl.h / 360, hsl.s / 100, hsl.l / 100);

                            el.style.backgroundColor = `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
                            el.style.color = this.textColorBasedOnBackground(rgb.r, rgb.g, rgb.b);
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

    // https://stackoverflow.com/a/9493060
    /**
     * Converts an HSL color value to RGB. Conversion formula
     * adapted from https://en.wikipedia.org/wiki/HSL_color_space.
     * Assumes h, s, and l are contained in the set [0, 1] and
     * returns r, g, and b in the set [0, 255].
     *
     * @param   {number}  h                         The hue
     * @param   {number}  s                         The saturation
     * @param   {number}  l                         The lightness
     * @return  {{r: number, g: number, b: number}} The RGB representation
     */
    hslToRgb: function (h, s, l) {
        const {round} = Math
        let r, g, b

        function hueToRgb(p, q, t) {
            if (t < 0) t += 1
            if (t > 1) t -= 1
            if (t < 1 / 6) return p + (q - p) * 6 * t
            if (t < 1 / 2) return q
            if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6
            return p
        }

        if (s === 0) {
            r = g = b = l // achromatic
        } else {
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s
            const p = 2 * l - q
            r = hueToRgb(p, q, h + 1 / 3)
            g = hueToRgb(p, q, h)
            b = hueToRgb(p, q, h - 1 / 3)
        }

        return {
            r: round(r * 255),
            g: round(g * 255),
            b: round(b * 255),
        }
    },

    // https://dev.to/louis7/how-to-choose-the-font-color-based-on-the-background-color-402a
    textColorBasedOnBackground: function (r, g, b) {
        const srgb = [r / 255, g / 255, b / 255];
        const x = srgb.map((i) => {
            return i <= 0.04045 ? i / 12.92 : Math.pow((i + 0.055) / 1.055, 2.4);
        })

        const L = 0.2126 * x[0] + 0.7152 * x[1] + 0.0722 * x[2];

        return L > 0.179 ? "#000" : "#fff";
    },

});
