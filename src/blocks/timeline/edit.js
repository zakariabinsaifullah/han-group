import { useBlockProps, useInnerBlocksProps, BlockControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { plus } from '@wordpress/icons';
import classNames from 'classnames';
import Inspector from './inspector';
import { timelineGapProperties } from './gaps';

const TEMPLATE = [
    ['hang/timeline-item', {}],
    ['hang/timeline-item', {}],
    ['hang/timeline-item', {}]
];

const Edit = props => {
    const { attributes, clientId, isSelected } = props;
    const hasSelectedInnerBlock = useSelect(select => select('core/block-editor').hasSelectedInnerBlock(clientId, true));
    const { uniqueId, itemGaps, iconGaps } = attributes;

    // Item and icon gaps cascade down from desktop; the items read them via inheritance.
    const cssCustomProperties = timelineGapProperties(itemGaps, iconGaps);

    const blockProps = useBlockProps({
        className: classNames(uniqueId),
        style: cssCustomProperties
    });

    const innerBlockProps = useInnerBlocksProps(
        { className: 'hang-timeline' },
        {
            allowedBlocks: ['hang/timeline-item'],
            template: TEMPLATE,
            templateLock: false,
            renderAppender: false
        }
    );

    const addItem = () => {
        const childBlocks = wp.data.select('core/block-editor').getBlocks(clientId);
        const newBlock = wp.blocks.createBlock('hang/timeline-item', {});
        wp.data.dispatch('core/block-editor').insertBlocks(newBlock, childBlocks.length, clientId);
    };

    return (
        <Fragment>
            {(isSelected || hasSelectedInnerBlock) && <Inspector {...props} />}
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton icon={plus} label={__('Add Timeline Item', 'han-group')} onClick={addItem} />
                </ToolbarGroup>
            </BlockControls>
            <div {...blockProps}>
                <div {...innerBlockProps} />
            </div>
        </Fragment>
    );
};

export default Edit;
