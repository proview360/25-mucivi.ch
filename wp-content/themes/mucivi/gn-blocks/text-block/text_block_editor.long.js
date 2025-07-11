(function(blocks, element, data, editor, components, blockEditor) {

    //set vars
    var el                  = element.createElement,
        Fragment            = element.Fragment,
        RichText            = blockEditor.RichText,
        InspectorControls   = blockEditor.InspectorControls,
        withSelect          = data.withSelect,
        SelectControl       = components.SelectControl;
    
    var blockAttributes = {
        post_id: { type: 'string' },
        content: { type: 'string', source: 'html', selector: 'p' },
        headline: { type: 'string' },
        side_bar_title: {type: 'string'},
        sub_headline: { type: 'string' },
        headline_color: { type: 'string' },
        class_name: { type: 'string' },
        select_field: { type: 'string' },
        select_headline_type: { type: 'string' },
        select_headline_style: { type: 'string' },
        select_sub_headline_type: { type: 'string' },
        text_select_field: { type: 'string' },
        text_style: { type: 'string' },
        side_bar_enable: { type: 'string' },
        text_html: { type: 'string' },
        two_columns: { type: 'string' },
        background_color: { type: 'string' },
        text_color: { type: 'string' },
        space_bottom: { type: 'string' },
        space_top: { type: 'string' },
        margin_top: { type: 'string' }
    };
    

    //register block
    blocks.registerBlockType('gn/text-block', {

        //set basic info
 
        title: 'Text Block',
        icon: 'format-quote',
        category: 'mucivi-blocks',
        description: '',
        example: {},

        //define required attributes
        attributes: blockAttributes,
        
        edit: withSelect( function ( select ) {
            
            var query = {
                orderby : 'title',
                order : 'asc',
                per_page: -1,
            }
            
            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'links', query ),
            };
        } )( function ( props ) {

            if(!props.attributes.space_top)
            {
                props.setAttributes({space_top: "yes"})
            }

            if(!props.attributes.space_bottom)
            {
                props.setAttributes({space_bottom: "yes"})
            }

            if(!props.attributes.text_style)
            {
                props.setAttributes({text_style: "sRichText"})
            }
            
            if(!props.attributes.side_bar_enable)
            {
                props.setAttributes({side_bar_enable: "no"})
            }

            if (!props.attributes.two_columns)
            {
                props.setAttributes({two_columns: "0"})
            }




            if (!props.attributes.select_headline_color)
            {
                props.setAttributes({select_headline_color: "gn-font-color-black"})
            }

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "white"})
            }

            if(!props.attributes.text_color)
            {
                props.setAttributes({text_color: "black"})
            }



            var content = props.attributes.content,
                select_field = props.attributes.select_field,
                text_select_field = props.attributes.text_select_field;

            const space_bottom = [
                { value: 'yes', label: 'Yes' },
                { value: 'no', label: 'No' },
            ];

            const space_top = [
                { value: 'yes', label: 'Yes' },
                { value: 'no', label: 'No' },
            ];

            function on_change_content (newContent) {
                props.setAttributes( { content: newContent } );
            }

            function on_change_select_field (newValue) {
                props.setAttributes( { select_field: newValue } );
            }
            function on_change_select_headline_type (newValue) {
                props.setAttributes( { select_headline_type: newValue } );
            }

            function on_change_select_headline_style (newValue) {
                props.setAttributes( { select_headline_style: newValue } );
            }

            function on_change_select_sub_headline_type (newValue) {
                props.setAttributes( { select_sub_headline_type: newValue } );
            }


            function on_change_text_select_field (newValue) {
                props.setAttributes( { text_select_field: newValue } );
                props.setAttributes( { class_name: newValue } );
            }
            function update_content_headline (event) {
                props.setAttributes( {headline: event.target.value} )
            }
            
            
            function update_side_bar_title (event) {
                props.setAttributes( {side_bar_title: event.target.value} )
            }
            
            

            function update_margin_top(event) {
                props.setAttributes( {margin_top: event.target.value} )
            }


            function update_content_sub_headline (event) {
                props.setAttributes( {sub_headline: event.target.value} )
            }
            function update_text_style (newValue) {
                props.setAttributes( {text_style: newValue} )
            }
            
            function update_side_bar_enable (newValue) {
                props.setAttributes( {side_bar_enable: newValue} )
            }
            
            
            function update_text_html (event) {
                props.setAttributes( {text_html: event.target.value} )
            }

            function update_content_two_columns( newContent ) {
                props.setAttributes( { two_columns: newContent } )
            }


            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_text_color (newValue) {
                props.setAttributes( { text_color: newValue } );
            }

            function update_space_bottom (newValue) {
                props.setAttributes( { space_bottom: newValue } )
            }

            function update_space_top (newValue) {
                props.setAttributes( { space_top: newValue } )
            }
            
            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }
            
            var options = [];
            
            if( props.posts )
            {
                options.push( { value: 0, label: 'Choose...' } );
                
                props.posts.forEach((post) => {
                    
                    options.push({value:post.id, label:post.title.raw });
                });
            }
            else
            {
                options.push( { value: 0, label: 'Lade...' } )
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
                                        },
                                        {
                                            value: 'p',
                                            label: 'P'
                                        }

                                    ],
                                    onChange: on_change_select_headline_type
                                }
                            ),


                            el("strong", null, "Headline Style"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.select_headline_style,
                                    options: [
                                        {
                                            value: 'style_1',
                                            label: 'Style 1'
                                        },
                                        {
                                            value: 'style_2',
                                            label: 'Style 2'
                                        },

                                    ],
                                    onChange: on_change_select_headline_style
                                }
                            ),


                            el("strong", null, "Sub Headline Type"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.select_sub_headline_type,
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
                                    onChange: on_change_select_sub_headline_type
                                }
                            ),

                            el("strong", null, "Headline Alignment"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: select_field,
                                    options: [
                                        {
                                            value: 'left',
                                            label: 'Left'
                                        },
                                        {
                                            value: 'right',
                                            label: 'Right'
                                        },
                                        {
                                            value: 'center',
                                            label: 'Center'
                                        },
                                        {
                                            value: 'justify',
                                            label: 'Justify'
                                        }
                                    ],
                                    onChange: on_change_select_field
                                }
                            ),

                            el("strong", null, "Text Alignment"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: text_select_field,
                                    options: [
                                        {
                                            value: 'left',
                                            label: 'Left'
                                        },
                                        {
                                            value: 'right',
                                            label: 'Right'
                                        },
                                        {
                                            value: 'center',
                                            label: 'Center'
                                        },
                                        {
                                            value: 'justify',
                                            label: 'Justify'
                                        }
                                    ],
                                    onChange: on_change_text_select_field
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
                            
                            

                            el("strong", null, "Text Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.text_color,
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
                                    onChange: update_text_color
                                }
                            ),


                            el("strong", null, "Content two columns"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.two_columns,
                                    options: [
                                        {
                                            value: '0',
                                            label: 'No'
                                        },
                                        {
                                            value: '1',
                                            label: 'Yes'
                                        }
                                    ],
                                    onChange: update_content_two_columns
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
                            
                            el("dt", null, "Sidebar enable"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.side_bar_enable,
                                    options: [
                                        {
                                            value: 'no',
                                            label: 'No'
                                        },
                                        {
                                            value: 'yes',
                                            label: 'Yes'
                                        }
                                    ],
                                    onChange: update_side_bar_enable
                                }
                            ),
     
                            
       
                        ),
                    ),

                    el("div", {
                            id: "text-block",
                            class: "granit-block " + props.attributes.text_style + " text-color-" +props.attributes.text_color  + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Text-block"),

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

                            el("dt", null,
                                el("span", null, "Sub Headline"),
                                el("small", null, "(optional)")
                            ),

                            el("dd", null,
                                el("input", {
                                        type: "text",
                                        value: props.attributes.sub_headline,
                                        placeholder: "Write here...",
                                        onChange: update_content_sub_headline
                                    }
                                )
                            ),
    
                            el("dt", null,
                                el("span", null, "Content Margin Top"),
                                el("small", null, "(optional)")
                            ),

                            el("dd", null,
                                el("input", {
                                        type: "text",
                                        value: props.attributes.margin_top,
                                        placeholder: "20",
                                        onChange: update_margin_top
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
                            
                            
                            props.attributes.side_bar_enable === 'yes' && (() => {
                                return el(
                                    "dl", null,
                                    el("dt", null, "Side Bar Title"),
                                    el("input", {
                                        key: "input",
                                        type: "text",
                                        value: props.attributes.side_bar_title,
                                        placeholder: "Write here...",
                                        onChange: update_side_bar_title
                                    }),
                                    el(
                                        "div", null,
                                        el("dt", null, "Links choose"),
                                        el("dd", null,
                                            el(SelectControl, {
                                                value: props.attributes.post_id,
                                                options: options,
                                                onChange: on_change_post,
                                            })
                                        )
                                    ),
                                );
                            })()
                            
                        )
                    )
                )
            );
        }),

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