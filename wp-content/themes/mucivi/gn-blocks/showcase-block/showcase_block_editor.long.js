(function (wp, blocks, element, data) {

    var el = element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = blocks.registerBlockType,
        MediaUpload = wp.blockEditor.MediaUpload,
        SelectControl = wp.components.SelectControl,
        InspectorControls = wp.blockEditor.InspectorControls;

    registerBlockType('gn/showcase-block', {
        title: 'Showcase Block',
        icon: 'cover-image',
        category: 'mucivi-blocks',
        description: "Showcase",
        example: {},

        attributes: {
            number: {
                type: 'string'
            },
            showcase_background_image: {
                type: 'object'
            },

            showcase_headline: {
                type: 'string'
            },
            showcase_description: {
                type: 'string'
            },

            showcase_button_text: {
                type: 'string'
            },
            showcase_button_link: {
                type: 'string'
            },

            show_case_button: {
                type: 'string'
            },

            showcase_image: {
                type: 'object'
            },

            showcase_section_image_position: {
                type: 'string'
            },
            showcase_section_align_content: {
                type: 'string'
            },
            banner_text_color: {
                type: 'string'
            },
            banner_background_color: {
                type: 'string'
            },
            overlay: {
                type: 'string'
            },
            overlay_picture: {
                type: 'string'
            },
            select_headline_type: {
                type: 'string',
            },
        },

        edit: (function (props) {

            var image_not_present_1 = "",
                image_not_present_2 = "";


            if (!props.attributes.showcase_section_image_position) {
                props.setAttributes({showcase_section_image_position: "fixed"})
            }

            if (!props.attributes.showcase_section_align_content) {
                props.setAttributes({showcase_section_align_content: "left"})
            }

            if (!props.attributes.showcase_background_image) {
                image_not_present_1 = "gn-image-not-present";
            }
            if (!props.attributes.showcase_image) {
                image_not_present_2 = "gn-image-not-present";
            }
            
            if(!props.attributes.overlay)
            {
                props.setAttributes({overlay: "no"})
            }
            
            if(!props.attributes.overlay_picture)
            {
                props.setAttributes({overlay_picture: "no"})
            }
            
            
            function update_showcase_headline(event) {
                props.setAttributes({showcase_headline: event.target.value});
            }

            function update_showcase_description(event) {
                props.setAttributes({showcase_description: event.target.value});
            }

            function update_showcase_button_text(event) {
                props.setAttributes({showcase_button_text: event.target.value});
            }

            function update_showcase_button_link(event) {
                props.setAttributes({showcase_button_link: event.target.value});
            }

            function update_show_case_button(event) {
                props.setAttributes({show_case_button: event.target.value});
            }

            function update_showcase_background_image(newContent) {
                props.setAttributes({showcase_background_image: newContent})
            }

            function remove_showcase_background_image() {
                props.setAttributes({showcase_background_image: null})
            }

            function update_showcase_image(newContent) {
                props.setAttributes({showcase_image: newContent})
            }

            function remove_showcase_image() {
                props.setAttributes({showcase_image: null})
            }

            function update_showcase_section_image_poistion(newValue) {
                props.setAttributes({showcase_section_image_position: newValue})
            }

            function update_showcase_section_align_content(newValue) {
                props.setAttributes({showcase_section_align_content: newValue})
            }

            function update_banner_text_color(event) {
                props.setAttributes({banner_text_color: event.target.value})
            }

            function update_banner_background_color(event) {
                props.setAttributes({banner_background_color: event.target.value});
            }
            function update_overlay (newValue) {
                props.setAttributes( {overlay: newValue} )
            }
            
            function update_overlay_picture (newValue) {
                props.setAttributes( {overlay_picture: newValue} )
            }
            function on_change_select_headline_type (newValue) {
                props.setAttributes( { select_headline_type: newValue } );
            }
            

            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Image Background Position"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.showcase_section_image_position,
                                    options: [
                                        {
                                            value: 'fixed',
                                            label: 'Fixed'
                                        },
                                        {
                                            value: 'scroll',
                                            label: 'Static'
                                        }
                                    ],
                                    onChange: update_showcase_section_image_poistion
                                }
                            ),
                        ),
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Align Content"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.showcase_section_align_content,
                                    options: [
                                        {
                                            value: 'center',
                                            label: 'Center'
                                        },
                                        {
                                            value: 'start',
                                            label: 'Left'
                                        },
                                        {
                                            value: 'end',
                                            label: 'Right'
                                        }
                                    ],
                                    onChange: update_showcase_section_align_content
                                }
                            ),
                        ),
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Overlay Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.overlay,
                                    options: [
                                        {
                                            value: 'yez',
                                            label: 'Yes'
                                        },
                                        {
                                            value: 'no',
                                            label: 'No'
                                        },
                                    ],
                                    onChange: update_overlay
                                }
                            ),
                        ),
                        
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Overlay Picture"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.overlay_picture,
                                    options: [
                                        {
                                            value: 'yez',
                                            label: 'Yes'
                                        },
                                        {
                                            value: 'no',
                                            label: 'No'
                                        },
                                    ],
                                    onChange: update_overlay_picture
                                }
                            ),
                        ),
                        
                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                        el("strong", null, "Headline Type"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.select_headline_type,
                                    options: [
                                        {
                                            value: 'h1',
                                            label: 'H1'
                                        },
                                        {
                                            value: 'h2',
                                            label: 'H2'
                                        },
                                        {
                                            value: 'h3',
                                            label: 'H3'
                                        },
                                        {
                                            value: 'h4',
                                            label: 'H4'
                                        },
                                        {
                                            value: 'h5',
                                            label: 'H5'
                                        },
                                        {
                                            value: 'h6',
                                            label: 'H6'
                                        },
                                        {
                                            value: 'p',
                                            label: 'P'
                                        }
                                    
                                    ],
                                    onChange: on_change_select_headline_type
                                }
                            ),
                        ),
                    ),

                    el("div", {
                            class: "granit-block showcase-section-block"
                        },
                        el("h3", null, "Showcase Block"),

                        el("dl", null,

                            el("div", null,
                                el("dt", {class: "ele-1"}, "Background Image"),
                                el("dd", {class: "ele-1"},
                                    el(MediaUpload, {
                                        onSelect: update_showcase_background_image,
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
                                            class: "btn-remove-img " + image_not_present_1,
                                            onClick: remove_showcase_background_image
                                        },
                                        "Remove Image"),
                                    el("div", null,
                                        props.attributes.showcase_background_image && el("img", {
                                            src: props.attributes.showcase_background_image["url"]
                                        })
                                    )
                                ),


                                el("dd", {class: "ele-2"},

                                    el("p", {class: "label-text"}, "Headline"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.showcase_headline,
                                        placeholder: "Write here...",
                                        onChange: update_showcase_headline
                                    }),

                                    el("p", {class: "label-text"}, "Description"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.showcase_description,
                                        placeholder: "Write here...",
                                        onChange: update_showcase_description
                                    }),

                                    el("p", {class: "label-text"}, "Button Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.showcase_button_text,
                                        placeholder: "Write here...",
                                        onChange: update_showcase_button_text
                                    }),

                                    el("p", {class: "label-text"}, "Button Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.showcase_button_link,
                                        placeholder: "Write here...",
                                        onChange: update_showcase_button_link
                                    }),

                                    el("div", {},
                                        el("p", {class: "label-text"}, "Button Color "),
                                        el("select", {
                                                value: props.attributes.show_case_button,
                                                onChange: update_show_case_button
                                            },
                                            
                                            el('option', {value: 'btn-full-primary'}, 'Button Primary'),
                                            el('option', {value: 'btn-full-secondary'}, 'Button Secondary'),
                                            el('option', {value: 'btn-outline'}, 'Button Outline'),
                                        )
                                    ),

                                    el("div", {},
                                        el("p", {class: "label-text"}, "Text Content Color "),
                                        el("select", {
                                                value: props.attributes.banner_text_color,
                                                onChange: update_banner_text_color
                                            },
                                            el('option', {value: '--mucivi-white'}, 'White'),
                                            el('option', {value: '--mucivi-black'}, 'Black'),
                                            el('option', {value: '--mucivi-primary'}, 'Primary'),
                                            el('option', {value: '--mucivi-secondary'}, 'Secondary'),
                                        )
                                    ),
                                    
                            
                                ),
                            ),
                        ),
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