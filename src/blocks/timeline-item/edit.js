import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { NativeIconPicker } from '../../components';
import { RenderIcon } from '../../helpers';
import { __ } from '@wordpress/i18n';

const INNER_TEMPLATE = [['core/paragraph']];

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { iconName, iconType, customSvgCode, iconSize } = attributes;

    const blockProps = useBlockProps();
    
    const innerBlockProps = useInnerBlocksProps({ className: 'timeline-content' }, { template: INNER_TEMPLATE, templateLock: false });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Icon Settings', 'han-group')}>
                    <NativeIconPicker
                        onIconSelect={(name, type) => {
                            setAttributes({ iconName: name, iconType: type, customSvgCode: undefined });
                        }}
                        onCustomSvgInsert={({ customSvgCode, iconType }) => {
                            setAttributes({ customSvgCode, iconType, iconName: undefined });
                        }}
                        iconName={iconName}
                        customSvgCode={customSvgCode}
                        iconSize={iconSize}
                    />
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <div className="timeline-icon-row">
                    <div className="timeline-icon">
                        <RenderIcon customSvgCode={customSvgCode} iconName={iconName} size={iconSize} />
                    </div>
                </div>
                <div {...innerBlockProps} />
            </div>
        </>
    );
};

export default Edit;
