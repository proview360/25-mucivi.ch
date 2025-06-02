(function (wp, blocks, element, data) {

    const el = element.createElement,
        Fragment = wp.element.Fragment,
        registerBlockType = blocks.registerBlockType,
        SelectControl = wp.components.SelectControl,
        InspectorControls = wp.blockEditor.InspectorControls,
        MediaUpload = wp.blockEditor.MediaUpload,
        Dashicon = wp.components.Dashicon,
        useState = wp.element.useState;

    registerBlockType('gn/threed-and-lists-block', {
        title: '3d and list content-Block',
        icon: 'podio',
        category: 'mucivi-blocks',
        description: "3d and list content Block",
        example: {},

        attributes: {
            layout: { type: 'string' },
            rows: {
                type: 'array',
                default: [],
            },
            row_headline: {
                type: 'string'
            },
            update_theed_link:{
                type: 'string',
            },
            theed_link: {
                type: 'string',
            },
            change_row_order: {
                type: 'string',
            },
            background_color: {
                type: 'string'
            },
        },

        edit: function (props) {

            const [movingIndex, setMovingIndex] = useState(null);
            const [collapsedRows, setCollapsedRows] = useState(() =>
                props.attributes.rows.map((_, index) => index)
            );
            function update_row_headline( event ) {
                props.setAttributes( { row_headline: event.target.value } );
            }

            function update_theed_link( event ) {
                props.setAttributes( { theed_link: event.target.value } );
            }

            const update_layout = (newValue) => {
                props.setAttributes({ layout: newValue });
            };

            const update_change_row_order = (newValue) => {
                props.setAttributes({ change_row_order: newValue });
            };
            function update_background_color(event) {
                props.setAttributes({ background_color: event.target.value });
            }

            const add_row = () => {
                const new_buttons = [...props.attributes.rows, {
                    headline: "",
                    description: "",
                    image: null,
                }];
                props.setAttributes({ rows: new_buttons });
            };

            const update_row = (index, updatedRow) => {
                const new_buttons = props.attributes.rows.map((row, rowIndex) => {
                    return rowIndex === index ? { ...row, ...updatedRow } : row;
                });
                props.setAttributes({ rows: new_buttons });
            };

            const remove_row = (index) => {
                const new_buttons = props.attributes.rows.filter((_, rowIndex) => rowIndex !== index);
                props.setAttributes({ rows: new_buttons });
                setCollapsedRows(collapsedRows.filter(i => i !== index));
            };

            const move_row_up = (index) => {
                if (index === 0) return;
                const new_buttons = [...props.attributes.rows];
                [new_buttons[index - 1], new_buttons[index]] = [new_buttons[index], new_buttons[index - 1]];
                props.setAttributes({ rows: new_buttons });
                setMovingIndex(index - 1);
                setTimeout(() => setMovingIndex(null), 1000);
            };

            const move_row_down = (index) => {
                if (index === props.attributes.rows.length - 1) return;
                const new_buttons = [...props.attributes.rows];
                [new_buttons[index], new_buttons[index + 1]] = [new_buttons[index + 1], new_buttons[index]];
                props.setAttributes({ rows: new_buttons });
                setMovingIndex(index + 1);
                setTimeout(() => setMovingIndex(null), 1000);
            };

            const toggleCollapse = (index) => {
                if (collapsedRows.includes(index)) {
                    setCollapsedRows(collapsedRows.filter(i => i !== index));
                } else {
                    setCollapsedRows([...collapsedRows, index]);
                }
            };

            return el(Fragment, null,
                el(InspectorControls, { className: "granit-SelectControl" },
                    el("div", { className: "granit-block-sidebar-element" },
                        el("strong", null, "Layout"),
                        el(SelectControl, {
                            label: '',
                            value: props.attributes.layout,
                            options: [
                                { value: 'boxed', label: 'Container' },
                                { value: 'full-width', label: 'Full Width' }
                            ],
                            onChange: update_layout
                        })
                    ),
                    el("div", { className: "granit-block-sidebar-element" },
                        el("strong", null, "Change row order"),
                        el(SelectControl, {
                            label: '',
                            value: props.attributes.change_row_order,
                            options: [
                                { value: 'no', label: 'No' },
                                { value: 'yes', label: 'Yes' },
                            ],
                            onChange: update_change_row_order
                        })
                    )
                ),
                el("div", {
                        className: "granit-block 3d-and-list-block count-" + props.attributes.rows.length
                    },
                    el("h3", null, "3D and lists-Block"),

                    el("dt", {}, "3D link (optional)"),
                    el("input", {
                        type: "text",
                        value: props.attributes.theed_link,
                        placeholder: "Write here...",
                        onChange: update_theed_link
                    }),



                    el("dt", {}, "Row Headline (optional)"),
                    el("input", {
                        type: "text",
                        value: props.attributes.row_headline,
                        placeholder: "Write here...",
                        onChange: update_row_headline
                    }),

                    props.attributes.rows.map((row, index) =>
                        el("div", {
                                key: index,
                                style: {
                                    padding: '10px 0',
                                    borderBottom: '1px solid #ddd',
                                    backgroundColor: movingIndex === index ? 'red' : index % 2 !== 0 ? 'transparent' : '#f9f9f9',
                                    transition: 'background-color 0.3s ease'
                                }
                            },
                            // COLLAPSE HEADER
                            el("div", {
                                    style: {
                                        cursor: 'pointer',
                                        display: 'flex',
                                        justifyContent: 'space-between',
                                        alignItems: 'center',
                                        backgroundColor: '#eee',
                                        padding: '10px'
                                    },
                                    onClick: () => toggleCollapse(index)
                                },
                                el('strong', null, `Row List #${index + 1}`),
                                el(Dashicon, {
                                    icon: collapsedRows.includes(index) ? 'arrow-down' : 'arrow-up',
                                    style: {
                                        color: 'red',
                                        fontSize: '30px', // 👈 Bigger size
                                        lineHeight: '1'
                                    }
                                })
                            ),

                            // COLLAPSIBLE CONTENT
                            !collapsedRows.includes(index) && el("div", { style: { marginTop: '15px' } },
                                el("dt", {}, "Image"),
                                el("dd", {},
                                    el(MediaUpload, {
                                        onSelect: (media) => {
                                            if (!media || !media.url) return;
                                            update_row(index, {
                                                image: {
                                                    id: media.id,
                                                    url: media.url,
                                                    alt: media.alt || '',
                                                }
                                            });
                                        },
                                        allowedTypes: ['image'],
                                        render: ({ open }) =>
                                            el("button", {
                                                onClick: open,
                                                className: "btn"
                                            }, row.image ? "Change Image" : "Add Image")
                                    }),
                                    row.image && el("div", {},
                                        el("img", {
                                            src: row.image && row.image.url ? row.image.url : '',
                                            alt: row.image && row.image.alt ? row.image.alt : '',
                                            style: { maxWidth: '200px', marginTop: '10px' }
                                        }),
                                        el("button", {
                                            className: "btn-remove-img",
                                            onClick: () => update_row(index, { image: null }),
                                            style: { marginTop: '5px' }
                                        }, "Remove Image")
                                    )

                                ),
                                el("dl", null,
                                    el("dt", null, "Headline"),
                                    el("dd", null,
                                        el('input', {
                                            type: "text",
                                            value: row.headline || '',
                                            onChange: (event) => update_row(index, { headline: event.target.value })
                                        })
                                    )
                                ),
                                el("dl", null,
                                    el("dt", null, "Description"),
                                    el("dd", null,
                                        el('input', {
                                            type: "text",
                                            value: row.description || '',
                                            onChange: (event) => update_row(index, { description: event.target.value })
                                        })
                                    )
                                ),
                                el('button', {
                                    onClick: () => remove_row(index),
                                    style: { marginBottom: '5px', marginRight: '5px' }
                                }, 'Remove Row'),

                                el('button', {
                                    onClick: () => move_row_up(index),
                                    style: { marginRight: '5px' }
                                }, 'Move Up'),

                                el('button', {
                                    onClick: () => move_row_down(index),
                                    style: { marginRight: '5px' }
                                }, 'Move Down')
                            )
                        )
                    ),
                    el("div", {},
                        el("p", { class: "label-text" }, "Background Color "),
                        el("select", {
                                value: props.attributes.background_color,
                                onChange: update_background_color
                            },
                            el('option',
                                {
                                    value: 'color-white',
                                    selected: props.attributes.background_color === 'white'
                                },
                                'White'
                            ),
                            el('option',
                                {
                                    value: 'color-grayblue',
                                    selected: props.attributes.background_color === 'gray'
                                },
                                'Gray'
                            ),
                            el('option',
                                {
                                    value: 'color-extra-light-gray',
                                    selected: props.attributes.background_color === 'extra-light-gray'
                                },
                                'Extra Light Gray'
                            ),
                            el('option',
                                {
                                    value: 'color-black',
                                    selected: props.attributes.background_color === 'black'
                                },
                                'Black'
                            ),
                            el('option',
                                {
                                    value: 'color-red',
                                    selected: props.attributes.background_color === 'red'
                                },
                                'Red'
                            ),
                        )
                    ),
                    el('button', {
                        onClick: add_row,
                        style: {
                            marginTop: '20px',
                            padding: '10px 20px',
                            backgroundColor: '#D51030',
                            color: 'white',
                            border: 'none',
                            cursor: 'pointer'
                        }
                    }, 'Add new Row')
                )
            );
        },

        save: function () {
            return null; // dynamic render via PHP
        }
    });
})(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);
