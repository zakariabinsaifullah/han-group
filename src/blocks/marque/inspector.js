import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

import { NativeToggleGroupControl, NativeRangeControl, NativeToggleControl } from '../../components';

const Inspector = props => {
    const { attributes, setAttributes } = props;
    const { speed, direction, pauseOnHover, gap, orientation, height } = attributes;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Marquee Settings', 'han-group')}>
                    <NativeToggleGroupControl
                        label={__('Orientation', 'han-group')}
                        value={orientation}
                        onChange={value => setAttributes({ orientation: value })}
                        options={[
                            { value: 'horizontal', label: __('Horizontal', 'han-group') },
                            { value: 'vertical', label: __('Vertical', 'han-group') }
                        ]}
                    />

                    <NativeToggleGroupControl
                        label={__('Direction', 'han-group')}
                        value={direction}
                        onChange={value => setAttributes({ direction: value })}
                        options={[
                            {
                                value: 'left',
                                label: orientation === 'vertical' ? __('Up', 'han-group') : __('Left', 'han-group')
                            },
                            {
                                value: 'right',
                                label: orientation === 'vertical' ? __('Down', 'han-group') : __('Right', 'han-group')
                            }
                        ]}
                    />

                    <NativeRangeControl
                        label={__('Speed', 'han-group')}
                        value={speed}
                        onChange={value => setAttributes({ speed: value })}
                        min={1}
                        max={200}
                        step={1}
                        help={__('Higher values = Slower scrolling', 'han-group')}
                    />
                    <NativeRangeControl
                        label={__('Gap between items (px)', 'han-group')}
                        value={gap}
                        onChange={value => setAttributes({ gap: value })}
                        min={1}
                        max={100}
                        step={1}
                    />
                    {orientation === 'vertical' && (
                        <NativeRangeControl
                            label={__('Vertical Height', 'han-group')}
                            value={height || 500}
                            onChange={value => setAttributes({ height: value })}
                            min={200}
                            max={1000}
                            help={__('Set the visible height for vertical scrolling', 'han-group')}
                        />
                    )}
                    <NativeToggleControl
                        label={__('Pause on Hover', 'han-group')}
                        checked={pauseOnHover}
                        onChange={value => setAttributes({ pauseOnHover: value })}
                    />
                </PanelBody>
            </InspectorControls>
        </>
    );
};

export default Inspector;
