( function ( wp, blocks, element, data ) {

    var el                  = element.createElement,
        Fragment            = wp.element.Fragment,
        registerBlockType   = blocks.registerBlockType,
        MediaUpload         = wp.blockEditor.MediaUpload,
        SelectControl       = wp.components.SelectControl,
        CheckboxControl     = wp.components.CheckboxControl,
        InspectorControls   = wp.blockEditor.InspectorControls;

    registerBlockType( 'gn/quick-facts-block', {
        title: 'Quick-Facts',
        icon: 'admin-multisite',
        category: 'mucivi-blocks',
        description: "Quick Facts",
        example: {},

        attributes: {
            layout: {
                type: 'string'
            },
            quick_facts: {
                type: 'array',
                default: [],
            },
            background_color: {
                type: 'string'
            },
            horizontal_line_color:{
                type: 'string'
            }
        },


        edit: ( function ( props ) {


            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }


            if(!props.attributes.horizontal_line_color)
            {
                props.setAttributes({horizontal_line_color: "green"})
            }



            function update_layout (newValue) {
                props.setAttributes( { layout: newValue } )
            }

            function add_quick_fact () {
                const new_quick_facts = [...props.attributes.quick_facts, { text: "", text_2: "", text_3: "", show_icon: false, show_icon_sv: false }];
                props.setAttributes({ quick_facts: new_quick_facts });
            }
            function update_quick_fact (index, updatedquick_fact) {
                const new_quick_facts = props.attributes.quick_facts.map((quick_fact, quick_factIndex) => {
                    if(index !== quick_factIndex) return quick_fact;
                    return { ...quick_fact, ...updatedquick_fact };
                });
                props.setAttributes({ quick_facts: new_quick_facts });
            }

            function remove_quick_fact(index) {
                const new_quick_facts = props.attributes.quick_facts.filter((_, quick_factIndex) => quick_factIndex !== index);
                props.setAttributes({ quick_facts: new_quick_facts });
            }

            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }

            function update_horizontal_line_color (newValue) {
                props.setAttributes( { horizontal_line_color: newValue } );
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
                            el("strong", null, "Horizontal Line Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.horizontal_line_color,
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
                                    onChange: update_horizontal_line_color
                                }
                            ),

                        )
                    ),

                    el("div", {
                            class: "granit-block quick-fact-block count-"+ props.attributes.number + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Quick-Facts-Block"),

                        props.attributes.quick_facts.map((quick_fact, index) =>
                            el("div", { key: index },
                                el('h3', {}, `Quick Fact #${index + 1}`),
                                el("dl", null,

                                    el("dt", null, "Text"),
                                    el("dd", null,
                                        el(CheckboxControl, {
                                            label: "Show Approximate Icon in front of number?",
                                            checked: quick_fact.show_icon,
                                            onChange: (newShowIcon) => update_quick_fact(index, { show_icon: newShowIcon })
                                        }),
                                    ),
                                    el("dd", null,
                                        el(CheckboxControl, {
                                            label: "Show Approximate Icon in front of number Swedish?",
                                            checked: quick_fact.show_icon_sv,
                                            onChange: (newShowIcon) => update_quick_fact(index, { show_icon_sv: newShowIcon })
                                        }),
                                    ),
                                    el("dd", null,
                                        el('input', {
                                            type: "text",
                                            placeholder: "Quick fact text (number)",
                                            value: quick_fact.text,
                                            onChange: (event) => update_quick_fact(index, { text: event.target.value })
                                        }),
                                    ),
                                ),


                                el("dl", null,
                                    el("dt", null, "Text 2"),
                                    el("dd", null,
                                        el('input', {
                                            type: "text",
                                            placeholder: "Quick fact text (under number)",
                                            value: quick_fact.text_2,
                                            onChange: (event) => update_quick_fact(index, { text_2: event.target.value })
                                        }),
                                    ),
                                ),
                                el("dl", null,
                                    el("dt", null, "Text 3"),
                                    el("dd", null,
                                        el('input', {
                                            type: "text",
                                            placeholder: "Quick fact text (under line)",
                                            value: quick_fact.text_3,
                                            onChange: (event) => update_quick_fact(index, { text_3: event.target.value })
                                        }),
                                    ),
                                ),



                                el('button', {
                                    onClick: () => remove_quick_fact(index),
                                    style: { marginBottom: '15px' }
                                }, 'Remove Quick Fact #' + (1 + index)),

                            )
                        ),
                        el('button', { onClick: add_quick_fact }, 'Add new Quick Fact '),
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