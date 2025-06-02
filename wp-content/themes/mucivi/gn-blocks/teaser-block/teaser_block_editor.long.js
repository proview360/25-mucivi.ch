( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        Fragment            = wp.element.Fragment,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/teaser-block', {
        title: 'Teaser Block',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        example: {},

        attributes: {
            post_id: {
                type: 'string'
            },
            design_type: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
            headline: {
                type: 'string'
            },

        },

        edit: withSelect( function ( select ) {

            var query = {
                orderby : 'title',
                order : 'asc',
                per_page: -1,
            }

            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'teasers', query ),
            };
        } )( function ( props ) {

            if (!props.attributes.design_type)
            {
                props.setAttributes({design_type: "flex"})
            }
            if (!props.attributes.background_color)
            {
                props.setAttributes({background_color: "white"})
            }
            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }
            function update_design_type( newContent ) {
                props.setAttributes( { design_type: newContent } )
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
                            el("strong", null, "Design Typ"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.design_type,
                                    options: [
                                        {
                                            value: 'flex',
                                            label: 'Flex'
                                        },
                                        {
                                            value: 'grid',
                                            label: 'Grid'
                                        },
                                        {
                                            value: 'image-only',
                                            label: 'Photo Only'
                                        },
                                        {
                                            value: 'image-link',
                                            label: 'Photo / Link'
                                        }
                                    ],
                                    onChange: update_design_type
                                }
                            ),

                            el("strong", null, "Background Farbe"),
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

                    el("div", {
                            class: "granit-block worker-block count-"+ props.attributes.number + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Teaser-Block"),

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

                                el("dt", null, "Teaser choose"),
                                el("dd", null,
                                    el(SelectControl, {
                                        value: props.attributes.post_id,
                                        options: options,
                                        onChange: on_change_post,
                                    })
                                ),
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