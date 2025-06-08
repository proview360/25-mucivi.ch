( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        TextControl         = wp.components.TextControl,
        InspectorControls   = wp.blockEditor.InspectorControls,
        PanelBody           = wp.components.PanelBody;

    registerBlockType( 'gn/image-block', {
        title: 'Image-Block',
        icon: 'format-image',
        category: 'mucivi-blocks',
        description: "Image Block",
        example: {},

        attributes: {
            img_1: {
                type: 'object'

            },
            layout: {

                type: 'string'
            },
            background_color: {
                type: 'string'
            },
            image_link: {
                type: 'string'
            },
            image_width: {
                type: 'string'
            },
            image_height: {
                type: 'string'
            },
            // Desktop Padding
            desktop_padding_top: {
                type: 'string',
            },
            desktop_padding_right: {
                type: 'string',
            },
            desktop_padding_bottom: {
                type: 'string',
            },
            desktop_padding_left: {
                type: 'string',
            },
            // Tablet Padding
            tablet_padding_top: {
                type: 'string',
            },
            tablet_padding_right: {
                type: 'string',
            },
            tablet_padding_bottom: {
                type: 'string',
            },
            tablet_padding_left: {
                type: 'string',
            },
            // Mobile Padding
            mobile_padding_top: {
                type: 'string',
            },
            mobile_padding_right: {
                type: 'string',
            },
            mobile_padding_bottom: {
                type: 'string',
            },
            mobile_padding_left: {
                type: 'string',
            },
        },



        edit: ( function ( props ) {

            var image_not_present_1= "";

            if (!props.attributes.img_1)
            {
                image_not_present_1 = "gn-image-not-present";
            }

            if(!props.attributes.text_color)
            {
                props.setAttributes({text_color: "black"})
            }
            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }

            function update_image_1( newContent ) {
                props.setAttributes( { img_1: newContent } )
            }
            function remove_image_1() {
                props.setAttributes( { img_1: null } )
            }
            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }

            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_desktop_padding_top( value ) {
                props.setAttributes( { desktop_padding_top: value } )
            }
            function update_desktop_padding_right( value ) {
                props.setAttributes( { desktop_padding_right: value } )
            }
            function update_desktop_padding_bottom( value ) {
                props.setAttributes( { desktop_padding_bottom: value } )
            }
            function update_desktop_padding_left( value ) {
                props.setAttributes( { desktop_padding_left: value } )
            }

            function update_tablet_padding_top( value ) {
                props.setAttributes( { tablet_padding_top: value } )
            }
            function update_tablet_padding_right( value ) {
                props.setAttributes( { tablet_padding_right: value } )
            }
            function update_tablet_padding_bottom( value ) {
                props.setAttributes( { tablet_padding_bottom: value } )
            }
            function update_tablet_padding_left( value ) {
                props.setAttributes( { tablet_padding_left: value } )
            }

            function update_mobile_padding_top( value ) {
                props.setAttributes( { mobile_padding_top: value } )
            }
            function update_mobile_padding_right( value ) {
                props.setAttributes( { mobile_padding_right: value } )
            }
            function update_mobile_padding_bottom( value ) {
                props.setAttributes( { mobile_padding_bottom: value } )
            }
            function update_mobile_padding_left( value ) {
                props.setAttributes( { mobile_padding_left: value } )
            }

            function update_image_link(event) {
                props.setAttributes({image_link: event.target.value});
            }
            function update_image_width(event) {
                props.setAttributes({image_width: event.target.value});
            }
            
            function update_image_height(event) {
                props.setAttributes({image_height: event.target.value});
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
                                            label: 'Container'
                                        },
                                        {
                                            value: 'full-width',
                                            label: 'Full Width'
                                        }
                                    ],
                                    onChange: update_layout
                                }
                            ),
                            el("strong", null, "Background Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.background_color,
                                    options: [
                                        {
                                            value: 'white',
                                            label: 'White'
                                        },
                                        {
                                            value: 'black',
                                            label: 'Black'
                                        },
                                        {
                                            value: 'primary',
                                            label: 'primary'
                                        },
                                        {
                                            value: 'secondary',
                                            label: 'Secondary'
                                        },
                                    
                                    ],
                                    onChange: update_background_color
                                }
                            ),

                            el(PanelBody,
                                {
                                    title: 'Desktop Padding in PX',
                                    initialOpen: false
                                },
                                // Padding Controls for Desktop
                                el("strong", null, "Desktop Padding Top"),
                                el(TextControl, {
                                    value: props.attributes.desktop_padding_top,
                                    onChange: update_desktop_padding_top
                                }),
                                el("strong", null, "Desktop Padding Right"),
                                el(TextControl, {
                                    value: props.attributes.desktop_padding_right,
                                    onChange: update_desktop_padding_right
                                }),
                                el("strong", null, "Desktop Padding Bottom"),
                                el(TextControl, {
                                    value: props.attributes.desktop_padding_bottom,
                                    onChange: update_desktop_padding_bottom
                                }),
                                el("strong", null, "Desktop Padding Left"),
                                el(TextControl, {
                                    value: props.attributes.desktop_padding_left,
                                    onChange: update_desktop_padding_left
                                }),
                            ),

                            el(PanelBody,
                                {
                                    title: 'Tablet Padding in PX',
                                    initialOpen: false
                                },
                                // Padding Controls for Tablet
                                el("strong", null, "Tablet Padding Top"),
                                el(TextControl, {
                                    value: props.attributes.tablet_padding_top,
                                    onChange: update_tablet_padding_top
                                }),
                                el("strong", null, "Tablet Padding Right"),
                                el(TextControl, {
                                    value: props.attributes.tablet_padding_right,
                                    onChange: update_tablet_padding_right
                                }),
                                el("strong", null, "Tablet Padding Bottom"),
                                el(TextControl, {
                                    value: props.attributes.tablet_padding_bottom,
                                    onChange: update_tablet_padding_bottom
                                }),
                                el("strong", null, "Tablet Padding Left"),
                                el(TextControl, {
                                    value: props.attributes.tablet_padding_left,
                                    onChange: update_tablet_padding_left
                                }),
                            ),

                            el(PanelBody,
                                {
                                    title: 'Mobile Padding in PX',
                                    initialOpen: false
                                },
                                // Padding Controls for Mobile
                                el("strong", null, "Mobile Padding Top"),
                                el(TextControl, {
                                    value: props.attributes.mobile_padding_top,
                                    onChange: update_mobile_padding_top
                                }),
                                el("strong", null, "Mobile Padding Right"),
                                el(TextControl, {
                                    value: props.attributes.mobile_padding_right,
                                    onChange: update_mobile_padding_right
                                }),
                                el("strong", null, "Mobile Padding Bottom"),
                                el(TextControl, {
                                    value: props.attributes.mobile_padding_bottom,
                                    onChange: update_mobile_padding_bottom
                                }),
                                el("strong", null, "Mobile Padding Left"),
                                el(TextControl, {
                                    value: props.attributes.mobile_padding_left,
                                    onChange: update_mobile_padding_left
                                }),
                            ),

                        )
                    ),

                    el("div", {
                            class: "granit-block image-block bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Image-Block"),

                        el("dl", null,

                            el("div", null,




                                el("dt", null, "Image"),
                                el("dd", null,

                                    el(MediaUpload, {
                                        onSelect: update_image_1,
                                        accept: "image/*",
                                        allowedTypes: 'image',
                                        render: function render(_ref) {
                                            var open = _ref.open;

                                            return el("button", {
                                                className: "btn",
                                                icon: "edit",
                                                onClick: open
                                            }, "Choose Image");
                                        }}
                                    ),
                                    el("button",
                                        {
                                            class: "btn-remove-img " + image_not_present_1,
                                            onClick: remove_image_1
                                        },
                                        "Delete Image"),
                                    el("div", null,
                                        props.attributes.img_1 && el("img", {
                                            src: props.attributes.img_1["url"]
                                        })
                                    ),
                                ),
                                el("h3", null, "Image Link (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.image_link,
                                    placeholder: "Write here...",
                                    onChange: update_image_link
                                }),
                                el("h3", null, "Image Width in PX (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.image_width,
                                    placeholder: "Write here...",
                                    onChange: update_image_width
                                }),
                                el("h3", null, "Image Height in PX (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.image_height,
                                    placeholder: "Write here...",
                                    onChange: update_image_height
                                }),
                            ),
                        ),
                    )
                )
            );
        }),

        //set save function
        save: function( props ) {

            return null;
        }

    });
} )(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);