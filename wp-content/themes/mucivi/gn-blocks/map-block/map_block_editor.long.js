(function(blocks, element, data, editor, components, blockEditor) {

    //set vars
    var el                  = element.createElement,
        Fragment            = element.Fragment,
        RichText            = blockEditor.RichText,
        MediaUpload         = wp.blockEditor.MediaUpload,
        InspectorControls   = blockEditor.InspectorControls,
        SelectControl       = components.SelectControl,
        ToggleControl       = components.ToggleControl;

    //register block
    blocks.registerBlockType('gn/map-block', {

        //set basic info
        title: 'Map Block',
        icon: 'location',
        category: 'mucivi-blocks',
        description: "location",
        example: {},

        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },

            layout: {
                type: 'string'
            },
            map_link: {
                type: 'string'
            },
            map_link_button: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
        },

        //set edit function
        edit: function(props) {


            if(!props.attributes.layout)
            {
                props.setAttributes({layout: "boxed"})
            }

            if(!props.attributes.background_color)
            {
                props.setAttributes({background_color: "gray"})
            }


            function update_layout (newValue) {
                props.setAttributes( {layout: newValue} )
            }

            function update_map_link (event) {
                props.setAttributes( {map_link: event.target.value} )
            }

            function update_map_link_button (event) {
                props.setAttributes( {map_link_button: event.target.value} )
            }
            function update_background_color (newValue) {
                props.setAttributes( { background_color: newValue } );
            }



            return (
                el(Fragment, null,
                    el(InspectorControls, null,

                        el("strong", null, "Layout"),
                        el(SelectControl,
                            {
                                label: '',
                                value: props.attributes.layout,
                                options: [
                                    {
                                        value: 'boxed',
                                        label: 'Content Breite'
                                    },
                                    {
                                        value: 'full-width',
                                        label: 'Volle Breite'
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


                    ),

                    el("div", {
                            id: "map-block",
                            class: "granit-block "  + " bg-color-" + props.attributes.background_color
                        },
                        el("h3", null, "Map"),

                        el("dl", null,

                            el("dt", null,
                                el("span", null, "Map Link"),
                            ),
                            el("dd", null,
                                el("input", {
                                        type: "text",
                                        value: props.attributes.map_link,
                                        placeholder: "Hier schreiben...",
                                        onChange: update_map_link
                                    }
                                )
                            ),
                        )
                    )
                )
            );
        },

        //set save function
        save: function(props) {

            return el( RichText.Content, {
                tagName: 'p', value: props.attributes.content
            } );
        }
    })
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.editor,
    window.wp.components,
    window.wp.blockEditor
));