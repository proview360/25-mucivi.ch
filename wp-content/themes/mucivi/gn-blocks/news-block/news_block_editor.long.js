( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        SelectControl       = wp.components.SelectControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/news-block', {
        title: 'News Block',
        icon: 'menu-alt2',
        category: 'mucivi-blocks',
        description: "News Block",
        example: {},

        attributes: {
            layout: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
            category_1_title: {
                type: 'string'
            },
            category_1: {
                type: 'string'
            },
            category_2_title: {
                type: 'string'
            },

            category_2: {
                type: 'string'
            },
            button_text: {
                type: 'string'
            },
            button_link: {
                type: 'string'
            }
        },
        edit: ( function ( props ) {

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }

            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }
            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_content_button_text (event) {
                props.setAttributes( {button_text: event.target.value} )
            }

            function update_content_button_link (event) {
                props.setAttributes( {button_link: event.target.value} )
            }

            function update_content_category_1_title (event) {
                props.setAttributes( {category_1_title: event.target.value} )
            }
            function update_content_category_1 (event) {
                props.setAttributes( {category_1: event.target.value} )
            }
            function update_content_category_2_title (event) {
                props.setAttributes( {category_2_title: event.target.value} )
            }

            function update_content_category_2 (event) {
                props.setAttributes( {category_2: event.target.value} )
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
                            class: "granit-block news-block bg-color-" + props.attributes.background_color
                        },
                        el("dt", null,
                            el("h1", null, "News Block"),
                        ),

                        el("dt", null,
                            el("span", null, "Custom Category 1 Title"),
                        ),


                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.category_1_title,
                                    placeholder: "Write here...",
                                    onChange: update_content_category_1_title
                                }
                            )
                        ),

                        el("dt", null,
                            el("span", null, "Category 1"),
                        ),


                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.category_1,
                                    placeholder: "Write here...",
                                    onChange: update_content_category_1
                                }
                            )
                        ),

                        el("dt", null,
                            el("span", null, "Custom Category 2 Title"),
                        ),

                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.category_2_title,
                                    placeholder: "Write here...",
                                    onChange: update_content_category_2_title
                                }
                            )
                        ),

                        el("dt", null,
                            el("span", null, "Category 2"),
                        ),

                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.category_2,
                                    placeholder: "Write here...",
                                    onChange: update_content_category_2
                                }
                            )
                        ),


                        el("dt", null,
                            el("span", null, "Button Text"),
                        ),

                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.button_text,
                                    placeholder: "Write here...",
                                    onChange: update_content_button_text
                                }
                            )
                        ),

                        el("dt", null,
                            el("span", null, "Button Link"),
                        ),

                        el("dd", null,
                            el("input", {
                                    type: "text",
                                    value: props.attributes.button_link,
                                    placeholder: "Write here...",
                                    onChange: update_content_button_link
                                }
                            )
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