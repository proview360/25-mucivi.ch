( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        TextControl         = wp.components.TextControl,
        InspectorControls   = wp.blockEditor.InspectorControls,
        PanelBody           = wp.components.PanelBody;

    registerBlockType( 'gn/hero-section-block', {
        title: 'Hero Section Block',
        icon: 'ellipsis',
        category: 'mucivi-blocks',
        description: "hero section",
        example: {},

        attributes: {
            number: {
                type: 'string'

            },
            hero_headline: {
                type: 'string'
            },
            hero_description: {
                type: 'string'
            },
            hero_button_text: {
                type: 'string'
            },
            hero_button_link: {
                type: 'string'
            },
            hero_button_text_2: {
                type: 'string'
            },
            hero_button_link_2: {
                type: 'string'
            },
            hero_button_text_3: {
                type: 'string'
            },
            hero_button_link_3: {
                type: 'string'
            },
            hero_button_text_4: {
                type: 'string'
            },
            hero_button_link_4: {
                type: 'string'
            },
            hero_button_text_5: {
                type: 'string'
            },
            hero_button_link_5: {
                type: 'string'
            },
            hero_button_text_6: {
                type: 'string'
            },
            hero_button_link_6: {
                type: 'string'
            },
            hero_image: {
                type: 'object'
            },
            hero_background_image: {
                type: 'object'
            },
            hero_section_layout_type: {
                type: 'string'
            },
            hero_section_image_position: {
                type: 'string'
            },
            hero_section_align_content: {
                type: 'string'
            },
            overlay: {
                type: 'string'
            },
            overlay_picture: {
                type: 'string'
            },
            banner_text_color: {
                type: 'string'
            },
            banner_background_color: {
                type: 'string'
            },
        },

        edit: ( function ( props ) {

            var image_not_present_1= "",
                image_not_present_2= "";

            if(!props.attributes.hero_section_layout_type)
            {
                props.setAttributes({hero_section_layout_type: "hero-section-banner-1"})
            }

            if(!props.attributes.hero_section_image_position)
            {
                props.setAttributes({hero_section_image_position: "fixed"})
            }

            if(!props.attributes.hero_section_align_content)
            {
                props.setAttributes({hero_section_align_content: "left"})
            }
            
            if(!props.attributes.overlay)
            {
                props.setAttributes({overlay: "no"})
            }
          
            if(!props.attributes.overlay_picture)
            {
                props.setAttributes({overlay_picture: "no"})
            }

            if (!props.attributes.hero_background_image)
            {
                image_not_present_1 = "gn-image-not-present";
            }
            if (!props.attributes.hero_image)
            {
                image_not_present_2 = "gn-image-not-present";
            }

            function update_hero_headline( event ) {
                props.setAttributes( { hero_headline: event.target.value } );
            }

            function update_hero_description( event ) {
                props.setAttributes( { hero_description: event.target.value } );
            }
            function update_hero_button_text( event ) {
                props.setAttributes( { hero_button_text: event.target.value } );
            }

            function update_hero_button_link( event ) {
                props.setAttributes( { hero_button_link: event.target.value } );
            }
      
            function update_hero_button_text_2(event) {
                props.setAttributes({ hero_button_text_2: event.target.value });
            }
            
            function update_hero_button_link_2(event) {
                props.setAttributes({ hero_button_link_2: event.target.value });
            }
            
            function update_hero_button_text_3(event) {
                props.setAttributes({ hero_button_text_3: event.target.value });
            }
            
            function update_hero_button_link_3(event) {
                props.setAttributes({ hero_button_link_3: event.target.value });
            }
            
            function update_hero_button_text_4(event) {
                props.setAttributes({ hero_button_text_4: event.target.value });
            }
            
            function update_hero_button_link_4(event) {
                props.setAttributes({ hero_button_link_4: event.target.value });
            }
            
            function update_hero_button_text_5(event) {
                props.setAttributes({ hero_button_text_5: event.target.value });
            }
            
            function update_hero_button_link_5(event) {
                props.setAttributes({ hero_button_link_5: event.target.value });
            }
            
            function update_hero_button_text_6(event) {
                props.setAttributes({ hero_button_text_6: event.target.value });
            }
            
            function update_hero_button_link_6(event) {
                props.setAttributes({ hero_button_link_6: event.target.value });
            }
            
            
            function update_hero_background_image( newContent ) {
                props.setAttributes( { hero_background_image: newContent } )
            }
            function remove_hero_background_image() {
                props.setAttributes( { hero_background_image: null } )
            }
            function update_hero_image( newContent ) {
                props.setAttributes( { hero_image: newContent } )
            }
            function remove_hero_image() {
                props.setAttributes( { hero_image: null } )
            }
            function update_hero_section_layout_type (newValue) {
                props.setAttributes( {hero_section_layout_type: newValue} )
            }

            function update_hero_section_image_poistion (newValue) {
                props.setAttributes( {hero_section_image_position: newValue} )
            }

            function update_hero_section_align_content (newValue) {
                props.setAttributes( {hero_section_align_content: newValue} )
            }
            function update_overlay (newValue) {
                props.setAttributes( {overlay: newValue} )
            }
            
            function update_overlay_picture (newValue) {
                props.setAttributes( {overlay_picture: newValue} )
            }

            function update_banner_text_color (event) {
                props.setAttributes( {banner_text_color: event.target.value} )
            }
            function update_banner_background_color(event) {
                props.setAttributes({ banner_background_color: event.target.value });
            }



            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},

                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Section Layout"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.hero_section_layout_type,
                                    options: [
                                        {
                                            value: 'hero-section-banner-1',
                                            label: 'Hero Section Banner type 1'
                                        },
                                        {
                                            value: 'hero-section-banner-2',
                                            label: 'Hero Section Banner type 2'
                                        }
                                    ],
                                    onChange: update_hero_section_layout_type
                                }
                            ),
                        ),

                        props.attributes.hero_section_layout_type !== 'hero-section-banner-2' ?
                            (
                                el("div",
                                    {
                                        class: "granit-block-sidebar-element"
                                    },
                                    el("strong", null, "Image Background Position"),
                                    el(SelectControl,
                                        {
                                            label: '',
                                            value: props.attributes.hero_section_image_position,
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
                                            onChange: update_hero_section_image_poistion
                                        }
                                    ),
                                )
                            ) : null,

                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                            el("strong", null, "Align Content"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.hero_section_align_content,
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
                                    onChange: update_hero_section_align_content
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


                    ),

                    el("div", {
                            class: "granit-block hero-section-block " + props.attributes.hero_section_layout_type + " text-" + props.attributes.banner_text_color + " bg-" + props.attributes.banner_background_color
                        },
                        el("h3", null, "Hero Section"),

                        el("dl", null,

                            el("div", null,
                                props.attributes.hero_section_layout_type !== 'hero-section-banner-2' ?
                                    (
                                        el("dt", { class: "ele-1" }, "Background Image"),
                                            el("dd", { class: "ele-1" },
                                                el(MediaUpload, {
                                                    onSelect: update_hero_background_image,
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
                                                        onClick: remove_hero_background_image
                                                    },
                                                    "Remove Image"),
                                                el("div", null,
                                                    props.attributes.hero_background_image && el("img", {
                                                        src: props.attributes.hero_background_image["url"]
                                                    })
                                                )
                                            )
                                    ) : null,


                                el("dd", { class: "ele-2" },


                                    el("p", { class: "label-text" }, "Headline"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_headline,
                                        placeholder: "Write here...",
                                        onChange: update_hero_headline
                                    }),

                                    el("p", { class: "label-text" }, "Description"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_description,
                                        placeholder: "Write here...",
                                        onChange: update_hero_description
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text
                                    }),

                                    el("p", { class: "label-text" }, "Button Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text 2"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text_2,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text_2
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Link 2"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link_2,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link_2
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text 3"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text_3,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text_3
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Link 3"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link_3,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link_3
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text 4"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text_4,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text_4
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Link 4"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link_4,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link_4
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text 5"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text_5,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text_5
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Link 5"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link_5,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link_5
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),
                                    
                                    el("p", { class: "label-text" }, "Button Text 6"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_text_6,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_text_6
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Link 6"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.hero_button_link_6,
                                        placeholder: "Write here...",
                                        onChange: update_hero_button_link_6
                                    }),
                                    el("hr", { style: { borderColor: "red" } }),

                                    el("div", {},
                                            el("p", { class: "label-text" }, "Text Color "),
                                            el("select", {
                                                    value: props.attributes.banner_text_color,
                                                    onChange: update_banner_text_color
                                                },
                                                el('option', {value: '--mucivi-white'}, 'White'),
                                                el('option', {value: '--mucivi-extra-light-gray'}, 'Gray'),
                                                el('option', {value: '--mucivi-black'}, 'Black'),
                                                el('option', {value: '--mucivi-primary'}, 'Red'),
                                            )
                                    ),


                                    props.attributes.hero_section_layout_type === 'hero-section-banner-2' ?
                                        el("div", {},
                                            el("p", { class: "label-text" }, "Background Color "),
                                            el("select", {
                                                    value: props.attributes.banner_background_color,
                                                    onChange: update_banner_background_color
                                                },
                                                el('option',
                                                    {
                                                        value: '--mucivi-white',
                                                        selected: props.attributes.banner_background_color === 'white'
                                                    },
                                                    'White'
                                                ),
                                                el('option',
                                                    {
                                                        value: '--mucivi-extra-light-gray',
                                                        selected: props.attributes.banner_background_color === 'gray'
                                                    },
                                                    'Gray'
                                                ),
                                                el('option',
                                                    {
                                                        value: '--mucivi-black',
                                                        selected: props.attributes.banner_background_color === 'black'
                                                    },
                                                    'Black'
                                                ),
                                                el('option',
                                                    {
                                                        value: '--mucivi-primary',
                                                        selected: props.attributes.banner_background_color === 'red'
                                                    },
                                                    'Red'
                                                ),
                                            )
                                        ) : null,

                                ),

                                        el("dd", { class: "ele-3" },
                                            el("p", { class: "label-text" }, "Image"),
                                            el(MediaUpload, {
                                                onSelect: update_hero_image,
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
                                                    class: "btn-remove-img " + image_not_present_2,
                                                    onClick: remove_hero_image
                                                },
                                                "Remove Image"),
                                            el("div", null,
                                                props.attributes.hero_image && el("img", {
                                                    src: props.attributes.hero_image["url"]
                                                })
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