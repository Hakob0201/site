(function( window, views, media, $ ) {
    "use strict"

    var defaultOptions = wvplVars.options;

	// wp.media.editor.state('waveplayer-edit').on( 'update', function( selection ) {
	// 	this.insert( media.waveplayer.shortcode( selection ).string() );
	// }, this );
	// wp.media.editor.state('waveplayer-addFromUrl').on( 'update', function( selection ) {
	// 	this.insert( media.waveplayer.shortcode( selection ).string() );
	// }, this );

    var wvpl = {
        action: 'parse_shortcode',

        state: ['waveplayer-edit'],

        initialize: function() {
            var self = this;

            $.ajax({
                url: wvplVars.wvpl_ajax_url.replace('%%endpoint%%', this.action),
                type: 'post',
                dataType: 'json',
                data: {
                    nonce: wvplVars.nonce,
                    post_ID: media.view.settings.post.id,
                    type: this.shortcode.tag,
                    shortcode: this.shortcode.string()
                },
                success: (response) => {
                    self.render( response.data )
                },
                error: (response) => {
                    if ( self.url ) {
                        self.ignore = true;
                        self.removeMarkers();
                    } else {
                        self.setError( response.message || response.statusText, 'admin-media' );
                    }
                }
            });

            this.getEditors( function( editor ) {
                editor.on( 'wpview-selected', function() {
                    self.pausePlayers();
                } );
            } );
        },

        pausePlayers: function() {
            this.getNodes( function( editor, node, content ) {
                var win = $( 'iframe.wpview-sandbox', content ).get( 0 )
                let innerDoc = document
                if ( win )
                    innerDoc = win.contentDocument || win.contentWindow.document

                const players = $(innerDoc).find('.waveplayer');

                if ( win ) {
                    _.each( players, function( player ) {
                        try {
                            $(player).waveplayer('pause');
                        } catch ( e ) {}
                    } );
                }
            } );
        },

        edit: function( text, update ) {

            var shortcode = wp.shortcode.next( 'waveplayer', text ),
				type = this.type,
                frame;

			this.pausePlayers && this.pausePlayers();

            // Ignore the rest of the match object.
            shortcode = shortcode.shortcode;

            if ( ! _.isUndefined( shortcode.attrs.named.ids ) ) {

                frame = media.waveplayer.edit(text);

            } else if ( ! _.isUndefined( shortcode.attrs.named.url ) ) {

                var selection = new media.model.Selection({});
                selection.waveplayer = new Backbone.Model( shortcode.attrs.named );

                frame = media({
                    frame:      'post',
                    title:      media.view.l10n.editWaveplayerFromURLTitle,
                    state:      'waveplayer-addFromUrl',
                    editing:    true,
                    selection:  selection,
                }).open();

                frame.state('waveplayer-addFromUrl').props.set('url', shortcode.attrs.named.url);

            } else if ( ! _.isUndefined( shortcode.attrs.named.music_genre ) ) {

                // TODO: defines how to edit the shortcode when the 'music_genre' parameter is provided

            } else {
                return;
            }

			_.each( this.state, function( state ) {
				frame.state( state ).on( 'update', function( selection ) {
					update( media.waveplayer.shortcode( selection ).string(), type === 'waveplayer' );
				} );
			} );

            frame.on( 'close', function() {
                frame.detach();
            } );

            frame.open();
        }
    };
    views.register( 'waveplayer', wvpl );

    var wvplAudio = {
        action: 'parse_single_shortcode',

        state: [ 'audio-details' ],

        initialize: function() {
            var self = this;

            if ( this.url ) {
                this.loader = false;
                this.shortcode = media.embed.shortcode( {
                    url: this.text
                } );
            }

            $.ajax({
                url: wvplVars.wvpl_ajax_url.replace('%%endpoint%%', this.action),
                type: 'post',
                dataType: 'json',
                data: {
                    nonce: wvplVars.nonce,
                    post_ID: media.view.settings.post.id,
                    type: this.shortcode.tag,
                    shortcode: this.shortcode.string()
                },
                success: (response) => {
                    self.render( response.data )
                },
                error: (response) => {
                    if ( self.url ) {
                        self.ignore = true;
                        self.removeMarkers();
                    } else {
                        self.setError( response.message || response.statusText, 'admin-media' );
                    }
                }
            });

            this.getEditors( function( editor ) {
                editor.on( 'wpview-selected', function() {
                    self.pausePlayers();
                } );
            } );
        },

        edit: function( text, update ) {
            var type = this.type,
                frame = media[ type ].edit( text );

            this.pausePlayers && this.pausePlayers();

            _.each( this.state, function( state ) {
                frame.state( state ).on( 'update', function( selection ) {
                    update( media[ type ].shortcode( selection ).string(), type === 'audio' );
                } );
            } );

            frame.on( 'close', function() {
                frame.detach();
            } );

            frame.open();
        },

        pausePlayers: function() {
            this.getNodes( function( editor, node, content ) {
                var win = $( 'iframe.wpview-sandbox', content ).get( 0 );

                if ( win && ( win = win.contentWindow ) && win.mejs ) {
                    _.each( win.mejs.players, function( player ) {
                        try {
                            player.pause();
                        } catch ( e ) {}
                    } );
                }
            } );
        }
    };
    if ( defaultOptions.audio_override ) {
		views.unregister( 'audio' );
        views.register( 'audio', wvplAudio );
		// views.unregister( 'playlist' );
        // views.register( 'playlist', wvplAudio );
    }

    media.view.Settings.Waveplayer = media.view.Settings.extend({
        className: 'waveplayer-settings',
        template:  wp.template('waveplayer-settings'),
    });

    media.waveplayer = new media.collection({
        tag: 'waveplayer',
        editTitle : media.view.l10n.editWaveplayerTitle,
        defaults : {
            id: media.view.settings.post.id,
            url:                    '',
            catergories:            '',
            wave_color:             defaultOptions.wave_color,
            wave_color_2:           defaultOptions.wave_color_2,
            progress_color:         defaultOptions.progress_color,
            progress_color_2:       defaultOptions.progress_color_2,
            cursor_color:           defaultOptions.cursor_color,
            cursor_color_2:         defaultOptions.cursor_color_2,
            cursor_width:           defaultOptions.cursor_width,
            hover_opacity:          defaultOptions.hover_opacity,
            gap_width:              defaultOptions.gap_width,
            wave_mode:              defaultOptions.wave_mode,
            wave_compression:       defaultOptions.wave_compression,
            wave_asymmetry:         defaultOptions.wave_asymmetry,
            size:                   defaultOptions.size,
            style:                  defaultOptions.style,
            info:                   defaultOptions.info,
            shape:                  defaultOptions.shape,
            autoplay:               defaultOptions.autoplay,
            repeat_all:             defaultOptions.repeat_all,
            shuffle:                defaultOptions.shuffle,
        },
    });

    media.controller.WavePlayerUrl = media.controller.State.extend({
        defaults: {
            id:       'waveplayerUrl',
            title:    media.view.l10n.insertFromUrlTitle,
            content:  'waveplayerUrl',
            menu:     'default',
            toolbar:  'main-embed',
            SettingsView:   media.view.Settings.Waveplayer,
            priority: 120,
            type:     'link',
            url:      '',
            metadata: {}
        },

        initialize: function(options) {
            this.metadata = options.metadata;
            this.props = new Backbone.Model( this.metadata || { url: '' });
            this.on( 'content:render:waveplayerUrl', this.renderSettings, this );
        },

        renderSettings: function( view ) {
            var library = this.get('library'),
                collectionType = this.get('collectionType'),
                dragInfoText = this.get('dragInfoText'),
                SettingsView = this.get('SettingsView'),
                obj = {};

            if ( ! library || ! view ) {
                return;
            }

            library[ collectionType ] = library[ collectionType ] || new Backbone.Model();

            obj[ collectionType ] = new SettingsView({
                controller: this,
                model:      library[ collectionType ],
                priority:   40
            });

            view.sidebar.set( obj );

        },

    });

    media.view.WavePlayerUrl = media.View.extend({
        className: 'media-waveplayer-url',

        initialize: function() {

            this.url = new media.view.EmbedUrl({
                tagName:   'label',
                className: 'waveplayer-url',
                controller: this.controller,
                model:      this.model.props
            }).render();

            this.views.set([ this.url ]);
        },

    });

    var postMediaFrame = media.view.MediaFrame.Post;
    media.view.MediaFrame.Post = postMediaFrame.extend({

        initialize: function() {
            var options = this.options;
            postMediaFrame.prototype.initialize.apply( this, arguments );

            this.options.lastNonUrlMode = 'browse';
            this.on( 'close', this.fixMode, this );

            this.states.add([
                new media.controller.Library({
                    id:         'waveplayer',
                    title:      media.view.l10n.createWaveplayerTitle,
                    priority:   60,
                    toolbar:    'main-waveplayer',
                    filterable: 'uploaded',
                    multiple:   'add',
                    editable:   false,

                    library:  media.query( _.defaults({
                        type: 'audio'
                    }, options.library ) )
                }),

                // Waveplayer states.
                new media.controller.CollectionEdit({
                    type: 'audio',
                    collectionType: 'waveplayer',
                    title:          media.view.l10n.editWaveplayerTitle,
                    SettingsView:   media.view.Settings.Waveplayer,
                    library:        options.selection,
                    editing:        options.editing,
                    menu:           'waveplayer',
                    dragInfoText:   media.view.l10n.waveplayerDragInfo,
                    dragInfo:       false,
                }),

                new media.controller.CollectionAdd({
                    type:           'audio',
                    collectionType: 'waveplayer',
                    title:          media.view.l10n.addToWaveplayerTitle,
                }),

                new media.controller.WavePlayerUrl({
                    id:             'waveplayer-addFromUrl',
                    collectionType: 'waveplayer',
                    title:          media.view.l10n.createWaveplayerFromURLTitle,
                    metadata:       this.options.metadata,
                    toolbar:        'waveplayer-addFromUrl',
                    menu:           'waveplayerUrl',
                    content:        'waveplayerUrl',
                    SettingsView:   media.view.Settings.Waveplayer,
                    library:        options.selection,
                    editing:        options.editing,
                    url:            options.url,
                })

            ]);

        },

        bindHandlers: function() {
            var handlers, checkCounts;

            postMediaFrame.prototype.bindHandlers.apply( this, arguments );

            this.on( 'menu:create:waveplayer', this.createMenu, this );
            this.on( 'menu:create:waveplayerUrl', this.createMenu, this );
            this.on( 'toolbar:create:main-waveplayer', this.createToolbar, this );
            this.on( 'content:activate:waveplayerUrl', this.activateUrl, this );
            this.on( 'ready activate', this.waveplayerColorPicker, this );

            handlers = {
                menu: {
                    'waveplayer':       'waveplayerMenu',
                    'waveplayerUrl':       'waveplayerMenu',
                },

                router: {
                    'browse':           'waveplayerRouter',
                },

                content: {
                    'waveplayerUrl':    'waveplayerUrlContent',
                },

                toolbar: {
                    'main-waveplayer':      'waveplayerMainToolbar',
                    'waveplayer-edit':	    'waveplayerEditToolbar',
                    'waveplayer-add':	    'waveplayerAddToolbar',
                    'waveplayer-addFromUrl':'waveplayerAddFromUrlToolbar',
                },

            };

            _.each( handlers, function( regionHandlers, region ) {
                _.each( regionHandlers, function( callback, handler ) {
                    this.on( region + ':render:' + handler, this[ callback ], this );
                }, this );
            }, this );
        },

        waveplayerMenu: function( view ) {
            var lastState = this.lastState(),
                previous = lastState && lastState.id,
                frame = this;

            view.set({
                cancel: {
                    text:     media.view.l10n.cancelWaveplayerTitle,
                    priority: 20,
                    click:    function() {
                        if ( previous ) {
                            frame.setState( previous );
                        } else {
                            frame.close();
                        }
                    }
                },
                separateCancel: new media.View({
                    className: 'separator',
                    priority: 40
                })
            });

        },

        waveplayerRouter: function( view ) {

            var state = this.state(),
                mode = this.content.mode(),
                item = view.get( 'addFromUrl' );

            if ( 'waveplayer' === state.id ) {
                if ( ! item ) {
                    view.set({
                        addFromUrl: {
                            text: media.view.l10n.addWaveplayerFromURLTitle,
                            priority: 60,
                            click: function() {
                                this.controller.setState('waveplayer-addFromUrl');
                            },
                        },
                    });
                } else {
                    view.show( 'addFromUrl' );
                }
            } else {
                view.hide( 'addFromUrl' );
                if ( mode == 'addFromUrl') this.content.mode( this.options.lastNonUrlMode );
            }
        },

        activateUrl: function() {
            var state = this.state(),
                library = state.get('library'),
                collectionType = state.get('collectionType'),
                SettingsView = state.get('SettingsView'),
                obj = {};

            obj[ collectionType ] = new SettingsView({
                controller: this,
                model:      library[ collectionType ],
                priority:   40
            });

            this.content.get( 'waveplayerUrl' ).sidebar.set( obj );

        },

        waveplayerUrlContent: function() {
            var view = new media.view.WavePlayerUrl({
                controller: this,
                model:      this.state(),
            }).render();

            this.content.set( view );

            if ( ! media.isTouchDevice ) {
                view.url.focus();
            }

            var state = this.state(),
                library = state.get('library'),
                collectionType = state.get('collectionType'),
                SettingsView = state.get('SettingsView'),
                sidebar = view.sidebar = new media.view.Sidebar({
                    controller: this,
                }),
                obj = {};

            view.views.add( sidebar );

            library[ collectionType ] = library[ collectionType ] || new Backbone.Model();

            obj[ collectionType ] = new SettingsView({
                controller: this,
                model:      library[ collectionType ],
                priority:   40
            });

            view.sidebar.set( obj );
        },

        waveplayerMainToolbar: function( view ) {
            var controller = this;

            this.selectionStatusToolbar( view );

            view.set( 'waveplayer', {
                style:    'primary',
                text:     media.view.l10n.createNewWaveplayer,
                priority: 100,
                requires: { selection: true },

                click: function() {
                    var selection = controller.state().get('selection'),
                        edit = controller.state('waveplayer-edit'),
                        models = selection.where({ type: 'audio' });

                    edit.set( 'library', new media.model.Selection( models, {
                        props:    selection.props.toJSON(),
                        multiple: true
                    }) );

                    this.controller.setState('waveplayer-edit');

                    // Keep focus inside media modal
                    // after jumping to playlist view
                    this.controller.modal.focusManager.focus();
                }
            });
        },

        waveplayerEditToolbar: function() {
            var editing = this.state().get('editing');
            this.toolbar.set( new media.view.Toolbar({
                controller: this,
                items: {
                    insert: {
                        style:    'primary',
                        text:     editing ? media.view.l10n.updateWaveplayer : media.view.l10n.insertWaveplayer,
                        priority: 80,
                        requires: { library: true },

                        /**
                         * @fires media.controller.State#update
                         */
                        click: function() {
                            var controller = this.controller,
                                state = controller.state();

                            controller.close();
							editing ?
								state.trigger( 'update', state.get('library') ) :
								media.editor.insert( media.waveplayer.shortcode(state.get('library')).string() );

                            // Restore and reset the default state.
                            controller.setState( controller.options.state );
                            controller.reset();
                        }
                    }
                }
            }) );
        },

        waveplayerAddToolbar: function() {
            this.toolbar.set( new media.view.Toolbar({
                controller: this,
                items: {
                    insert: {
                        style:    'primary',
                        text:     media.view.l10n.addToWaveplayer,
                        priority: 80,
                        requires: { selection: true },

                        /**
                         * @fires media.controller.State#reset
                         */
                        click: function() {
                            var controller = this.controller,
                                state = controller.state(),
                                edit = controller.state('waveplayer-edit');

                            edit.get('library').add( state.get('selection').models );
                            state.trigger('reset');
                            controller.setState('waveplayer-edit');
                        }
                    }
                }
            }) );
        },

        waveplayerAddFromUrlToolbar: function() {
            var editing = this.state().get('editing');
            this.toolbar.set( new media.view.Toolbar({
                controller: this,
                items: {
                    insert: {
                        style:    'primary',
                        text:     editing ? media.view.l10n.updateWaveplayer : media.view.l10n.insertWaveplayer,
                        priority: 80,

                        click: function() {
                            var controller = this.controller,
                                state = controller.state(),
                                library = state.get('library');

                            controller.close();

                            var wvplUrl = new wp.shortcode({
                                tag: 'waveplayer',
                                type: 'single',
                                attrs: _.extend( state.props.attributes, _.omit(library.waveplayer.attributes, 'url' ) ),
                            });

							editing ?
								state.trigger( 'update', wvplUrl.string() ) :
								media.editor.insert( wvplUrl.string() );

                            // Restore and reset the default state.
                            controller.setState( controller.options.state );
                            controller.reset();
                        }
                    }
                }
            }) );

        },

        waveplayerColorPicker: function() {
            if ( $('.waveplayer-color-picker').length ) {
                $('.waveplayer-color-picker').wpColorPicker({
                    change: function(event, ui){
                        $(event.target).attr('value',ui.color.toString()).change();
                    }
                });
            }
        }

    });

})(window, window.wp.mce.views, window.wp.media, window.jQuery);
