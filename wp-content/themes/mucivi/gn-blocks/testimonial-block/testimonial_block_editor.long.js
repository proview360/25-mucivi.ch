( function ( wp, blocks, element, data, blockEditor ) {

    var el = element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = blocks.registerBlockType,
        withSelect = data.withSelect,
        SelectControl = wp.components.SelectControl,
        InspectorControls = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/testimonial-block', {
        title: 'Testimonials',
        icon: 'images-alt2',
        category: 'mucivi-blocks',
        description: "Testimonial Block",
        example: {},

        attributes: {
            postID: {
                type: 'string'
            },
            layout: {
                type: 'string'
            },
            quote_style: {
                type: 'string'
            },
            show_stars: {
                type: 'string'
            },
        },

        edit: withSelect( function ( select ) {

            var query = {
                per_page: -1,
                orderby : 'title',
                order : 'asc'
            }

            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'testimonial', query ),
            };
        } )( function ( props ) {

            if(!props.attributes.layout)
            {
                props.setAttributes({layout: "fullWidth"})
            }

            if(!props.attributes.show_stars)
            {
                props.setAttributes({show_stars: "1"})
            }

            function update_layout (newValue) {
                props.setAttributes( {layout: newValue} )
            }

            function update_quote_style (newValue) {
                props.setAttributes( {quote_style: newValue} )
            }
            function update_show_stars (newValue) {
                props.setAttributes( {show_stars: newValue} )
            }


            function on_change_post( newContent ) {

                props.setAttributes( { postID: newContent } );
            }

            var options = [];

            if( props.posts )
            {
                options.push( { value: 0, label: 'Auswählen...' } );

                props.posts.forEach((post) => {

                    options.push({value:post.id, label:post.title.raw});
                });
            }
            else
            {
                options.push( { value: 0, label: 'Lade...' } )
            }

            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "gn-SelectControl"},
                        el("div",
                            {
                                class: "gn-block-sidebar-element"
                            },
                            el("strong", null, "Layout"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.layout,
                                    options: [
                                        {
                                            value: 'fullWidth',
                                            label: 'Volle Breite'
                                        },
                                        {
                                            value: 'boxed',
                                            label: 'Boxed'
                                        },
                                    ],
                                    onChange: update_layout
                                }
                            ),
                            el("strong", null, "Testimonial Stil"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.quote_style,
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
                                    onChange: update_quote_style
                                }
                            ),
                            el("strong", null, "Show Stars"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.show_stars,
                                    options: [
                                        {
                                            value: '0',
                                            label: 'No'
                                        },
                                        {
                                            value: '1',
                                            label: 'Yes'
                                        },
                                    ],
                                    onChange: update_show_stars
                                }
                            ),

                        )
                    ),

                    el("div", {
                            class: "granit-block text-testimonials-block"
                        },
                        el("h3", null, "Testimonial"),

                        el("dl", null,
                            el("dt", null, "Testimonial auswählen"),
                            el("dd", null,
                                el(SelectControl, {
                                    value: props.attributes.postID,
                                    options: options,
                                    onChange: on_change_post,
                                })
                            )
                        )
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