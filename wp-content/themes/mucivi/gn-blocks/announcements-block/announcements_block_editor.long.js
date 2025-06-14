( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        Fragment            = wp.element.Fragment,
        InspectorControls   = wp.blockEditor.InspectorControls;
    
    
    var blockAttributes = {
        post_id: { type: 'string' },
        number_of_link: {type: 'string'},
        side_bar_title: {type: 'string'},
        side_bar_enable: { type: 'string' },
        headline: { type: 'string' },
        background_color: { type: 'string' },
    };
    
    // Auto-generate dynamic button attributes
    for (let i = 1; i <= 10; i++) {
        blockAttributes[`button_${i}_name`] = { type: 'string' };
        blockAttributes[`button_${i}_link`] = { type: 'string' };
    }
    
    registerBlockType( 'gn/announcements-block', {
        title: 'Announcements Block',
        icon: 'megaphone',
        category: 'mucivi-blocks',
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
                posts: select( 'core' ).getEntityRecords( 'postType', 'announcements', query ),
            };
        } )( function ( props ) {


            if (!props.attributes.background_color)
            {
                props.setAttributes({background_color: "white"})
            }
            
            if(!props.attributes.side_bar_enable)
            {
                props.setAttributes({side_bar_enable: "no"})
            }
            
            
            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }
            function update_side_bar_enable( newContent ) {
                props.setAttributes( { side_bar_enable: newContent } )
            }
            function update_number_of_link (event) {
                props.setAttributes( {number_of_link: event.target.value} )
            }
            
            function update_side_bar_title (event) {
                props.setAttributes( {side_bar_title: event.target.value} )
            }
            
            function update_background_color( newContent ) {
                props.setAttributes( { background_color: newContent } )
            }
            function update_headline(event) {
                props.setAttributes({headline: event.target.value});
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

                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
                    
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
                                            label: 'primary '
                                        },
                                        {
                                            value: 'secondary',
                                            label: 'Secondary'
                                        }
                                    ],
                                    onChange: update_background_color
                                }
                            ),
                            
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
                            
                            props.attributes.side_bar_enable === 'yes' && [
                                el("strong", null, "Number of links"),
                                el("input", {
                                    key: "input",
                                    type: "text",
                                    value: props.attributes.number_of_link,
                                    placeholder: "Write here...",
                                    onChange: update_number_of_link
                                })
                            ],
                            el("br"),
                            props.attributes.side_bar_enable === 'yes' && [
                                el("strong", null, "Side Bar Title"),
                                el("input", {
                                    key: "input",
                                    type: "text",
                                    value: props.attributes.side_bar_title,
                                    placeholder: "Write here...",
                                    onChange: update_side_bar_title
                                })
                            ],

        
                        )
                    ),

                    el("div", {
                            class: "granit-block worker-block count-"+ props.attributes.number + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Announcements-Block"),

                        el("dt", null,
                            el("span", null, "Headline"),
                            el("small", null, "(optional)")
                        ),
                        el("dd", null,
                            el("input", {
                                type: "text",
                                value: props.attributes.headline,
                                placeholder: "Hier schreiben...",
                                onChange: update_headline
                            })
                        ),

                        el("dl", null,

                            el("div", null,

                                el("dt", null, "Announcements choose"),
                                el("dd", null,
                                    el(SelectControl, {
                                        value: props.attributes.post_id,
                                        options: options,
                                        onChange: on_change_post,
                                    })
                                ),
                            ),
                        ),
                        
                        props.attributes.side_bar_enable === 'yes' && (() => {
                            const numberOfLinks = parseInt(props.attributes.number_of_link || "0");
                            const fields = [];
                            
                            for (let i = 1; i <= numberOfLinks; i++) {
                                fields.push(
                                    el("dt", { key: `btn${i}-label` },
                                        el("span", null, `Button ${i} name`)
                                    ),
                                    el("dd", { key: `btn${i}-name` },
                                        el("input", {
                                            type: "text",
                                            value: props.attributes[`button_${i}_name`] || "",
                                            placeholder: `Button ${i} name...`,
                                            onChange: (e) => {
                                                const newAttrs = {};
                                                newAttrs[`button_${i}_name`] = e.target.value;
                                                props.setAttributes(newAttrs);
                                            }
                                        })
                                    ),
                                    el("dt", { key: `btn${i}-link-label` },
                                        el("span", null, `Button ${i} link`)
                                    ),
                                    el("dd", { key: `btn${i}-link` },
                                        el("input", {
                                            type: "text",
                                            value: props.attributes[`button_${i}_link`] || "",
                                            placeholder: `Button ${i} link...`,
                                            onChange: (e) => {
                                                const newAttrs = {};
                                                newAttrs[`button_${i}_link`] = e.target.value;
                                                props.setAttributes(newAttrs);
                                            }
                                        })
                                    ),
                                    // Optional <hr> between items
                                    i < numberOfLinks ? el("hr", {
                                        key: `hr-${i}`,
                                        style: { borderColor: "red", borderWidth: "1px", margin: "20px 0" }
                                    }) : null
                                );
                            }
                            
                            return fields;
                        })()
                        
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