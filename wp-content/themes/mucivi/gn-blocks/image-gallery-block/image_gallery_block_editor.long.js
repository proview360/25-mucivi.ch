(function (wp, blocks, element, data) {
    
    var el = element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = blocks.registerBlockType,
        MediaUpload = wp.blockEditor.MediaUpload,
        SelectControl = wp.components.SelectControl,
        InspectorControls = wp.blockEditor.InspectorControls;
    
    registerBlockType('gn/image-gallery-block', {
        title: 'Gallery-Block',
        icon: 'format-image',
        category: 'mucivi-blocks',
        description: "Gallery Images",
        
        attributes: {
            images: {
                type: 'array',
                default: [],
            },
            layout: {
                type: 'string',
                default: 'boxed'
            },
            background_color: {
                type: 'string',
                default: 'gray'
            },
            gallery_type: {
                type: 'string'
            },
            gallery_title: {
                type: 'string'
            },
            gallery_description: {
                type: 'string'
            }
        },
        
        edit: function (props) {
            
            if(!props.attributes.gallery_type)
            {
                props.setAttributes({gallery_type: "no-slider"})
            }
            
            
            function update_images(new_image) {
                const imageObject = {
                    url: new_image.url,
                    url_partner: ''
                };
                props.setAttributes({ images: [...props.attributes.images, imageObject] });
            }
            
            function update_image_url_partner(index, newUrlPartner) {
                const images = props.attributes.images.slice();
                images[index].url_partner = newUrlPartner;
                props.setAttributes({ images });
            }
            
            function move_left(index) {
                if (index === 0) return;
                const images = props.attributes.images.slice();
                [images[index - 1], images[index]] = [images[index], images[index - 1]];
                props.setAttributes({ images });
            }
            
            function move_right(index) {
                if (index === props.attributes.images.length - 1) return;
                const images = props.attributes.images.slice();
                [images[index + 1], images[index]] = [images[index], images[index + 1]];
                props.setAttributes({ images });
            }
            
            function remove_image(index_to_remove) {
                const images = props.attributes.images.filter((_, i) => i !== index_to_remove);
                props.setAttributes({ images });
            }
            
            function update_layout(new_value) {
                props.setAttributes({ layout: new_value });
            }
            
            function update_background_color(newValue) {
                props.setAttributes({ background_color: newValue });
            }
            
            function update_gallery_type (newValue) {
                props.setAttributes( { gallery_type: newValue } );
            }
            function update_gallery_title(event) {
                props.setAttributes( {gallery_title: event.target.value} )
            }
            
            function update_gallery_description(event) {
                props.setAttributes( {gallery_description: event.target.value} )
            }
            
            
            
            return el(Fragment, null,
                el(InspectorControls, { class: "granit-SelectControl" },
                    el("div", { class: "granit-block-sidebar-element" },
                        el("strong", null, "Layout"),
                        el(SelectControl, {
                            label: '',
                            value: props.attributes.layout,
                            options: [
                                { value: 'boxed', label: 'Boxed' },
                                { value: 'full-width', label: 'Full Width' }
                            ],
                            onChange: update_layout
                        }),
                        
                        el("strong", null, "Background Color"),
                        el(SelectControl, {
                            label: '',
                            value: props.attributes.background_color,
                            options: [
                                { value: 'white', label: 'White' },
                                { value: 'primary', label: 'Primary' },
                                { value: 'secondary', label: 'Secondary' }
                            ],
                            onChange: update_background_color
                        }),
                        el("strong", null, "Gallery Type"),
                        el(SelectControl,
                            {
                                label: '',
                                value: props.attributes.gallery_type,
                                options: [
                                    {
                                        value: 'no-slider',
                                        label: 'No Slider'
                                    },
                                    {
                                        value: 'slider',
                                        label: 'Slider'
                                    },
                                    {
                                        value: 'portfolio',
                                        label: 'Portfolio'
                                    }
                                ],
                                onChange: update_gallery_type
                            }
                        ),
                        
                    )
                ),
                
                el('div', {
                        class: "granit-block image-gallery-block count-" + props.attributes.images.length +
                            " bg-color-" + props.attributes.background_color
                    },
                    el("h3", null, "Gallery-Block"),
                    
                    (props.attributes.gallery_type === 'slider' ||  props.attributes.gallery_type === 'portfolio') && [
                        el("dt", null, "Gallery Title"),
                        el("input", {
                            key: "input",
                            type: "text",
                            value: props.attributes.gallery_title,
                            placeholder: "Write here...",
                            onChange: update_gallery_title
                        })
                    ],
                    
                    props.attributes.gallery_type === 'portfolio' && [
                        el("dt", null, "Gallery Description"),
                        el("input", {
                            key: "input",
                            type: "text",
                            value: props.attributes.gallery_description,
                            placeholder: "Write here...",
                            onChange: update_gallery_description
                        })
                    ],
            
                  el('div', { class: "image-gallery-elements" },
                        props.attributes.images.map((image, index) =>
                            el('div', { class: "image-gallery-style" },
                                el('p', {}, `Image ${index + 1}`),
                                el('img', { src: image.url, alt: image.url_partner || '', title: image.url_partner || '' }),
                                
                                el('input', {
                                    type: 'text',
                                    value: image.url_partner || '',
                                    placeholder: 'Write url_partner...',
                                    onChange: (event) => update_image_url_partner(index, event.target.value)
                                }),
                                
                                el('button', {
                                    onClick: () => remove_image(index),
                                    className: "image-gallery-btn-remove"
                                }, 'Remove Image'),
                                
                                el('div', { class: "image-gallery-left-right" },
                                    el('button', {
                                        onClick: () => move_left(index),
                                        className: "image-gallery-btn-move-left",
                                        dangerouslySetInnerHTML: { __html: '<i class="gg-chevron-left"></i>' }
                                    }),
                                    el('button', {
                                        onClick: () => move_right(index),
                                        className: "image-gallery-btn-move-right",
                                        dangerouslySetInnerHTML: { __html: '<i class="gg-chevron-right"></i>' }
                                    })
                                )
                            )
                        )
                    ),
                    
                    el("hr", {}),
                    
                    el('div', { class: "image-gallery-btn" },
                        el(MediaUpload, {
                            multiple: true, // allow selecting more than one image
                            gallery: true,
                            accept: "image/*",
                            allowedTypes: ['image'],
                            onSelect: (mediaArray) => {
                                if (Array.isArray(mediaArray)) {
                                    const newImages = mediaArray.map(media => ({
                                        url: media.url,
                                        url_partner: ''
                                    }));
                                    props.setAttributes({
                                        images: [...props.attributes.images, ...newImages]
                                    });
                                }
                            },
                            render: ({ open }) =>
                                el('button', {
                                    onClick: open,
                                    className: "image-gallery-button"
                                }, 'Choose Images')
                        })
                    )
                )
            );
        },
        
        save: function (props) {
            return el('ul', {},
                props.attributes.images.map((image, index) =>
                    el('li', {},
                        el('img', {
                            src: image.url,
                            alt: image.url_partner || '',
                            title: image.url_partner || ''
                        }),
                        image.url_partner && el('p', {}, image.url_partner)
                    )
                )
            );
        }
    });
})(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);
