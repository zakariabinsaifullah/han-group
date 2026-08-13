import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { RenderIcon } from '../../helpers';

const Save = (props) => {
    const { attributes } = props;
    const { iconName, iconType, customSvgCode, iconSize } = attributes;

    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
            <div className="timeline-icon-row">
                <div className="timeline-icon">
                    <RenderIcon customSvgCode={customSvgCode} iconName={iconName} size={iconSize} />
                </div>
            </div>
            <div className="timeline-content">
                <InnerBlocks.Content />
            </div>
        </div>
    );
};

export default Save;
