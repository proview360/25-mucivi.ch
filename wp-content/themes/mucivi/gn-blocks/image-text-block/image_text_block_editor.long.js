(function(blocks, element, data, editor, components, blockEditor) {

    //set vars
    var el                  = element.createElement,
        Fragment            = element.Fragment,
        RichText            = blockEditor.RichText,
        InspectorControls   = blockEditor.InspectorControls,
        MediaUpload         = blockEditor.MediaUpload,
        SelectControl       = components.SelectControl;

    //register block
    blocks.registerBlockType('gn/image-text-block', {

        //set basic info
        title: 'Image / Text Block',
        icon: 'format-quote',
        category: 'mucivi-blocks',
        description: '',
        example: {},

        //define required attributes
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },

            headline: {
                type: 'string'
            },

            headline_color: {
                type: 'string'
            },
            class_name: {
                type: 'string'
            },

            select_headline_type: {
                type: 'string',
            },
            text_style: {
                type: 'string'
            },
            text_html: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
            text_color: {
                type: 'string'
            },
            image_text_block: {
                type: 'object'
            },
            align_items: {
                type: 'string',
            },
            space_bottom: {
                type: 'string',
            },

            space_top: {
                type: 'string',
            }
        },

        //set edit function
        edit: function(props) {
            var image_not_present_1 = "";
            if (!props.attributes.image_text_block) {
                image_not_present_1 = "gn-image-not-present";
            }


            if(!props.attributes.space_top)
            {
                props.setAttributes({space_top: "yes"})
            }

            if(!props.attributes.align_items)
            {
                props.setAttributes({align_items: "start"})
            }

            if(!props.attributes.space_bottom)
            {
                props.setAttributes({space_bottom: "yes"})
            }

            if(!props.attributes.text_style)
            {
                props.setAttributes({text_style: "sRichText"})
            }

            if (!props.attributes.select_headline_color)
            {
                props.setAttributes({select_headline_color: "gn-font-color-black"})
            }

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }

            if(!props.attributes.text_color)
            {
                props.setAttributes({text_color: "black"})
            }


            var content = props.attributes.content;

            const space_bottom = [
                { value: 'yes', label: 'Yes' },
                { value: 'no', label: 'No' },
            ];

            const space_top = [
                { value: 'yes', label: 'Yes' },
                { value: 'no', label: 'No' },
            ];

            const align_items = [
                { value: 'end', label: 'Bottom' },
                { value: 'center', label: 'Center' },
                { value: 'start', label: 'top' },
            ];



            function on_change_content (newContent) {
                props.setAttributes( { content: newContent } );
            }


            function on_change_select_headline_type (newValue) {
                props.setAttributes( { select_headline_type: newValue } );
            }

            function update_content_headline (event) {
                props.setAttributes( {headline: event.target.value} )
            }

            function update_text_style (newValue) {
                props.setAttributes( {text_style: newValue} )
            }
            function update_text_html (event) {
                props.setAttributes( {text_html: event.target.value} )
            }

            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_text_color (newValue) {
                props.setAttributes( { text_color: newValue } );
            }

            function update_image_text_block(newContent) {
                props.setAttributes({image_text_block: newContent})
            }

            function remove_image_text_block() {
                props.setAttributes({image_text_block: null})
            }

            function update_space_bottom (newValue) {
                props.setAttributes( { space_bottom: newValue } )
            }

            function update_space_top (newValue) {
                props.setAttributes( { space_top: newValue } )
            }

            function update_align_items (newValue) {
                props.setAttributes( { align_items: newValue } )
            }



            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},

                        el("div", { class: "granit-block-sidebar-element" },

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
                                        }
                                    ],
                                    onChange: on_change_select_headline_type
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

                            el("strong", null, "Text Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.text_color,
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
                                    onChange: update_text_color
                                }
                            ),

                            el("strong", null, "Editor Type"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.text_style,
                                    options: [
                                        {
                                            value: 'sRichText',
                                            label: 'RichText'
                                        },
                                        {
                                            value: 'sHtml',
                                            label: 'HTML'
                                        }
                                    ],
                                    onChange: update_text_style
                                }
                            ),

                            el("dt", null, "Space Top"),
                            el(SelectControl, {
                                value: props.attributes.space_top,
                                options: space_top,
                                onChange: update_space_top
                            }),

                            el("dt", null, "Space Bottom"),
                            el(SelectControl, {
                                value: props.attributes.space_bottom,
                                options: space_bottom,
                                onChange: update_space_bottom
                            }),

                            el("dt", null, "Align Items"),
                            el(SelectControl, {
                                value: props.attributes.align_items,
                                options: align_items,
                                onChange: update_align_items
                            }),

                        ),
                    ),

                    el("div", {
                            id: "text-block",
                            class: "granit-block " + props.attributes.text_style + " text-color-" +props.attributes.text_color  + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Image / Text"),

                        el("dl", null,

                            el("dt", null,
                                el("span", null, "Headline"),
                                el("small", null, "(optional)")
                            ),

                                el("dd", null,
                                    el("input", {
                                            type: "text",
                                            value: props.attributes.headline,
                                            placeholder: "Write here...",
                                            onChange: update_content_headline
                                        }
                                    )
                                ),




                                props.attributes.text_style == 'sRichText' ?
                                    el("div", {},

                                            el("dt", { class: "TextRichText" }, "Text"),
                                            el("dd", { class: "TextRichText" },
                                                el(RichText,
                                                    {
                                                        tagName: 'p',
                                                        class_name: props.class_name,
                                                        value: content,
                                                        onChange: on_change_content,
                                                        placeholder: "Write here...",
                                                    })
                                            )
                                    ): null,

                                props.attributes.text_style == 'sHtml' ?
                                    el("div", {},
                                        el("dt", {class: "text_html"}, "HTML"),
                                            el("dd", {class: "text_html"},
                                                el("textarea", {
                                                    placeholder: "Write here...",
                                                    onChange: update_text_html
                                                }, props.attributes.text_html)
                                            )
                                    ) : null,


                            el("div", {},
                                el("dt", {class: "ele-1"}, "Image"),
                                el("dd", {class: "ele-1"},
                                    el(MediaUpload, {
                                        onSelect: update_image_text_block,
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
                                            onClick: remove_image_text_block
                                        },
                                        "Remove Image"),
                                    el("div", null,
                                        props.attributes.image_text_block && el("img", {
                                            src: props.attributes.image_text_block["url"]
                                        })
                                    )
                                )
                            ),


                        )
                    )
                )
            );
        },

        //set save function
        save: function(props) {

            return el( RichText.Content, {
                tagName: 'p', value: props.attributes.content
            } );
        }
    })
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.editor,
    window.wp.components,
    window.wp.blockEditor
));