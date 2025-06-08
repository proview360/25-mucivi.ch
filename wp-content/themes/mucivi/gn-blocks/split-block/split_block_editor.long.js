( function ( wp, blocks, element, data ) {
    
    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        RichText            = wp.blockEditor.RichText,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls,
        withSelect          = data.withSelect;
    
    registerBlockType( 'gn/split-block', {
        title: 'Split Block',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },
            layout: {
                type: 'string'
            },
            selectLayout: {
                type: 'string',
            },
            selectLayoutMobile: {
                type: 'string',
            },
            headline: {
                type: 'string'
            },
            subheadline: {
                type: 'string'
            },
            img: {
                type: 'object'
            },
            textHtml: {
                type: 'string'
            },
            textStyle: {
                type: 'string'
            },
            color: {
                type: 'string'
            },
            headline_color: {
                type: 'string'
            },
            count_buttons: {
                type: 'string'
            },
            post_id: {
                type: 'string'
            },
            
            
            link: {
                type: 'string',
            },
            btn_2_link: {
                type: 'string',
            },
            btn_3_link: {
                type: 'string',
            },
            
            linktype: {
                type: 'string',
            },
            btn_2_link_type: {
                type: 'string',
            },
            btn_3_link_type: {
                type: 'string',
            },
            
            text: {
                type: 'string'
            },
            btn_2_text: {
                type: 'string'
            },
            btn_3_text: {
                type: 'string'
            },
            
            btn_1_style: {
                type: 'string'
            },
            btn_2_style: {
                type: 'string'
            },
            btn_3_style: {
                type: 'string'
            },
     
            selectHeadlineType: {
                type: 'string',
            },
            selectHeadlineType2: {
                type: 'string',
            },
        },
        
        edit: withSelect( function ( select ) {
            
            var query = {
                orderby : 'title',
                order : 'asc',
                per_page: -1,
            }
            
            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'image-text', query ),
            };
        } )( function ( props ) {
            
            var image_not_present= "";
            
            if(!props.attributes.color)
            {
                props.setAttributes({color: "mucivi"})
            }
            if(!props.attributes.headline_color)
            {
                props.setAttributes({headline_color: "black"})
            }
            if(!props.attributes.layout)
            {
                props.setAttributes({layout: "boxed"})
            }
            if(!props.attributes.textStyle)
            {
                props.setAttributes({textStyle: "sRichText"})
            }
            if(!props.attributes.linktype)
            {
                props.setAttributes({linktype: "_self"})
            }
            if(!props.attributes.selectLayout)
            {
                props.setAttributes({selectLayout: "0"})
            }
            if(!props.attributes.count_buttons)
            {
                props.setAttributes({count_buttons: "1"})
            }
            if(!props.attributes.btn_1_style)
            {
                props.setAttributes({btn_1_style: "btn-full-secondary"})
            }
            if(!props.attributes.btn_2_style)
            {
                props.setAttributes({btn_2_style: "btn-full-secondary"})
            }
            if(!props.attributes.btn_3_style)
            {
                props.setAttributes({btn_3_style: "btn-full-secondary"})
            }
            if (!props.attributes.img)
            {
                image_not_present = "gn-image-not-present";
            }
            if (!props.attributes.selectHeadlineType)
            {
                props.setAttributes({selectHeadlineType: "span"})
            }
            
            if (!props.attributes.selectHeadlineType2)
            {
                props.setAttributes({selectHeadlineType2: "h2"})
            }
            
            var content = props.attributes.content;
            
            function updateLink( event ) {
                props.setAttributes( { link: event.target.value } );
            }
            function update_btn_2_link( event ) {
                props.setAttributes( { btn_2_link: event.target.value } );
            }
            function update_btn_3_link( event ) {
                props.setAttributes( { btn_3_link: event.target.value } );
            }
            
            function updateText( event ) {
                props.setAttributes( { text: event.target.value } );
            }
            function update_btn_2_text( event ) {
                props.setAttributes( { btn_2_text: event.target.value } );
            }
            function update_btn_3_text( event ) {
                props.setAttributes( { btn_3_text: event.target.value } );
            }
            
            function updateHeadline( event ) {
                props.setAttributes( { headline: event.target.value } );
            }
            function update_subheadline( event ) {
                props.setAttributes( { subheadline: event.target.value } );
            }
            function updateLayout (newValue) {
                props.setAttributes( {layout: newValue} )
            }
            function onChangeLayout (newValue) {
                props.setAttributes( { selectLayout: newValue } );
            }
            function on_change_count_buttons (newValue) {
                props.setAttributes( { count_buttons: newValue } );
            }
            function onChangeLayoutMobile (newValue) {
                props.setAttributes( { selectLayoutMobile: newValue } );
            }
            function changeContent (newContent) {
                props.setAttributes( { content: newContent } );
            }
            function update_image( newContent ) {
                props.setAttributes( { img: newContent } )
            }
            function updateTextHtml (event) {
                props.setAttributes( {textHtml: event.target.value} )
            }
            function updateTextStyle (newValue) {
                props.setAttributes( {textStyle: newValue} )
            }
            function onChangeColor (newValue) {
                props.setAttributes( { color: newValue } );
            }
            function on_change_headline_color (newValue) {
                props.setAttributes( { headline_color: newValue } );
            }
            
            function update_btn_1_link_type (newValue) {
                props.setAttributes( { linktype: newValue } )
            }
            function update_btn_2_link_type (newValue) {
                props.setAttributes( { btn_2_link_type: newValue } )
            }
            function update_btn_3_link_type (newValue) {
                props.setAttributes( { btn_3_link_type: newValue } )
            }
            
            function update_btn_1_style (newValue) {
                props.setAttributes( { btn_1_style: newValue } )
            }
            function update_btn_2_style (newValue) {
                props.setAttributes( { btn_2_style: newValue } )
            }
            function update_btn_3_style (newValue) {
                props.setAttributes( { btn_3_style: newValue } )
            }
            
            function remove_image() {
                props.setAttributes( { img: null } )
            }
            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }
            
            function onChangeSelectHeadlineType (newValue) {
                props.setAttributes( { selectHeadlineType: newValue } );
            }
            function onChangeSelectHeadlineType2 (newValue) {
                props.setAttributes( { selectHeadlineType2: newValue } );
            }
            
            var options = [];
            
            if( props.posts )
            {
                options.push( { value: 0, label: 'Auswählen...' } );
                
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
                    el(InspectorControls, {class: "gn-SelectControl"},
                        
                        el("div", { class: "gn-block-sidebar-element" },
                            
                            el("strong", null, "Top - Headline Typ"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.selectHeadlineType,
                                    options: [
                                        {
                                            value: 'p',
                                            label: 'P'
                                        },
                                        {
                                            value: 'span',
                                            label: 'SPAN'
                                        },
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
                                    ],
                                    onChange: onChangeSelectHeadlineType
                                }
                            ),
                            
                            el("strong", null, "Headline Typ"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.selectHeadlineType2,
                                    options: [
                                        {
                                            value: 'p',
                                            label: 'P'
                                        },
                                        {
                                            value: 'span',
                                            label: 'Span'
                                        },
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
                                    ],
                                    onChange: onChangeSelectHeadlineType2
                                }
                            ),
                            
                            
                            
                            
                            el("strong", null, "Layout"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.layout,
                                    options: [
                                        {
                                            value: 'boxed',
                                            label: 'Boxed'
                                        },
                                        {
                                            value: 'fullWidth',
                                            label: 'Full Width'
                                        }
                                    ],
                                    onChange: updateLayout
                                }
                            ),
                            
                            el("strong", null, "Description"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.selectLayout,
                                    options: [
                                        {
                                            value: '0',
                                            label: 'Text / Photo'
                                        },
                                        {
                                            value: '1',
                                            label: 'Photo / Text'
                                        }
                                    ],
                                    onChange: onChangeLayout
                                }
                            ),
                            
                            el("strong", { class: "mobile-option-" + props.attributes.selectLayout }, "Reihenfolge Mobil"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.selectLayoutMobile,
                                    options: [
                                        {
                                            value: '0',
                                            label: 'Text / Content'
                                        },
                                        {
                                            value: '1',
                                            label: 'Content / Text'
                                        }
                                    ],
                                    onChange: onChangeLayoutMobile
                                }
                            ),
                            
                            el("strong", null, "Number Buttons?"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.count_buttons,
                                    options: [
                                        {
                                            value: '1',
                                            label: '1'
                                        },
                                        {
                                            value: '2',
                                            label: '2'
                                        },
                                        {
                                            value: '3',
                                            label: '3'
                                        }
                                    ],
                                    onChange: on_change_count_buttons
                                }
                            ),
                            
                            el("strong", null, "Text Background"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.color,
                                    options: [
                                        {
                                            value: 'white',
                                            label: 'White'
                                        },
                                        {
                                            value: 'gray',
                                            label: 'Gray'
                                        },
                                        {
                                            value: 'mucivi',
                                            label: 'Mucivi'
                                        },
                                    ],
                                    onChange: onChangeColor
                                }
                            ),
                            
                            el("strong", null, "Headline Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.headline_color,
                                    options: [
                                        {
                                            value: 'black',
                                            label: 'black'
                                        },
                                        {
                                            value: 'orange',
                                            label: 'orange'
                                        },
                                        {
                                            value: 'white',
                                            label: 'white'
                                        },
                                    ],
                                    onChange: on_change_headline_color
                                }
                            ),
                            
                            el("strong", null, "Editor Typ"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.textStyle,
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
                                    onChange: updateTextStyle
                                }
                            ),
                        )
                    ),
                    
                    el("div", {class: "granit-block split-block layout-" + props.attributes.selectLayout +
                                " " + props.attributes.textStyle + " count-buttons-"+ props.attributes.count_buttons
                        },
                        el("h3", null, "Split Block"),
                        
                        el("dl", null,
                            
                            el("div", { class: "option-img"},
                                el("dt", null, "Photo"),
                                el("dd", null,
                                    el(MediaUpload, {
                                        onSelect: update_image,
                                        accept: "image/*",
                                        allowedTypes: 'image',
                                        render: function render(_ref) {
                                            var open = _ref.open;
                                            
                                            return el("button", {
                                                className: "btn",
                                                icon: "edit",
                                                onClick: open
                                            }, "Photo choose");
                                        }}
                                    ),
                                    el("button",
                                        {
                                            class: "btn-remove-img " + image_not_present,
                                            onClick: remove_image
                                        },
                                        "Photo remove")
                                ),
                                el("dd", null,
                                    props.attributes.img && el("img", {
                                        src: props.attributes.img["url"]
                                    })
                                ),
                            ),
                            
                            el("div", {class: "layout-text-" + props.attributes.selectLayout},
                                
                                el("dt", null,
                                    el("span", null, "Top Headline"),
                                    el("small", null, "(optional)")
                                ),
                                el("dd", null,
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.subheadline,
                                        placeholder: "Write here...",
                                        onChange: update_subheadline
                                    })
                                ),
                                
                                el("dt", null,
                                    el("span", null, "Text - Headline"),
                                    el("small", null, "(optional)")
                                ),
                                el("dd", null,
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.headline,
                                        placeholder: "Write here...",
                                        onChange: updateHeadline
                                    })
                                ),
                                
                                el("dt", { class: "TextRichText" },
                                    el("span", null, "Text"),
                                    el("small", null, "(optional)")),
                                el("dd", { class: "TextRichText" },
                                    el(RichText,
                                        {
                                            tagName: 'p',
                                            className: props.className,
                                            value: content,
                                            onChange: changeContent,
                                            placeholder: "Write here...",
                                        })
                                ),
                                
                                el("dt", { class: "TextHtml" },
                                    el("span", null, "HTML"),
                                    el("small", null, "(optional)")),
                                el("dd", { class: "TextHtml" },
                                    el("textarea", { placeholder: "Write here...", onChange: updateTextHtml }, props.attributes.textHtml )
                                ),
                                
                                el("dt", null, "Button #1"),
                                el("dd", { class: "button-1" },
                                    
                                    el("p", { class: "label-text" }, "Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.text,
                                        placeholder: "Write here...",
                                        onChange: updateText
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.link,
                                        placeholder: "Write here...",
                                        onChange: updateLink
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link Settings"),
                                    el(SelectControl, {
                                        value: props.attributes.linktype,
                                        options: [
                                            {
                                                value: '_self',
                                                label: 'self window'
                                            },
                                            {
                                                value: '_blank',
                                                label: 'new window'
                                            }
                                        ],
                                        onChange: update_btn_1_link_type,
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Style"),
                                    el(SelectControl, {
                                        value: props.attributes.btn_1_style,
                                        options: [
                                            {
                                                value: 'btn-full-primary',
                                                label: 'Button Primary'
                                            },
                                            {
                                                value: 'btn-full-secondary',
                                                label: 'Button Secondary'
                                            },
                                            {
                                                value: 'btn-outline',
                                                label: 'Button Outline'
                                            },
                                        ],
                                        onChange: update_btn_1_style,
                                    }),
       
                                ),
                                
                                el("dt", { class: "button-2" }, "Button #2"),
                                el("dd", { class: "button-2" },
                                    
                                    el("p", { class: "label-text" }, "Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.btn_2_text,
                                        placeholder: "Write here...",
                                        onChange: update_btn_2_text
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.btn_2_link,
                                        placeholder: "Write here...",
                                        onChange: update_btn_2_link
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link Settings"),
                                    el(SelectControl, {
                                        value: props.attributes.btn_2_link_type,
                                        options: [
                                            {
                                                value: '_self',
                                                label: 'self window'
                                            },
                                            {
                                                value: '_blank',
                                                label: 'new window'
                                            }
                                        ],
                                        onChange: update_btn_2_link_type,
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Style"),
                                    el(SelectControl, {
                                        value: props.attributes.btn_2_style,
                                        options: [
                                            {
                                                value: 'btn-full-primary',
                                                label: 'Button Primary'
                                            },
                                            {
                                                value: 'btn-full-secondary',
                                                label: 'Button Secondary'
                                            },
                                            {
                                                value: 'btn-outline',
                                                label: 'Button Outline'
                                            },
                                        ],
                                        onChange: update_btn_2_style,
                                    }),
                                    
                          
                                ),
                                
                                el("dt", { class: "button-3" }, "Button #3"),
                                el("dd", { class: "button-3" },
                                    
                                    el("p", { class: "label-text" }, "Text"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.btn_3_text,
                                        placeholder: "Write here...",
                                        onChange: update_btn_3_text
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link"),
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.btn_3_link,
                                        placeholder: "Write here...",
                                        onChange: update_btn_3_link
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Link Settings"),
                                    el(SelectControl, {
                                        value: props.attributes.btn_3_link_type,
                                        options: [
                                            {
                                                value: '_self',
                                                label: 'self window'
                                            },
                                            {
                                                value: '_blank',
                                                label: 'new window'
                                            }
                                        ],
                                        onChange: update_btn_3_link_type,
                                    }),
                                    
                                    el("p", { class: "label-text" }, "Button Style"),
                                    el(SelectControl, {
                                        value: props.attributes.btn_3_style,
                                        options: [
                                            {
                                                value: 'btn-full-primary',
                                                label: 'Button Primary'
                                            },
                                            {
                                                value: 'btn-full-secondary',
                                                label: 'Button Secondary'
                                            },
                                            {
                                                value: 'btn-outline',
                                                label: 'Button Outline'
                                            },
                                        ],
                                        onChange: update_btn_3_style,
                                    }),
                  
                                ),
                            
                            ),
                        ),
                    )
                )
            );
        }),
        
        //set save function
        save: function( props ) {
            
            return el( RichText.Content, {
                tagName: 'p', value: props.attributes.content
            } );
        }
        
    });
} )(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);