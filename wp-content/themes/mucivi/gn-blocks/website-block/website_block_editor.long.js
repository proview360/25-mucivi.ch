( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/website-block', {
        title: 'Website Demo Block',
        icon: 'admin-site-alt3',
        category: 'mucivi-blocks',
        description: "website block ",
        example: {},

        attributes: {
            number: {
                type: 'string'

            },
            layout: {

                type: 'string'
            },

            button_text: {
                type: 'string'
            },
            button_link: {
                type: 'string'
            },
            desktop_image: {
                type: 'object'
            },
            mobile_image: {
                type: 'object'
            },

            text_color: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
        },

        edit: ( function ( props ) {

            var image_not_present_1= "",
                image_not_present_2= "";


            if (!props.attributes.desktop_image)
            {
                image_not_present_1 = "gn-image-not-present";
            }
            if (!props.attributes.mobile_image)
            {
                image_not_present_2 = "gn-image-not-present";
            }

            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }

            function update_button_text( event ) {
                props.setAttributes( { button_text: event.target.value } );
            }

            function update_button_link( event ) {
                props.setAttributes( { button_link: event.target.value } );
            }

            function update_mobile_image( newContent ) {
                props.setAttributes( { mobile_image: newContent } )
            }
            function remove_mobile_image() {
                props.setAttributes( { mobile_image: null } )
            }
            function update_desktop_image( newContent ) {
                props.setAttributes( { desktop_image: newContent } )
            }
            function remove_desktop_image() {
                props.setAttributes( { desktop_image: null } )
            }

            function update_text_color (event) {
                props.setAttributes( {text_color: event.target.value} )
            }
            function update_background_color(event) {
                props.setAttributes({ background_color: event.target.value });
            }



            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},
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

                    ),

                    el("div", {
                            class: "granit-block website-section-block " + " text-" + props.attributes.text_color + " bg-" + props.attributes.background_color
                        },
                        el("h3", null, "Website Demo"),

                        el("dl", null,

                            el("div", null,



                                el("dd", { class: "ele-1" },



                                el("dd", { class: "ele-3" },
                                    el("p", { class: "label-text" }, "Image Desktop"),
                                    el(MediaUpload, {
                                        onSelect: update_desktop_image,
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

                                    el("button", {
                                            class: "btn-remove-img " + image_not_present_1,
                                            onClick: remove_desktop_image
                                        },
                                        "Remove Image"),
                                    el("div", null,
                                        props.attributes.desktop_image && el("img", {
                                            src: props.attributes.desktop_image["url"]
                                        })
                                    ),
                                ),

                                    el("p", { class: "label-text" }, "Image Mobile"),
                                    el(MediaUpload, {
                                        onSelect: update_mobile_image,
                                        accept: "image/*",
                                        allowedTypes: 'image',
                                        render: function render(_ref) {
                                            var open = _ref.open;
                                            return el("button", {
                                                className: "btn",
                                                icon: "edit",
                                                onClick: open
                                            }, "Choose Image");
                                        }
                                    }),
                                    el("button",
                                        {
                                            class: "btn-remove-img " + image_not_present_2,
                                            onClick: remove_mobile_image
                                        },
                                        "Remove Image"),
                                    el("div", null,
                                        props.attributes.mobile_image && el("img", {
                                            src: props.attributes.mobile_image["url"]
                                        })
                                    )
                                ),



                                el("dd", { class: "ele-2" },

                                    el("p", { class: "label-text" }, "Button Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.button_text,
                                        placeholder: "Write here...",
                                        onChange: update_button_text
                                    }),

                                    el("p", { class: "label-text" }, "Button Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.button_link,
                                        placeholder: "Write here...",
                                        onChange: update_button_link
                                    }),


                                    el("div", {},
                                            el("p", { class: "label-text" }, "Text Color "),
                                            el("select", {
                                                    value: props.attributes.text_color,
                                                    onChange: update_text_color
                                                },
                                                el('option', {value: 'color-white'}, 'White'),
                                                el('option', {value: 'color-grayblue'}, 'Gray'),
                                                el('option', {value: 'color-black'}, 'Black'),
                                                el('option', {value: 'color-red'}, 'Red'),
                                            )
                                    ),


                                        el("div", {},
                                            el("p", { class: "label-text" }, "Background Color "),
                                            el("select", {
                                                    value: props.attributes.background_color,
                                                    onChange: update_background_color
                                                },
                                                el('option',
                                                    {
                                                        value: 'color-white',
                                                        selected: props.attributes.background_color === 'white'
                                                    },
                                                    'White'
                                                ),
                                                el('option',
                                                    {
                                                        value: 'color-grayblue',
                                                        selected: props.attributes.background_color === 'gray'
                                                    },
                                                    'Gray'
                                                ),
                                                el('option',
                                                    {
                                                        value: 'color-extra-light-gray',
                                                        selected: props.attributes.background_color === 'extra-light-gray'
                                                    },
                                                    'Extra Light Gray'
                                                ),
                                                el('option',
                                                    {
                                                        value: 'color-black',
                                                        selected: props.attributes.background_color === 'black'
                                                    },
                                                    'Black'
                                                ),
                                                el('option',
                                                    {
                                                        value: 'color-red',
                                                        selected: props.attributes.background_color === 'red'
                                                    },
                                                    'Red'
                                                ),
                                            )
                                        ),

                                )

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