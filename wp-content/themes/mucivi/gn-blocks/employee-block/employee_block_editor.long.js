( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/employee-block', {
        title: 'Employee',
        icon: 'admin-users',
        category: 'mucivi-blocks',
        description: "Test",
        example: {},
        attributes: {
            post_id: {
                type: 'string'
            },
            align_items: {
                type: 'string',
            },

            background_color: {
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
                posts: select( 'core' ).getEntityRecords( 'postType', 'employee', query ),
            };
        } )( function ( props ) {

            if (!props.attributes.align_items)
            {
                props.setAttributes({align_items: "top"})
            }

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }


            function on_change_post( newContent ) {
                props.setAttributes( { post_id: newContent } );
            }

            function update_align_items (newValue) {
                props.setAttributes( { align_items: newValue } );
            }

            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
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
                options.push( { value: 0, label: 'Loading...' } )
            }

            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},

                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },

                            el("strong", null, "Align Items"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.align_items,
                                    options: [
                                        {
                                            value: 'center',
                                            label: 'Center'
                                        },
                                        {
                                            value: 'top',
                                            label: 'Top'
                                        },
                                    ],
                                    onChange: update_align_items
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
                        )
                    ),

                    el("div", {
                            class: "granit-block employee-block count-"+ props.attributes.number  + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Employee Block"),

                        el("dl", null,

                            el("div", null,

                                el("dt", null, "Choose Employee"),
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