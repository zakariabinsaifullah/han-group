import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { NativeResponsiveControl } from '../../components';
import { DEFAULT_ICON_GAP, DEFAULT_ITEM_GAP, resolveGaps } from './gaps';

const Inspector = props => {
    const { attributes, setAttributes } = props;
    const { resMode, itemGaps, iconGaps } = attributes;

    const resolvedItemGaps = resolveGaps(itemGaps, DEFAULT_ITEM_GAP);
    const resolvedIconGaps = resolveGaps(iconGaps, DEFAULT_ICON_GAP);

    // Tablet and mobile inherit until they are given a value of their own.
    const inheritedHelp = gaps =>
        'Desktop' !== resMode && undefined === gaps?.[resMode]
            ? __('Inherited from the larger screen size. Change it to set a gap just for this device.', 'han-group')
            : undefined;

    return (
        <InspectorControls>
            <PanelBody title={__('Timeline Settings', 'han-group')} initialOpen={true}>
                <NativeResponsiveControl label={__('Gap (between items)', 'han-group')} props={props}>
                    <RangeControl
                        value={resolvedItemGaps[resMode]}
                        onChange={value => setAttributes({ itemGaps: { ...itemGaps, [resMode]: value } })}
                        min={0}
                        max={200}
                        step={1}
                        allowReset
                        help={inheritedHelp(itemGaps)}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                </NativeResponsiveControl>
                <NativeResponsiveControl label={__('Gap (icon → content)', 'han-group')} props={props}>
                    <RangeControl
                        value={resolvedIconGaps[resMode]}
                        onChange={value => setAttributes({ iconGaps: { ...iconGaps, [resMode]: value } })}
                        min={0}
                        max={100}
                        step={1}
                        allowReset
                        help={inheritedHelp(iconGaps)}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                </NativeResponsiveControl>
            </PanelBody>
        </InspectorControls>
    );
};

export default Inspector;
