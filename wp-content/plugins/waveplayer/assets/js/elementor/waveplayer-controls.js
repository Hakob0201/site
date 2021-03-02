"use strict"

class ColorPicker extends elementorModules.Module {
	constructor( ...args ) {
		super( ...args );

		this.createPicker();
	}

	getColorPickerPalette() {
		return _.pluck( elementor.schemes.getScheme( 'color-picker' ).items, 'value' );
	}

	getDefaultSettings() {
		return {
			picker: {
				theme: 'monolith',
				position: 'bottom-' + ( elementorCommon.config.isRTL ? 'end' : 'start' ),
				components: {
					opacity: true,
					hue: true,
					interaction: {
						input: true,
						clear: true,
					},
				},
				strings: {
					clear: elementor.translate( 'clear' ),
				},
			},
			classes: {
				active: 'elementor-active',
				swatchTool: 'elementor-color-picker__swatch-tool',
				swatchPlaceholder: 'elementor-color-picker__swatch-placeholder',
				addSwatch: 'elementor-color-picker__add-swatch',
				droppingArea: 'elementor-color-picker__dropping-area',
				plusIcon: 'eicon-plus',
				trashIcon: 'eicon-trash-o',
				dragToDelete: 'elementor-color-picker__dropping-area__drag-to-delete',
			},
			selectors: {
				swatch: '.pcr-swatch',
			},
		};
	}

	createPicker() {
		const pickerSettings = this.getSettings( 'picker' );

		pickerSettings.default = pickerSettings.default || null;

		this.picker = new Pickr( pickerSettings );

		if ( ! pickerSettings.default ) {
			this.picker.setColor( '#020101' );
		}

		this.color = this.processColor();

		this.picker
			.on( 'change', () => this.onPickerChange() )
			.on( 'clear', () => this.onPickerClear() )
			.on( 'show', () => this.onPickerShow() );

		this.addPlusButton();

		this.addSwatchDroppingArea();

		this.addToolsToSwatches();
	}

	processColor() {
		const color = this.picker.getColor();

		let colorRepresentation;

		if ( 1 === color.a ) {
			colorRepresentation = color.toHEXA();
		} else {
			colorRepresentation = color.toRGBA();
		}

		return colorRepresentation.toString( 0 );
	}

	getColor() {
		return this.color;
	}

	getSwatches() {
		return jQuery( this.picker.getRoot().swatches );
	}

	addSwatch( color ) {
		this.picker.addSwatch( color );
	}

	addSwatches() {
		const settings = this.getSettings();

		this.getSwatches().children( settings.selectors.swatch ).remove();

		this.picker._swatchColors = [];

		this.getColorPickerPalette().forEach( ( swatch ) => this.addSwatch( swatch ) );

		this.getSwatches().sortable( {
			items: '.pcr-swatch',
			placeholder: settings.classes.swatchPlaceholder,
			connectWith: this.$droppingArea,
			delay: 200,
			start: ( ...args ) => this.onSwatchesSortStart( ...args ),
			stop: () => this.onSwatchesSortStop(),
			update: ( ...args ) => this.onSwatchesSortUpdate( ...args ),
		} );

		this.addToolsToSwatches();
	}

	addPlusButton() {
		const { classes } = this.getSettings();

		this.$addButton = jQuery( '<button>', { class: classes.swatchTool + ' ' + classes.addSwatch } ).html( jQuery( '<i>', { class: classes.plusIcon } ) );

		this.$addButton.on( 'click', () => this.onAddButtonClick() );

		this.$addButton.tipsy( {
			title: () => elementor.translate( 'add_picked_color' ),
			gravity: () => 's',
		} );
	}

	addSwatchDroppingArea() {
		const { classes } = this.getSettings();

		this.$droppingArea = jQuery( '<div>', { class: classes.droppingArea } ).html( jQuery( '<i>', { class: classes.trashIcon } ) );

		this.getSwatches().after( this.$droppingArea );

		this.$droppingArea.sortable( {
			cancel: '.eicon-trash-o',
			placeholder: classes.swatchPlaceholder,
			over: () => this.onDroppingAreaOver(),
			out: () => this.onDroppingAreaOut(),
		} );

		if ( ! this.introductionViewed() ) {
			const $dragToDelete = jQuery( '<div>', { class: classes.dragToDelete } ).text( elementor.translate( 'drag_to_delete' ) );

			this.$droppingArea.append( $dragToDelete ).slideDown();

			elementorCommon.ajax.addRequest( 'introduction_viewed', {
				data: {
					introductionKey: 'colorPickerDropping',
				},
			} );

			ColorPicker.droppingIntroductionViewed = true;
		}
	}

	addToolsToSwatches() {
		this.getSwatches().append( this.$addButton );

		this.picker.activateSwatch();
	}

	destroy() {
		this.picker.destroyAndRemove();
	}

	fixTipsyForFF( $button ) {
		$button.data( 'tipsy' ).hide();
	}

	introductionViewed() {
		return ColorPicker.droppingIntroductionViewed || elementor.config.user.introduction.colorPickerDropping;
	}

	onPickerChange() {
		this.picker.applyColor();

		const newColor = this.processColor();

		if ( newColor === this.color ) {
			return;
		}

		this.color = newColor;

		const onChange = this.getSettings( 'onChange' );

		if ( onChange ) {
			onChange();
		}
	}

	onPickerClear() {
		this.color = '';

		const onClear = this.getSettings( 'onClear' );

		if ( onClear ) {
			onClear();
		}
	}

	onPickerShow() {
		this.addSwatches();

		const { result: resultInput } = this.picker.getRoot().interaction;

		setTimeout( () => {
			resultInput.select();

			this.picker._recalc = true;
		}, 100 );
	}

	onAddButtonClick() {
		this.addSwatch( this.color );

		this.addToolsToSwatches();

		elementor.schemes.addSchemeItem( 'color-picker', { value: this.color } );

		elementor.schemes.saveScheme( 'color-picker' );

		this.fixTipsyForFF( this.$addButton );
	}

	onDroppingAreaOver() {
		this.$droppingArea.addClass( this.getSettings( 'classes.active' ) );
	}

	onDroppingAreaOut() {
		this.$droppingArea.removeClass( this.getSettings( 'classes.active' ) );
	}

	onSwatchesSortStart( event ) {
		this.sortedSwatchIndex = jQuery( event.srcElement ).index();

		this.$droppingArea.slideDown( () => this.$droppingArea.sortable( 'refresh' ) );
	}

	onSwatchesSortStop() {
		this.$droppingArea.slideUp();
	}

	onSwatchesSortUpdate( event ) {
		// Sample the scheme before removing
		const sortedScheme = elementor.schemes.getSchemeValue( 'color-picker', this.sortedSwatchIndex + 1 );

		elementor.schemes.removeSchemeItem( 'color-picker', this.sortedSwatchIndex );

		const $sortedSwatch = jQuery( event.srcElement );

		if ( $sortedSwatch.parent().is( this.$droppingArea ) ) {
			this.picker._swatchColors.splice( this.sortedSwatchIndex, 1 );

			$sortedSwatch.remove();
		} else {
			elementor.schemes.addSchemeItem( 'color-picker', sortedScheme, $sortedSwatch.index() );
		}

		elementor.schemes.saveScheme( 'color-picker' );
	}
}

elementor.addControlView(
    'ColorTuplet',
    elementor.modules.controls.BaseMultiple.extend({
        ui: function ui() {
            var ui = elementor.modules.controls.BaseMultiple.prototype.ui.apply(this, arguments);
            ui.colorPickerPlaceholder = '.elementor-color-picker-placeholder';
            return ui;
        },
        initColors: function initColors() {
            var _this2 = this;

            this.colorPicker1 = new ColorPicker({
                picker: {
                    el: this.ui.colorPickerPlaceholder[0],
                    default: this.getControlValue( this.model.get( 'name' ) )
                },
                onChange: function onChange() {
                    _this2.setValue(_this2.model.attributes.name, _this2.colorPicker1.getColor());
                },
                onClear: function onClear() {
                    _this2.setValue(_this2.model.attributes.name, '');
                }
            });
            this.colorPicker2 = new ColorPicker({
                picker: {
                    el: this.ui.colorPickerPlaceholder[1],
                    default: this.getControlValue( this.model.get( 'name' ) + '_2' )
                },
                onChange: function onChange() {
                    _this2.setValue(`${_this2.model.attributes.name}_2`, _this2.colorPicker2.getColor());
                },
                onClear: function onClear() {
                    _this2.setValue(`${_this2.model.attributes.name}_2`, '');
                }
            });

        },
        onReady: function onReady() {
            this.initColors();
        },
        onBeforeDestroy: function onBeforeDestroy() {
            this.colorPicker1.destroy();
            this.colorPicker2.destroy();
        }
    })
)

elementor.addControlView(
    'Playlist',
    elementor.modules.controls.BaseData.extend({
        ui: function ui() {
            var ui = elementor.modules.controls.BaseData.prototype.ui.apply(this, arguments);
            ui.addTracks = '.elementor-control-playlist-add';
            ui.clearPlaylist = '.elementor-control-playlist-clear';
            ui.playlistThumbnails = '.elementor-control-playlist-thumbnails';
            ui.status = '.elementor-control-playlist-status-title';
            return ui;
        },
        events: function events() {
            return _.extend(elementor.modules.controls.BaseData.prototype.events.apply(this, arguments), {
                'click @ui.addTracks': 'onAddTracksClick',
                'click @ui.clearPlaylist': 'onClearPlaylistClick',
                'click @ui.playlistThumbnails': 'onPlaylistThumbnailsClick'
            });
        },
        onReady: function onReady() {
            this.initRemoveDialog();
        },
        applySavedValue: function applySavedValue() {
            var tracks = this.getControlValue(),
            tracksCount = tracks.length,
            hasTracks = !!tracksCount;
            this.$el.toggleClass('elementor-playlist-has-tracks', hasTracks).toggleClass('elementor-playlist-empty', !hasTracks);
            this.ui.status.text(elementor.translate(hasTracks ? 'playlist_tracks_selected' : 'playlist_no_tracks_selected', [tracksCount]));
            this.ui.playlistThumbnails.empty()

            if (!hasTracks) {
                return;
            }

            var attachments = wp.media.query({
                orderby: 'post__in',
                order: 'ASC',
                type: 'audio',
                perPage: -1,
                post__in: _.pluck(tracks, 'id')
            });
            attachments.more().done( () => {
                this.buildThumbnails( attachments )
            })
        },

        buildThumbnails: function buildThumbnails( attachments ) {
            var $playlistThumbnails = this.ui.playlistThumbnails;
            this.getControlValue().forEach(function (track) {
                var $thumbnail = jQuery('<div>', {
                    class: 'elementor-control-playlist-thumbnail'
                });
                const trackAttachment = Object.values(attachments.models).find( (m) => m.id === track.id )
                if ( trackAttachment ) {
                    if ( trackAttachment.attributes && trackAttachment.attributes.thumb )
                        $thumbnail.css('background-image', 'url(' + trackAttachment.attributes.thumb.src + ')');
                }
                $playlistThumbnails.append($thumbnail);
            });
        },

        hasTracks: function hasTracks() {
            return !!this.getControlValue().length;
        },
        openFrame: function openFrame(action) {
            this.initFrame(action);
            this.frame.open();
        },
        initFrame: function initFrame(action) {
            var frameStates = {
                create: 'playlist',
                add: 'playlist-library',
                edit: 'playlist-edit'
            };
            var options = {
                frame: 'post',
                multiple: true,
                state: frameStates[action],
                button: {
                    text: elementor.translate('insert_tracks')
                }
            };

            if (this.hasTracks()) {
                options.selection = this.fetchSelection();
            }

            this.frame = wp.media(options); // When a file is selected, run a callback.

            this.frame.on({
                update: this.select,
                'menu:render:default': this.menuRender,
                'content:render:browse': this.playlistSettings
            }, this);
        },
        menuRender: function menuRender(view) {
            view.unset('insert');
            view.unset('featured-image');
        },
        playlistSettings: function playlistSettings(browser) {
            browser.sidebar.on('ready', function () {
                browser.sidebar.unset('playlist');
            });
        },
        fetchSelection: function fetchSelection() {
            var attachments = wp.media.query({
                orderby: 'post__in',
                order: 'ASC',
                type: 'audio',
                perPage: -1,
                post__in: _.pluck(this.getControlValue(), 'id')
            });
            return new wp.media.model.Selection(attachments.models, {
                props: attachments.props.toJSON(),
                multiple: true
            });
        },

        /**
        * Callback handler for when an attachment is selected in the media modal.
        * Gets the selected track information, and sets it within the control.
        */
        select: function select(selection) {
            var tracks = [];
            selection.each(function (track) {
                tracks.push({
                    id: track.get('id'),
                    url: track.get('url')
                });
            });
            this.setValue(tracks);
            this.applySavedValue();
        },
        onBeforeDestroy: function onBeforeDestroy() {
            if (this.frame) {
                this.frame.off();
            }

            this.$el.remove();
        },
        resetPlaylist: function resetPlaylist() {
            this.setValue([]);
            this.applySavedValue();
        },
        initRemoveDialog: function initRemoveDialog() {
            var removeDialog;

            this.getRemoveDialog = function () {
                if (!removeDialog) {
                    removeDialog = elementorCommon.dialogsManager.createWidget('confirm', {
                        message: elementor.translate('dialog_confirm_playlist_delete'),
                        headerMessage: elementor.translate('delete_playlist'),
                        strings: {
                            confirm: elementor.translate('delete'),
                            cancel: elementor.translate('cancel')
                        },
                        defaultOption: 'confirm',
                        onConfirm: this.resetPlaylist.bind(this)
                    });
                }

                return removeDialog;
            };
        },
        onAddTracksClick: function onAddTracksClick() {
            this.openFrame(this.hasTracks() ? 'add' : 'create');
        },
        onClearPlaylistClick: function onClearPlaylistClick() {
            this.getRemoveDialog().show();
        },
        onPlaylistThumbnailsClick: function onPlaylistThumbnailsClick() {
            this.openFrame('edit');
        }
    })
)
