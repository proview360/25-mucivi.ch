( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        registerBlockType   = blocks.registerBlockType,
        withSelect          = data.withSelect,
        SelectControl       = wp.components.SelectControl,
        Fragment            = wp.element.Fragment,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/portfolio-block', {
        title: 'Portfolio Block',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        description: "Portfolio Block",
        example: {},

        attributes: {
            layout: {
                type: 'string'
            },
            break_text: {
                type: 'string'
            },
            portfolio_headline: {
                type: 'string'
            },
            filter_name: {
                type: 'string'
            },
            button_load_more: {
                type: 'string'
            },
            button_reset: {
                type: 'string'
            },
            mobile_filter_name: {
                type: 'string'
            },
            select_headline_type: {
                type: 'string',
            },

        },

        edit: withSelect( function ( select ) {} )( function ( props ) {

            if (!props.attributes.break_text)
            {
                props.setAttributes({break_text: "yes"})
            }

            function update_break_text( newContent ) {
                props.setAttributes( { break_text: newContent } )
            }

            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }

            function update_portfolio_headline(event) {
                props.setAttributes({portfolio_headline: event.target.value});
            }

            function update_filter_name(event) {
                props.setAttributes({filter_name: event.target.value});
            }
            function update_button_load_more(event) {
                props.setAttributes({button_load_more: event.target.value});
            }
            function update_button_reset(event) {
                props.setAttributes({button_reset: event.target.value});
            }

            function update_mobile_filter_name(event) {
                props.setAttributes({mobile_filter_name: event.target.value});
            }

            function on_change_select_headline_type (newValue) {
                props.setAttributes( { select_headline_type: newValue } );
            }

            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},

                        el("div",
                            {
                                class: "granit-block-sidebar-element"
                            },
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
                        el("h3", null, "Portfolio-Block"),

                        el("dl", null,

                            el("div", null,

                                el("label", null, "Portfolio Headline"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.portfolio_headline,
                                    placeholder: "Write here...",
                                    onChange: update_portfolio_headline
                                }),

                                el("label", null, "Filter Name (all) to translate"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.filter_name,
                                    placeholder: "Write here...",
                                    onChange: update_filter_name
                                }),

                                el("label", null, "Button Load More"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.button_load_more,
                                    placeholder: "Write here...",
                                    onChange: update_button_load_more
                                }),

                                el("label", null, "Button Reset"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.button_reset,
                                    placeholder: "Write here...",
                                    onChange: update_button_reset
                                }),


                                el("label", null, "Mobile Filter Name"),
                                el("input", {
                                    type: "text",
                                    value: props.attributes.mobile_filter_name,
                                    placeholder: "Write here...",
                                    onChange: update_mobile_filter_name
                                }),

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