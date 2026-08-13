import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import './editor.scss';
import Inspector from './inspector';

export default function Edit({ attributes, setAttributes, isSelected }) {
    const { gap, orientation, height } = attributes;

    const blockStyle = {};
    if (orientation === 'vertical' && height) {
        blockStyle.height = `${height}px`;
    }

    const blockProps = useBlockProps({
        className: `hang-marquee-wrapper marquee-${orientation || 'horizontal'}`,
        style: blockStyle
    });

    const TEMPLATE = [['core/paragraph']];

    const innerBlocksProps = useInnerBlocksProps(
        {
            className: `hang-marquee-items`,
            style: {
                gap: `${gap}px`
            }
        },
        {
            template: TEMPLATE,
            orientation: orientation || 'horizontal'
        }
    );

    return (
        <>
            <div {...blockProps}>
                {isSelected && <Inspector attributes={attributes} setAttributes={setAttributes} />}
                <div {...innerBlocksProps} />
            </div>
        </>
    );
}
