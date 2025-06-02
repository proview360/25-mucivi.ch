( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/accordion-block', {
        title: 'Accordion',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        description: "Test",
        example: {},

        attributes: {
            post_id: {
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
                posts: select( 'core' ).getEntityRecords( 'postType', 'accordion', query ),
            };
        } )( function ( props ) {

            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }

            var options = [];

            if(!props.attributes.number)
            {
                props.setAttributes({number: "3"})
            }

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

                        )
                    ),

                    el("div", {
                            class: "granit-block worker-block count-"+ props.attributes.number
                        },
                        el("h3", null, "Accordion Block"),

                        el("dl", null,

                            el("div", null,

                                el("dt", null, "Choose Accordion "),
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