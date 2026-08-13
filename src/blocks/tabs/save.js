/**
 * WordPress dependencies
 */
import { RichText, useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';

/**
 * External Dependencies
 */
import classnames from 'classnames';

// Internal Dependencies

// block save function
const Save = props => {
    const { attributes } = props;
    const { uniqueId, tabTitles, tabTitleTag, blockStyle } = attributes;
    const tabsLength = tabTitles?.length || 0;

    /**
     * Block Props
     */
    const blockProps = useBlockProps.save({
        className: classnames('wp-block-hang-tabs', uniqueId),
        style: blockStyle
    });

    return (
        <div {...blockProps}>
            <div className="tabs-wrapper" role="tablist" tabIndex={0}>
                <div className="tabs-nav">
                    {tabTitles &&
                        tabTitles?.length > 0 &&
                        tabTitles.map((tab, index) => {
                            return (
                                <Fragment key={index}>
                                    <div
                                        className={classnames('nav-item', {
                                            active: tab?.id === '1'
                                        })}
                                        role="tab"
                                        tabIndex={0}
                                        aria-selected={tab?.id === '1' ? 'true' : 'false'}
                                        data-nav={tab?.id}
                                    >
                                        <div className={classnames('nav-item-inner')}>
                                            <span className="nav-item-number">{index + 1}</span>
                                            <div className="tab-content">
                                                <RichText.Content tagName={tabTitleTag} className="tab-title" value={tab?.title} />
                                            </div>
                                        </div>
                                    </div>
                                    {index < tabsLength - 1 && (
                                        <span className="nav-arrow" aria-hidden="true">
                                            <svg width="36" height="40" viewBox="0 0 36 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="m17.957 27.796-1.647-1.634 4.325-4.325H10.5v-2.4h10.135l-4.325-4.32 1.647-1.64 7.16 7.16z"
                                                    fill="#77a2ff"
                                                />
                                            </svg>
                                        </span>
                                    )}
                                </Fragment>
                            );
                        })}
                </div>
                <div className="tabs-content">
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>
    );
};

export default Save;
