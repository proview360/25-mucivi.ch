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
        example: {},


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
                type: 'string'
            },

            gallery_type: {
                type: 'string'
            }
        },

        edit: (function (props) {

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }


            if(!props.attributes.gallery_type)
            {
                props.setAttributes({gallery_type: "no-slider"})
            }

            function move_left(index) {
                // if first image it won't be moved left
                if (index === 0) return;

                const images = props.attributes.images.slice();

                const temp = images[index];
                images[index] = images[index - 1];
                images[index - 1] = temp;

                props.setAttributes({images});
            }

            function move_right(index) {
                // if last image it won't be moved to the right
                if (index === props.attributes.images.length - 1) return;

                const images = props.attributes.images.slice();

                const temp = images[index];
                images[index] = images[index + 1];
                images[index + 1] = temp;

                props.setAttributes({images})
            }

            function update_layout(new_value) {
                props.setAttributes({layout: new_value})
            }

            function update_images(new_image) {
                props.setAttributes({images: [...props.attributes.images, new_image]})
            }

            function remove_image(index_to_remove) {
                props.setAttributes({
                    images: props.attributes.images.filter(
                        (_, index) => index !== index_to_remove
                    )
                });
            }

            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_gallery_type (newValue) {
                props.setAttributes( { gallery_type: newValue } );
            }

            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },

                            el("strong", null, "Layout"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.layout,
                                    options: [
                                        {
                                            value: 'boxed',
                                            label: 'Content Breite'
                                        },
                                        {
                                            value: 'full-width',
                                            label: 'Volle Breite'
                                        }
                                    ],
                                    onChange: update_layout
                                }
                            ),
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
                                        }
                                    ],
                                    onChange: update_gallery_type
                                }
                            ),
                            el("strong", null, "Background Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.background_color,
                                    options: [
                                        {
                                            value: 'grayblue',
                                            label: 'Gray'
                                        },
                                        {
                                            value: 'white',
                                            label: 'White'
                                        },
                                        {
                                            value: 'black',
                                            label: 'Black'
                                        },
                                        {
                                            value: 'red',
                                            label: 'Red'
                                        },

                                    ],
                                    onChange: update_background_color
                                }
                            ),

                        )
                    ),


                    el('div', {
                            class: "granit-block image-gallery-block count-" + props.attributes.images.length + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Gallery-Block"),
                        el('div',
                            {
                                class: "image-gallery-elements",
                            },
                            props.attributes.images.map((image, index) =>
                                el('div',
                                    {
                                        class: "image-gallery-style"
                                    },
                                    el('p',
                                        {}
                                        , `Image ${index + 1}`),
                                    el('img', {src: image.url}),
                                    el('button',
                                        {
                                            onClick: () => remove_image(index), className: "image-gallery-btn-remove"
                                        }, 'Remove Image'
                                    ),
                                    el('div',
                                        {
                                            class: "image-gallery-left-right"
                                        },
                                        el('button', {
                                            onClick: () => move_left(index),
                                            className: "image-gallery-btn-move-left",
                                            dangerouslySetInnerHTML: {__html: '<i class="gg-chevron-left"></i>'}
                                        }),
                                        el('button', {
                                            onClick: () => move_right(index),
                                            className: "image-gallery-btn-move-right",
                                            dangerouslySetInnerHTML: {__html: '<i class="gg-chevron-right"></i>'}
                                        }),
                                    )
                                )
                            ),
                        ),

                        el("hr",
                            {}
                        ),

                        el('div',
                            {
                                class: "image-gallery-btn",
                            },
                            el(MediaUpload,
                                {
                                    onSelect: update_images,
                                    accept: "image/*",
                                    allowedTypes: ['image'],
                                    render: ({open}) =>
                                        el('button',
                                            {
                                                onClick: open,
                                                className: "image-gallery-button"
                                            },
                                            'Choose Image'),
                                }
                            ),
                        )

                    )
                )
            );
        }),

        //set save function
        save: function (props) {
            return null;
        }

    });
})(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);