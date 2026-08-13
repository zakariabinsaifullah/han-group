/**
 * Responsive gap helpers shared by the timeline's edit, save and inspector.
 *
 * Only breakpoints with an explicit value are written out; the stylesheets
 * cascade each unset breakpoint up to the next larger one.
 */

// Defaults, kept in sync with the fallbacks in the two style.scss files.
export const DEFAULT_ITEM_GAP = 50;
export const DEFAULT_ICON_GAP = 30;

const DEVICE_PREFIX = {
    Desktop: 'd',
    Tablet: 't',
    Mobile: 'm'
};

export const resolveGaps = (gaps, fallback) => ({
    Desktop: gaps?.Desktop ?? fallback,
    Tablet: gaps?.Tablet ?? gaps?.Desktop ?? fallback,
    Mobile: gaps?.Mobile ?? gaps?.Tablet ?? gaps?.Desktop ?? fallback
});

const gapProperties = (gaps, name) =>
    Object.entries(DEVICE_PREFIX).reduce((properties, [device, prefix]) => {
        const value = gaps?.[device];

        if (undefined !== value && null !== value) {
            properties[`--${prefix}${name}`] = `${value}px`;
        }

        return properties;
    }, {});

export const timelineGapProperties = (itemGaps, iconGaps) => ({
    ...gapProperties(itemGaps, 'item-gap'),
    ...gapProperties(iconGaps, 'icon-gap')
});
