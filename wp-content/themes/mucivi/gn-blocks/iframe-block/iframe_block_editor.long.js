(function (wp, blocks, element, data) {

    var el = element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = blocks.registerBlockType,
        RichText = wp.blockEditor.RichText,
        MediaUpload = wp.blockEditor.MediaUpload,
        SelectControl = wp.components.SelectControl,
        InspectorControls = wp.blockEditor.InspectorControls,
        withSelect = data.withSelect;

    registerBlockType('gn/iframe-block', {
        title: 'Iframe Block',
        icon: 'editor-kitchensink',
        category: 'mucivi-blocks',
        description: 'Iframe block - video - youtube - virtual tour',

        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },
            video_layout: {
                type: 'string'
            },
            headline: {
                type: 'string'
            },

            iframe_link: {
                type: 'string'
            },

            text_color: {
                type: 'string'
            },
            background_color: {
                type: 'string'
            },
            select_headline_type: {
                type: 'string',
            },
        },

        edit: (function (props) {

            var image_video_not_present = "";

            if (!props.attributes.background_color) {
                props.setAttributes({background_color: "gray"})
            }
            if (!props.attributes.text_color) {
                props.setAttributes({text_color: "black"})
            }

            if (!props.attributes.video_layout) {
                props.setAttributes({video_layout: "youtube"})
            }


            function updateHeadline(event) {
                props.setAttributes({headline: event.target.value});
            }

            function update_iframe_link(event) {
                props.setAttributes({iframe_link: event.target.value});
            }


            function update_video_layout(newValue) {
                props.setAttributes({video_layout: newValue})
            }

            function on_change_text_color(newValue) {
                props.setAttributes({text_color: newValue});
            }

            function on_change_background_color(newValue) {
                props.setAttributes({background_color: newValue});
            }

            function on_change_select_headline_type (newValue) {
                props.setAttributes( { select_headline_type: newValue } );
            }


            return (
                el(Fragment, null,
                    el(InspectorControls, {class: "granit-SelectControl"},

                        el("div", {class: "granit-block-sidebar-element"},


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



                            el("strong", null, "Video Layout"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.video_layout,
                                    options: [
                                        {
                                            value: 'youtube',
                                            label: 'Youtube'
                                        },
                                        {
                                            value: 'video_local',
                                            label: 'Video Local'
                                        },
                                        {
                                            value: 'virtual_tour',
                                            label: 'Virtual Tour'
                                        },
                                        {
                                            value: 'gallery',
                                            label: 'Gallery'
                                        },
                                    ],
                                    onChange: update_video_layout
                                }
                            ),


                            el("strong", null, "Text Color"),
                            el(SelectControl,
                                {
                                    label: '',
                                    value: props.attributes.text_color,
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
                                    onChange: on_change_text_color
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
                                    onChange: on_change_background_color
                                }
                            ),
                        )
                    ),

                    el("div", {class: "granit-block split-block text-color-" + props.attributes.text_color + " bg-color-" + props.attributes.background_color},
                        el("h3", null, "Iframe-Block"),

                        el("dl", null,


                            el("div", {class: "layout-text"},

                                el("dt", null,
                                    el("span", null, "Headline"),
                                    el("small", null, "(optional)")
                                ),
                                el("dd", null,
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.headline,
                                        placeholder: "Hier schreiben...",
                                        onChange: updateHeadline
                                    })
                                ),
                            ),

                            el("div", {class: "layout-text"},

                                el("dt", null,
                                    el("span", null, "Iframe Link"),
                                    el("small", null, "(optional)")
                                ),
                                el("dd", null,
                                    el("input", {
                                        type: "text",
                                        value: props.attributes.iframe_link,
                                        placeholder: "Hier schreiben...",
                                        onChange: update_iframe_link
                                    })
                                ),
                            ),


                            // YouTube External Link with Icon
                            props.attributes.video_layout === 'youtube'  ?
                                el("div", null,
                                    el("dt", { style: { fontSize: "16px", fontWeight: "bold", color: "#ff0000" } },
                                            el("i", {className: "fas fa-youtube"}), " Youtube"
                                    ),
                                    el("dd", null)
                                ) : el("dd", null),

                            // Virtual Tour External Link with Icon
                            props.attributes.video_layout === 'virtual_tour' ?
                                el("div", null,
                                    el("dt", { style: { fontSize: "16px", fontWeight: "bold", color: "#ff0000" } },
                                            el("i", {className: "fas fa-map"}), " Virtual Tour"
                                    ),
                                    el("dd", null)
                                ) : el("dd", null),

                            // Video Locale External Link with Icon
                            props.attributes.video_layout === 'video_local' ?
                                el("div", null,
                                    el("dt", { style: { fontSize: "16px", fontWeight: "bold", color: "#ff0000" } },
                                            el("i", {className: "fas fa-video"}), " Video Locale"
                                    ),
                                    el("dd", null)
                                ) : el("dd", null),


                            // Video Locale External Link with Icon
                            props.attributes.video_layout === 'gallery' ?
                                el("div", null,
                                    el("dt", { style: { fontSize: "16px", fontWeight: "bold", color: "#ff0000" } },
                                        el("i", {className: "fas fa-video"}), " Gallery"
                                    ),
                                    el("dd", null)
                                ) : el("dd", null),
                            ),





                        ),
                    )
            );
        }),

        //set save function
        save: function (props) {

            return el(RichText.Content, {
                tagName: 'p', value: props.attributes.content
            });
        }

    });
})(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);