// import editor style
import './editor.scss';

/**
 * WordPress Dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { Fragment, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * External Dependencies
 */
import classnames from 'classnames';

/**
 * Internal Dependencies
 */

// block edit function
const Edit = props => {
    const { attributes, setAttributes, clientId } = props;
    const { uniqueId, tabId, parentTabId } = attributes;

    /**
     * Handle Block Unique Id
     */
    useEffect(() => {
        ({ uniqueId, setAttributes, clientId });
    }, []);

    /**
     * Block Props
     */
    const blockProps = useBlockProps({
        className: classnames(uniqueId, 'tab-item', {
            show: tabId == '1'
        })
    });

    return (
        <Fragment>
            <div
                {...blockProps}
                data-tab={tabId}
                data-tab-parent-id={parentTabId}
                role="tabpanel"
                aria-labelledby={`tab-title-${tabId}`}
                id={`tab-content-${tabId}`}
                aria-hidden={tabId == '1' ? 'false' : 'true'}
            >
                <InnerBlocks templateLock={false} template={[['core/paragraph', {}]]} />
            </div>
        </Fragment>
    );
};

export default Edit;
