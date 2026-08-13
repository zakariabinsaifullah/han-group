/**
 * WordPress Dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import classnames from 'classnames';

/**
 * Block Save Function
 */
const Save = ({ attributes }) => {
    const { uniqueId, tabId, parentTabId } = attributes;

    /**
     * Block Props
     */
    const blockProps = useBlockProps.save({
        className: classnames(uniqueId, 'tab-item', {
            show: tabId == '1'
        })
    });

    return (
        <div
            {...blockProps}
            data-tab={tabId}
            data-tab-parent-id={parentTabId}
            role="tabpanel"
            aria-labelledby={`tab-title-${tabId}`}
            id={`tab-content-${tabId}`}
            aria-hidden={tabId == '1' ? 'false' : 'true'}
        >
            <InnerBlocks.Content />
        </div>
    );
};

export default Save;
