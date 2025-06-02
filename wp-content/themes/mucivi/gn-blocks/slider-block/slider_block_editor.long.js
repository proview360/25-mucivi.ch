( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        Fragment            = wp.element.Fragment,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/slider-block', {
        title: 'Sliders  Block',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        description: "Slider Block",
        example: {},

        attributes: {
            post_id: {
                type: 'string'
            },
            layout: {
                type: 'string'
            },
            break_text: {
                type: 'string'
            }

        },

        edit: withSelect( function ( select ) {

            var query = {
                orderby : 'title',
                order : 'asc',
                per_page: -1,
            }

            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'sliders', query ),
            };
        } )( function ( props ) {
            if (!props.attributes.break_text)
            {
                props.setAttributes({break_text: "yes"})
            }

            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }
            function update_break_text( newContent ) {
                props.setAttributes( { break_text: newContent } )
            }

            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
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

                            el("strong", null, "Break Text"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.break_text,
                                    options: [
                                        {
                                            value: 'yes',
                                            label: 'Yes'
                                        },
                                        {
                                            value: 'no',
                                            label: 'No'
                                        }
                                    ],
                                    onChange: update_break_text
                                }
                            ),
                        )
                    ),

                    el("div", {
                            class: "granit-block worker-block count-"+ props.attributes.number
                        },
                        el("h3", null, "Slider-Block"),

                        el("dl", null,

                            el("div", null,

                                el("dt", null, "Slider choose"),
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