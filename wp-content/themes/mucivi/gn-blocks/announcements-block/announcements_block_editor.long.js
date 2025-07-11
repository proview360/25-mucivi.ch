(function ( wp, blocks, element, data ) {
    const { createElement: el, Fragment } = element;
    const { registerBlockType }           = blocks;
    const { withSelect }                  = data;
    const { SelectControl }               = wp.components;
    const { InspectorControls }           = wp.blockEditor;
    
    const blockAttributes = {
        post_id:        { type: 'string' },
        post_id_2:      { type: 'string' },
        number_of_link: { type: 'string' },
        side_bar_title: { type: 'string' },
        side_bar_enable:{ type: 'string' },
        headline:       { type: 'string' },
        background_color:{ type: 'string' },
    };
    
    registerBlockType('gn/announcements-block', {
        title:    'Announcements Block',
        icon:     'megaphone',
        category: 'mucivi-blocks',
        attributes: blockAttributes,
        
        // Fetch BOTH post types in one HOC
        edit: withSelect((select) => {
            const query = { orderby: 'title', order: 'asc', per_page: -1 };
            return {
                announcementsPosts: select('core').getEntityRecords('postType', 'announcements', query),
                linksPosts:         select('core').getEntityRecords('postType', 'links',         query),
            };
        })((props) => {
            // default attrs
            if (!props.attributes.background_color) props.setAttributes({ background_color: 'white' });
            if (!props.attributes.side_bar_enable)  props.setAttributes({ side_bar_enable: 'no'   });
            
            // build options arrays
            const buildOptions = (items) => {
                if (!items) return [{ value: 0, label: 'Loading…' }];
                const opts = [{ value: 0, label: 'Choose…' }];
                items.forEach(post => opts.push({ value: post.id, label: post.title.raw }));
                return opts;
            };
            const annOptions = buildOptions(props.announcementsPosts);
            const linkOptions = buildOptions(props.linksPosts);
            
            // handlers
            const onChangeAnnouncements = id => props.setAttributes({ post_id: id });
            const onChangeLinks         = id => props.setAttributes({ post_id_2: id });
            const updateSidebarEnable   = v  => props.setAttributes({ side_bar_enable: v });
            const updateSidebarTitle    = e  => props.setAttributes({ side_bar_title: e.target.value });
            const updateBgColor         = v  => props.setAttributes({ background_color: v });
            const updateHeadline        = e  => props.setAttributes({ headline: e.target.value });
            
            // render
            return el(Fragment, null,
                el(InspectorControls, { className: 'granit-SelectControl' },
                    el('div', { className: 'granit-block-sidebar-element' },
                        el('strong', null, 'Background Color'),
                        el(SelectControl, {
                            value:   props.attributes.background_color,
                            options: [
                                { value: 'white',    label: 'White' },
                                { value: 'black',    label: 'Black' },
                                { value: 'primary',  label: 'Primary' },
                                { value: 'secondary',label: 'Secondary' },
                            ],
                            onChange: updateBgColor,
                        }),
                        
                        el('strong', null, 'Sidebar enable'),
                        el(SelectControl, {
                            value:   props.attributes.side_bar_enable,
                            options: [
                                { value: 'no',  label: 'No' },
                                { value: 'yes', label: 'Yes' }
                            ],
                            onChange: updateSidebarEnable,
                        }),
                        
                        props.attributes.side_bar_enable === 'yes' && el(Fragment, null,
                  
                 
                        )
                    )
                ),
                
                el('div', {
                        className: `granit-block worker-block count-${props.attributes.number} bg-color-${props.attributes.background_color}`
                    },
                    el('h3', null, 'Announcements-Block'),
                    
                    el('dt', null,
                        el('span', null, 'Headline'),
                        el('small', null, '(optional)')
                    ),
                    el('dd', null,
                        el('input', {
                            type: 'text',
                            value: props.attributes.headline,
                            placeholder: 'Hier schreiben…',
                            onChange: updateHeadline
                        })
                    ),
                    
                    // ANNOUNCEMENTS selector
                    el('dl', null,
                        el('dt', null, 'Announcements choose'),
                        el('dd', null,
                            el(SelectControl, {
                                value:   props.attributes.post_id,
                                options: annOptions,
                                onChange: onChangeAnnouncements,
                            })
                        )
                    ),
                    
                    // LINKS selector
                    props.attributes.side_bar_enable === 'yes' && (() => {
                        return el(
                            "dl", null,
                            el("dt", null, "Side Bar Title"),
                            el("input", {
                                key: "input",
                                type: "text",
                                value: props.attributes.side_bar_title,
                                placeholder: "Write here...",
                                onChange: updateSidebarTitle
                            }),
                            el('dl', null,
                                el('dt', null, 'Links choose'),
                                el('dd', null,
                                    el(SelectControl, {
                                        value:   props.attributes.post_id_2,
                                        options: linkOptions,
                                        onChange: onChangeLinks,
                                    })
                                )
                            )
                        );
                    })()
                )
            );
        }),
        
        save: () => null, // dynamic
    });
})(
    window.wp,
    window.wp.blocks,
    window.wp.element,
    window.wp.data,
    window.wp.blockEditor
);
