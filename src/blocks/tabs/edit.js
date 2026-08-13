// import editor style
import './editor.scss';

/**
 * WordPress Dependencies
 */
import { RichText, useBlockProps, useInnerBlocksProps, BlockControls } from '@wordpress/block-editor';
import { ToolbarButton, ToolbarGroup } from '@wordpress/components';
import { Fragment, useEffect, useRef, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { dispatch, select, useSelect } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';

/**
 * External Dependencies
 */
import classnames from 'classnames';
import { times } from 'lodash';

/**
 * Internal Dependencies
 */
import Inspector from './inspector';

const Edit = props => {
    const { attributes, setAttributes, clientId, isSelected } = props;

    const { uniqueId, tabTitles, tabChildCount, tabTitleTag, navItemBg, numberBg, numberColor } = attributes;

    /**
     * CSS Custom Properties
     */
    const cssCustomProperties = {
        ...(navItemBg && { '--hang-tabs-nav-bg': navItemBg }),
        ...(numberBg && { '--hang-tabs-num-bg': numberBg }),
        ...(numberColor && { '--hang-tabs-num-color': numberColor })
    };

    useEffect(() => {
        setAttributes({
            blockStyle: cssCustomProperties
        });
    }, [navItemBg, numberBg, numberColor]);

    const tabRef = useRef(null);
    const [activeTabIndex, setActiveTabIndex] = useState('1');

    /**
     * Actual tab children — the single source of truth for the nav.
     */
    const childBlocks = useSelect(sel => sel('core/block-editor').getBlocks(clientId), [clientId]);

    /**
     * Keep the nav (tabTitles) in sync with the real tab children so that
     * adding, removing or reordering a tab is reflected in the nav.
     */
    useEffect(() => {
        if (!Array.isArray(childBlocks)) return;

        const childIds = childBlocks.filter(block => block.name === 'hang/tab').map(block => block.attributes.tabId);

        // Wait until the initial template has rendered its children.
        if (childIds.length === 0) return;

        const inSync = childIds.length === tabTitles.length && childIds.every((id, index) => tabTitles[index] && tabTitles[index].id === id);

        if (inSync) return;

        const newTitles = childIds.map((id, index) => {
            const existing = tabTitles.find(title => title.id === id);
            return existing || { id, title: `${__('Tab', 'han-group')} ${index + 1}` };
        });

        setAttributes({ tabTitles: newTitles, tabChildCount: childIds.length });

        // If the active tab was removed, fall back to the first one.
        if (!childIds.includes(activeTabIndex)) {
            setActiveTabIndex(childIds[0]);
        }
    }, [childBlocks]);

    /**
     * Block Props
     */
    const blockProps = useBlockProps({
        className: classnames(uniqueId),
        style: cssCustomProperties
    });

    /**
     * Inner Blocks
     */
    const innerBlocksProps = useInnerBlocksProps(
        { className: 'tabs-content' },
        {
            templateLock: false,
            renderAppender: false,
            template: times(tabChildCount, n => [
                'hang/tab',
                {
                    tabId: `${n + 1}`,
                    parentTabId: uniqueId
                }
            ]),
            allowedBlocks: ['hang/tab']
        }
    );

    /**
     * Tabs Interactivity
     */
    const handleTabClick = tabId => {
        const tabsParent = tabRef?.current;
        if (!tabsParent) return;

        const tabItems = tabsParent.querySelectorAll('.tabs-content .tab-item');

        tabItems.forEach(tab => {
            tab.style.display = tab.getAttribute('data-tab') === tabId ? 'block' : 'none';
        });

        setActiveTabIndex(tabId);
    };
    const appendBtn = () => {
        const currentChildren = select('core/block-editor').getBlocks(clientId);
        const tabs = currentChildren.filter(block => block.name === 'hang/tab');

        // Use the highest existing tabId + 1 so ids stay unique after removals.
        const nextId = String(tabs.reduce((max, block) => Math.max(max, parseInt(block.attributes.tabId, 10) || 0), 0) + 1);

        const newBlock = createBlock('hang/tab', {
            tabId: nextId,
            parentTabId: uniqueId
        });
        dispatch('core/block-editor').insertBlock(newBlock, currentChildren.length, clientId);

        // The nav title is added by the sync effect that watches child blocks.
        setActiveTabIndex(nextId);
    };

    return (
        <Fragment>
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton icon="insert" title={__('Add Button', 'han-group')} onClick={appendBtn} />
                </ToolbarGroup>
            </BlockControls>
            {isSelected && <Inspector {...props} handleTabClick={handleTabClick} uniqueId={uniqueId} />}

            <div {...blockProps}>
                <div className="tabs-wrapper" role="tablist" ref={tabRef}>
                    <div className="tabs-nav">
                        {tabTitles.map((tab, index) => (
                            <Fragment key={index}>
                                <div
                                    className={classnames('nav-item', {
                                        active: tab.id === activeTabIndex
                                    })}
                                    role="tab"
                                    data-nav={tab.id}
                                    onClick={() => handleTabClick(tab.id)}
                                >
                                    <div className="nav-item-inner">
                                        <span className="nav-item-number">{index + 1}</span>
                                        <div className="tab-content">
                                            <RichText
                                                tagName={tabTitleTag}
                                                className="tab-title"
                                                value={tab.title}
                                                onChange={value => {
                                                    const newTabs = [...tabTitles];
                                                    newTabs[index].title = value;
                                                    setAttributes({ tabTitles: newTabs });
                                                }}
                                                placeholder={__('Title', 'han-group')}
                                            />
                                        </div>
                                    </div>
                                </div>
                                {index < tabTitles.length - 1 && (
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
                        ))}
                    </div>

                    <div {...innerBlocksProps} />
                </div>
            </div>
        </Fragment>
    );
};

export default Edit;
