( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/honeycomb-block', {
        title: 'Honeycomb Block',
        icon: 'image-filter',
        category: 'mucivi-blocks',
        description: "Honeycomb block",
        example: {},

        attributes: {
            // img_1: {
            //     type: 'object'
            //
            // },
            layout: {

                type: 'string'
            },
            headline: {
                type: 'string'
            },
            sub_headline: {
                type: 'string'
            },

            button_text: {
                type: 'string'
            },
            button_link: {
                type: 'string'
            },
        },



        edit: ( function ( props ) {

            // var image_not_present_1= "";
            //
            // if (!props.attributes.img_1)
            // {
            //     image_not_present_1 = "gn-image-not-present";
            // }

            if(!props.attributes.text_color)
            {
                props.setAttributes({text_color: "black"})
            }

            // function update_image_1( newContent ) {
            //     props.setAttributes( { img_1: newContent } )
            // }
            // function remove_image_1() {
            //     props.setAttributes( { img_1: null } )
            // }
            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }

            function update_headline(event) {
                props.setAttributes({headline: event.target.value});
            }

            function update_sub_headline(event) {
                props.setAttributes({sub_headline: event.target.value});
            }

            function update_button_link(event) {
                props.setAttributes({button_link: event.target.value});
            }

            function update_button_text(event) {
                props.setAttributes({button_text: event.target.value});
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
                        )
                    ),

                    el("div", {
                            class: "granit-block image-block bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Honeycomb Block"),

                        el("dl", null,

                            el("div", null,
                                el("h3", null, "Headline (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.headline,
                                    placeholder: "Write here...",
                                    onChange: update_headline
                                }),

                                el("h3", null, "Sub Headline (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.sub_headline,
                                    placeholder: "Write here...",
                                    onChange: update_sub_headline
                                }),

                                el("h3", null, "Button Text (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.button_text,
                                    placeholder: "Write here...",
                                    onChange: update_button_text
                                }),

                                el("h3", null, "Button Link Link (optional)"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.button_link,
                                    placeholder: "Write here...",
                                    onChange: update_button_link
                                }),
                                // el("dt", null, "Image"),
                                // el("dd", null,
                                //
                                //     el(MediaUpload, {
                                //         onSelect: update_image_1,
                                //         accept: "image/*",
                                //         allowedTypes: 'image',
                                //         render: function render(_ref) {
                                //             var open = _ref.open;
                                //
                                //             return el("button", {
                                //                 className: "btn",
                                //                 icon: "edit",
                                //                 onClick: open
                                //             }, "Choose Image");
                                //         }}
                                //     ),
                                //     el("button",
                                //         {
                                //             class: "btn-remove-img " + image_not_present_1,
                                //             onClick: remove_image_1
                                //         },
                                //         "Delete Image"),
                                //     el("div", null,
                                //         props.attributes.img_1 && el("img", {
                                //             src: props.attributes.img_1["url"]
                                //         })
                                //     ),
                                // ),
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