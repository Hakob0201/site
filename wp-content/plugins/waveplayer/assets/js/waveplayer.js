"use strict"

const WVPL_MAX_FAILED_ATTEMPTS = 5

let microStart = 0

class WVPLEngine {

    constructor(win) {
        this.setVars(win)
        this.setupObservers()
        this.active = true
        this.instances = []
        this.currentId
        this.currentInstance = null
        this.failedAttempts = 0
        this.peakLength = 1920
        this.setupAudioEngine()
        this.setupAnimationFrame()
        this.node = document.querySelector('#wvpl-sticky-player')
        this.stickyPlayerInit()
        this.navigatorInit()
        this.loadInstances()
        this.setCurrentInstance()
        this.start()
    }

    setupAudioEngine( audioType ) {
		this.setAudioType( audioType )
        this.webAudio = new Audio()
		this.webAudio.preload = 'metadata'
		this.webAudio.crossOrigin = "anonymous";
        this.mediaElement = new Audio()
        this.mediaElement.preload = 'metadata'
		this.volume = 1
        this.muted = false
		delete this.audioCtx
		delete this.gain
		delete this.analyserGain
		delete this.scriptNode
		if ( this.isWebAudio() ) {
			this.audioCtx = new (window.AudioContext || window.webkitAudioContext)()
			this.gain = this.audioCtx.createGain()
			this.analyserGain = this.audioCtx.createGain()
			this.scriptNode = this.audioCtx.createScriptProcessor(2048, 1, 1)
	        this.scriptNode.onaudioprocess = this.onAudioProcess.bind(this)
	        this.createSource()
	        this.setSmoothingTimeConstant( parseFloat( this.getOption('wave_animation') || 1) )
		}
		this.addEvents()
    }

    setAudioType( audioType ) {
		audioType = audioType || 'WebAudio'
		this.audioType = audioType

	    if ( navigator && navigator.appVersion ) {
	        if ( navigator.appVersion.indexOf('OS 13_') >= 0 && this.getOption('force_ios_media_element') ) {
				this.audioType = 'MediaElement'
				return
			}
			if ( navigator.appVersion.indexOf('OS 14_') >= 0 && this.getOption('force_ios_media_element') ) {
                this.audioType = 'MediaElement'
                return
            }
        }
        if ( this.isSafari() && this.getOption('force_safari_media_element') ) {
            this.audioType = 'MediaElement'
            return
        }
    }

	isWebAudio() {
		return (this.audioType === 'WebAudio')
	}

	isMediaElement() {
		return (this.audioType !== 'WebAudio')
	}

	audio() {
		return ( this.isWebAudio() ? this.webAudio : this.mediaElement )
	}

    setupAnimationFrame() {
        this.requestAnimationFrame = window.requestAnimationFrame       ||
                       window.webkitRequestAnimationFrame ||
                       window.mozRequestAnimationFrame    ||
                       function(callback, element){
                           window.setTimeout(callback, 1000 / 30)
                       }

        this.cancelAnimationFrame = window.cancelAnimationFrame     ||
                       window.mozCancelAnimationFrame
    }

    setupObservers() {
        this.setupInstanceObserver()
        this.setupVariationFormObserver()
    }

    setupInstanceObserver() {
        const config = { attributes: false, childList: true, subtree: true }
        this.instanceObserver = new MutationObserver( (mutationList, observer) => {
            mutationList.forEach( (mutation) => {
                if ( mutation.target.querySelector('.waveplayer:not(.active)') ) {
                    this.loadInstances()
                }
            })
        })
        this.instanceObserver.observe(document.body, config)
    }

    setupVariationFormObserver() {
        if ( !this.vars.wc_version )
            return

        if ( !document.querySelector('#wvpl-variation-popup') ) {
            this.variationPopup = document.createElement('div')
            this.variationPopup.id = 'wvpl-variation-popup'
            this.variationPopup.classList.add('woocommerce', 'single-product')
            document.body.appendChild(this.variationPopup)
        }
        this.variationPopup.innerHTML = ''
        if ( !this.variationPopupOvserver ) {
            const config = { attributes: true, childList: true, subtree: true }
            this.variationPopupOvserver = new MutationObserver( this.variationFormCallback )
            this.variationPopupOvserver.observe(this.variationPopup, config)
        }
        const variationForm = document.createElement('div')
        variationForm.classList.add('product', 'wvpl-variation-form')
        jQuery(variationForm).on('wc_variation_form', (event) => {
            document.body.classList.add('wvpl-variation-popup')
        })
        this.variationPopup.append(variationForm)
    }

    setVars(win) {
        this.vars = win.wvplVars
        this.__ = win.wp.i18n.__
        this._n = win.wp.i18n._n
        this.template = win.lodash.template
    }

	isSafari() {
		return ( navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
                 navigator.userAgent &&
                 navigator.userAgent.indexOf('CriOS') == -1 &&
                 navigator.userAgent.indexOf('FxiOS') == -1 )
	}

    isDocumentHidden() {
        if ( document.hidden !== undefined )
            return document.hidden

        if ( document.msHidden !== undefined )
            return document.msHidden

        if ( document.webkitHidden !== undefined )
            return document.webkitHidden

        return false
    }

    getInstanceById( id ) {
        id = id || this.getCurrentId()
        return this.instances.find( i => i.id === id )
    }

    nextInstance() {
        const instancesInDOM = this.getVisibleInstancesInDOM()
        let index = this.getCurrentIndex()
        if ( index < 0 )
            return instancesInDOM[0];
        index++
        if ( index >= this.instances.length )
            return false

        return instancesInDOM[index]
    }

    prevInstance() {
        const instancesInDOM = this.getVisibleInstancesInDOM()
        let index = this.getCurrentIndex()
        if ( index < 0 )
            return false;
        index--
        if ( index < 0 )
            return false

        return instancesInDOM[index]
    }

    addInstance( player, tracks, nonce ) {
        const foundId = this.instances.find( i => i.id === player.dataset.instance_id )
        if ( !foundId ) {
            for ( const track of tracks ) {
				if ( track.peaks && ! Array.isArray( track.peaks ) ) {
                	track.peaks = this.readPeaks( track.peaks )
				}
            }
            const instance = new WVPLInstance( player, tracks, nonce, this )
            this.instances.push(instance)
        }
    }

    removeInstance( id ) {
        const instance = this.getInstanceById( id )
        if ( instance ) {
            const index = this.getCurrentIndex( id )
            this.instances.splice( index, 1 )
        }
    }

    getElement( id ) {
        id = id || this.getCurrentId()
        return document.getElementById( id )
    }

    getOption( option ) {
        return this.vars.options[option]
    }

	setOption( option, value ) {
		this.vars.options[option] = value
		this.redrawAllInstances()
	}

    getInstancesInDOM() {
        if ( this.instances )
            return this.instances.filter( i => document.querySelector(`.waveplayer[data-instance_id="${i.id}"]`) )
    }

	getVisibleInstancesInDOM() {
		const instances = this.getInstancesInDOM()
		return instances.filter( i => i.node.offsetParent )
	}

	getFirstInstanceInDOM() {
		const instances = this.getVisibleInstancesInDOM()
		if ( ! instances ) {
			return null
		}
		return instances[0]
	}

    getCurrentId() {
        const instance = this.getFirstInstanceInDOM()
        return this.currentId || instance.id
    }

    isInstanceInDOM( id ) {
        id = id || this.currentId
        return this.getInstancesInDOM().find( i => i.id === id )
    }

    getCurrentInstance() {
        if ( this.currentId === undefined )
            return this.getFirstInstanceInDOM()

        return this.instances.find( i => i.id === this.currentId )
    }

    setCurrentInstance( instance, skipping ) {
        instance = instance || this.getFirstInstanceInDOM()
        if ( !instance )
            return
        if ( !this.currentId || skipping ) {
            const currentInstance = this.getCurrentInstance()
            if ( currentInstance ) {
				currentInstance.stop()
			}
            this.currentId = instance.id
        }
		if ( this.node ) {
			this.node.dataset.instance_id = instance.id
		}

        this.redrawAllInstances()
    }

    start() {
		const e = new CustomEvent( 'waveplayer.engine.ready', { detail: { engine: this } } )
	    document.dispatchEvent( e )

		this.redrawAllInstances()
        let instance = this.getVisibleInstancesInDOM().find( i => i.autoplay )
        if ( this.getOption( 'autoplay' ) ) {
			instance = this.getFirstInstanceInDOM()
		}

        if ( instance ) {
			if ( instance.node.classList.contains('wvpl-rendered') ) {
				instance.play()
			} else {
				instance.playerInit( true )
			}
		}
    }

    getCurrentIndex( id ) {
        id = id || this.currentId
        return this.getVisibleInstancesInDOM().findIndex( (i) => { return i.id === id } )
    }

	getTrack( index ) {
		return this.getCurrentInstance().getTrack(index)
    }

    getCurrentTrack() {
        return this.getTrack();
    }

    getCurrentTrackIndex() {
        return this.getCurrentInstance().getCurrentTrackIndex();
    }

    getColorStyleFromPalette( colorCodes ) {
        const props = [ 'fc', 'fc-s', 'bc', 'bc-s', 'hc', 'hc-s', 'wc', 'wc-s', 'pc', 'pc-s', 'cc', 'cc-s']
        let colorStyle = {}
        for( const index in props ) {
            const rgb = [
                parseInt( `0x${colorCodes[index].slice(0,2)}` ),
                parseInt( `0x${colorCodes[index].slice(2,4)}` ),
                parseInt( `0x${colorCodes[index].slice(4,6)}` )
            ].join(', ')
            colorStyle[`--${props[index]}`] = rgb
        }
        return colorStyle
    }

	findTrack( value, key = 'id' ) {
		const track = this.instances.map( i => i.tracks ).flat().filter( t => String( t[key] ) === String( value ) )
		if ( track.length )
			return track[0]

		return false
	}

    skip( forward = true ) {

		if ( this.hasEnded ) {
			this.hasEnded = false
		} else {
			this.trigger( 'skip' )
		}

        const instance = this.getCurrentInstance(),
              prevInstance = this.prevInstance(),
              nextInstance = this.nextInstance(),
              isInstanceInDOM = this.isInstanceInDOM(),
              noInstancesInDOM = this.getInstancesInDOM().length === 0

        let newTrackIndex = instance.getCurrentTrackIndex() + ( forward ? 1 : -1 ),
            newInstance = instance,
            skipped = true

        if ( isInstanceInDOM || noInstancesInDOM ) {
            switch(true) {
                case ( newTrackIndex >= 0 && newTrackIndex < instance.getTrackCount() ):
                    break
				case ( forward && ( newTrackIndex >= instance.getTrackCount() ) && this.getOption('jump') && !!nextInstance ):
                    newTrackIndex = 0
                    newInstance = nextInstance
                    break
                case ( forward && ( newTrackIndex >= instance.getTrackCount() && !!instance.repeat ) ):
					newTrackIndex = 0
                    break
                case ( !forward && ( newTrackIndex < 0 ) && this.getOption('jump') && !!prevInstance ):
                    newInstance = prevInstance
                    newTrackIndex = prevInstance.getTrackCount() - 1
                    break
                default:
                    skipped = false
                    break
            }
        } else {
            newInstance = nextInstance
            newTrackIndex = 0
        }

        const switched = ( instance.id !== newInstance.id )
        if ( skipped ) {
            newInstance.mousePosition = -1
            if (newInstance.currentTrack >= 0 && newInstance.currentTrack < newInstance.getTrackCount())
                newInstance.updateStatistics()
            newInstance.currentTrack = newTrackIndex

			this.pause()
			.then( () => {
	            if ( switched ) {
					instance.stop()
					instance.reset()
	                newInstance.node.scrollIntoView({behavior: 'smooth', block: 'center'})
	                newInstance.waveRedraw()
	                this.setCurrentInstance( newInstance, true )
					newInstance.preloadTrack(true)
	            } else {
	                newInstance.preloadTrack(true)
	                this.setSkipState()
	            }
			})
        } else {
            newInstance.stop()
            newInstance.reset()
        }
    }

    applyTemplate( tmplString, track ) {
        const placeholders = document.querySelector('#tmpl-placeholders'),
              _this = this
        if ( !placeholders )
            return ''

        const {vars, template} = this

        tmplString = tmplString.replace(/(\{[^\}]*\})/g, function(match, $1){
            var att = JSON.parse($1)
            for ( let i in att ) {
                let e = att[i]
				if ( typeof(att[i]) == 'string' ) {
					att[i] = e.replace(/%([^%]+)%/g, function(match, $11){
						return (track[ $11 ] ? track[ $11 ] : '')
					})
				}
            }
            return JSON.stringify(att)
        })
        tmplString = tmplString.replace(/%([^ %\{]*)(\{[^\}]*\})*%/g, function(match, $1, $2){
            var key = $1,
                attributes = jQuery.extend({
                    class:'',
                    showValue: 1,
                    text: '',
                    raw: 0,
                    url: '',
                    target: '_blank',
                    icon: '',
                    event: '',
                    guests: true
                }, $2 ? JSON.parse($2) : '')
            try {
                const tmpl = template( placeholders.innerHTML )
                return tmpl( { key, attributes, track, loggedUser: (vars.currentUser.ID > 0), __: _this.__, _n: _this._n } )
            } catch(e) {
                return ''
                _this.log(e)
            }
        })
        return tmplString
    }

    toggleStickyPlayer( show = false ) {
        if ( !this.node )
            return

		const html = document.querySelector('html')
		if ( show && html.classList.contains('has-sticky-player') )
			return

        const position = this.getOption( 'sticky_player_position' )
        html.classList.toggle('has-sticky-player')
        html.classList.toggle(`has-sticky-player-${position}`)
        this.setSkipState()
    }

    hasStickyPlayer() {
        return document.querySelector('html').classList.contains('has-sticky-player')
    }

    updateStickyPlayerInfo() {
		if ( ! this.hasStickyPlayer() )
			return

        const instance = this.getCurrentInstance()
        if ( !instance )
            return

        const player = this.node,
              placeholders = this.getOption('sticky_template') || "%thumbnail% %title% %artist% %share%",
              track = instance.getTrack()

        if ( track ) {
            if ( player ) {
                player.querySelector('.wvpl-duration').textContent = track.length_formatted
                player.querySelector('.wvpl-position').textContent = this.secondsToTime()
				if ( track.length_formatted ) {
					player.querySelector('.wvpl-duration').style.width = ( `${track.length_formatted.length+1}ch` )
					player.querySelector('.wvpl-position').style.width = ( `${track.length_formatted.length+1}ch` )
				}

                const infobar = player.querySelector('.wvpl-trackinfo')
                infobar && ( infobar.innerHTML = this.applyTemplate(placeholders, track) )
            }

            if ('mediaSession' in navigator) {
                const metadata = {
                    title: track.title,
                    artist: track.artist,
                    album: track.album,
                }
                if ( track.poster )
                    metadata.artwork = [
                        { src: track.poster },
                    ]
                navigator.mediaSession.metadata = new MediaMetadata( metadata )
            }
        }
    }

    updateVariationForm( track ) {
        const variations = track.product_variations,
              variationForm = this.variationPopup.querySelector( '.wvpl-variation-form' )

        this.variationPopupOvserver.track = track
        variationForm.innerHTML = track.product_variations_form
		const closeButton = document.createElement('div')
        closeButton.classList.add('close-button')
		variationForm.prepend(closeButton)
		const $title = jQuery(`<h4>${track.product_title}</h4>`).get(0)
  		variationForm.prepend($title)
        closeButton.addEventListener('click', (event) => {
            document.body.classList.remove('wvpl-variation-popup')
			this.trigger('variationForm:close', {track})
        })
		this.trigger('variationForm:open', {track})
    }

    variationFormCallback( mutationsList, observer ) {
        for(let mutation of mutationsList) {
            if ( mutation.type === 'childList' && mutation.target.classList.contains('wvpl-variation-form') ) {
                const form = mutation.target.querySelector('.variations_form')
                if ( form ) {
                    jQuery(form).wc_variation_form()
                    const $table = jQuery(form).find('table'),
                          $clear = jQuery(form).find('a.reset_variations')
                    $clear.insertAfter($table)
                }
            }
        }
    }

    updateTrackCartStatus( productId, action = 'add' ) {
        const affectedInstances = this.instances.filter( i => i.tracks.find( t => t.product_id == productId ) )
        for( const instance of this.instances ) {
            const linkedTrack = instance.tracks.find( t => t.product_id == productId )
            if ( linkedTrack ) {
                linkedTrack.in_cart = action === 'add'
            }
        }
    }

    setSkipState() {
        const prevBtn = this.node && this.node.querySelector('.wvpl-prev'),
              nextBtn = this.node && this.node.querySelector('.wvpl-next'),
              instance = this.getCurrentInstance(),
              isPrevEnabled = instance && ( this.prevInstance() || instance.getCurrentTrackIndex() > 0 ),
              isNextEnabled = instance && ( this.nextInstance() || instance.getCurrentTrackIndex() < instance.getTrackCount() - 1 || instance.repeat )

        try {
            this.updateStickyPlayerInfo()
            prevBtn && prevBtn.classList.toggle( 'wvpl-disabled', !isPrevEnabled )
            nextBtn && nextBtn.classList.toggle( 'wvpl-disabled', !isNextEnabled )
            instance.setSkipState()
        } catch (e) {
            this.log( 'setSkipState (Engine)', e )
        }
    }

    createAnalyser() {
        if ( this.isMediaElement() )
            return
        this.analyser = this.audioCtx.createAnalyser()
        this.analyser.smoothingTimeConstant = parseFloat(this.getOption('wave_animation') || 1)
        this.analyser.maxDecibels = -30
        this.analyser.minDecibels = -90
        try {
            this.analyser.fftSize = 8192
        } catch(e) {
            this.analyser.fftSize = 2048
        }
        this.analyserGain.connect(this.analyser)
        this.analyser.connect(this.scriptNode)
    }

    destroyAnalyser() {
        if ( this.isMediaElement() )
            return
        this.analyserGain.disconnect(this.analyser)
        this.analyser.disconnect( this.scriptNode )
        this.analyser = null
        this.frequencyData = null
    }

    createSource() {
        if ( this.isMediaElement() )
            return
        this.source = this.audioCtx.createMediaElementSource(this.webAudio)
        this.source.connect(this.gain)
        this.source.connect(this.analyserGain)
        this.gain.connect(this.audioCtx.destination)
		this.source.connect(this.scriptNode)
		this.scriptNode.connect( this.audioCtx.destination )
		this.createAnalyser()
    }

    setCurrentTrack( track ) {
    }

    getCurrentTrack() {
        return this.getCurrentInstance().getCurrentTrack()
    }

    connectScriptNode() {
        if ( this.isMediaElement() )
            return
        this.audioCtx.resume().then( () => {
            try {
                this.source.connect(this.scriptNode)
                this.scriptNode.connect( this.audioCtx.destination )
                this.createAnalyser()
            } catch (e) {
                this.log('connectScriptNode', e)
            }
        })
    }

    disconnectScriptNode() {
        if ( this.isMediaElement() || this.isSafari() )
            return
        try {
            // this.source.disconnect(this.scriptNode)
            // this.scriptNode.disconnect( this.audioCtx.destination )
            this.destroyAnalyser()
        } catch (e) {
            this.log('disconnectScriptNode', e)
        }
    }

    onAudioProcess() {
        if ( this.isPaused() || this.isDocumentHidden() )
            return

        if ( this.isWebAudio() ) {
            var frequencyData = null
            if ( this.analyser && this.getOption('wave_animation') < 1 ) {
                this.frequencyData = new Uint8Array(this.analyser.frequencyBinCount)
                this.analyser.getByteFrequencyData(this.frequencyData)
            }
        }

        var instance = this.getCurrentInstance()
        if ( instance ) {
            this.afRequest = this.requestAnimationFrame.call( window, instance.timeUpdate.bind(instance) )
        }
    }

	async ajaxCall( action, postData = {} ) {
        const url = this.vars.wvpl_ajax_url.replace( '%%endpoint%%', action )
        const params = Object.keys(postData).map(
            key => encodeURIComponent(key) + '=' + encodeURIComponent(postData[key])
        ).join('&')

		try {
			const response = await fetch( url, {
				method: 'POST',
				headers: {
			        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
			    },
			    body: params,
			})
			try {
				const data = await response.json()
				return data
			} catch( error ) {
				this.log( error )
			}
		} catch ( error ) {
			this.log(error)
		}
    }

	async getAudioData( url, trackId, progressCallback ) {
		try {
			const response = await fetch(url)
			const filesize = response.headers.get('Content-Length')
			if ( ! filesize ) {
				const buffer = await response.arrayBuffer()
				return buffer
			} else {
				const array = new Uint8Array(filesize)
				let at = 0
				const reader = response.body.getReader()
				for (;;) {
					try {
						const {done, value} = await reader.read()
						if (done) {
							break
						}
						array.set(value, at)
						at += value.length
						progressCallback( at, filesize )
					} catch ( error ) {
						this.log( error )
						return false
					}
				}
				return array.buffer
			}
		} catch( error ) {
			this.log( error )
			return false
		}
    }

    decodeAudioData( data, callback ) {
        this.audioCtx.decodeAudioData( data, callback.bind(this) )
    }

    extractPeaks( buffer ) {
        const channels = buffer.numberOfChannels,
              sampleSize = buffer.length / this.peakLength,
              sampleStep = ~~( sampleSize / 10) || 1

        const peaks = []

        for (var c = 0; c < channels; c++) {
            const stepPeaks = []
            const chan = buffer.getChannelData(c)

            for (var i = 0; i < this.peakLength; i++) {
                var start = ~~(i * sampleSize)
                var end = ~~(start + sampleSize)
                var min = chan[0]
                var max = chan[0]

                for (var j = start; j < end; j += sampleStep) {
                    var value = chan[j]
                    if (value > max)
                        max = value
                    if (value < min)
                        min = value
                }
                stepPeaks[2 * i] = max
                stepPeaks[2 * i + 1] = min

                if (c == 0 || max > peaks[2 * i])
                    peaks[2 * i] = Math.abs( max.toFixed(2) )

                if (c == 0 || min < peaks[2 * i + 1])
                    peaks[2 * i + 1] = Math.abs( min.toFixed(2) )
            }
        }
        return peaks
    }

	readPeaks( peakData ) {
		return peakData.split(',').map( v => Number(v) )
	}

    loadInstances( container ) {
        container = container ? document.querySelector(container) : document
        let players = container.querySelectorAll('.waveplayer:not(.active)')
        if ( players.length ) {
            let listData = []
            let tracks,
				nonce
            for( let player of players) {
                this.removeInstance( player.dataset.instance_id )
                const instanceTrackData = document.querySelector(`#data-${player.dataset.instance_id}`)
                if ( instanceTrackData ) {
					if ( instanceTrackData.dataset.tracks ) {
						tracks = JSON.parse( atob(instanceTrackData.dataset.tracks) )
						nonce = instanceTrackData.dataset.nonce
	                    instanceTrackData.remove()
					}
                } else if ( player.dataset.tracks ) {
					tracks = JSON.parse( atob(player.dataset.tracks) )
					nonce = player.dataset.nonce
					player.removeAttribute('data-tracks')
                }
				if ( tracks && tracks.length > 0 )
					this.addInstance( player, tracks, nonce )
            }
        }
        this.redrawAllInstances()
    }

    reloadInstances( container ) {
		container = container || ''
        document.querySelectorAll(`${container} .waveplayer`).forEach( i => i.classList.remove('active') )
        this.instances = []
        this.loadInstances( container )
    }

    stickyPlayerInit() {
        if ( !this.node )
            return

        const waveform = this.node.querySelector('#wvpl-sticky-player .wvpl-waveform')

        if ( !waveform )
            return

        const canvas = document.createElement('canvas')

        waveform.innerHTML = ''
        waveform.appendChild(canvas)
    }

    navigatorInit() {
        if ('mediaSession' in navigator) {
            navigator.mediaSession.setActionHandler('previoustrack', () => {
                this.skip(false)
            })
            navigator.mediaSession.setActionHandler('nexttrack', () => {
                this.skip()
            })
        }
    }

    isPaused() {
        return this.audio().paused
    }

    play( time ) {

		const track = this.getCurrentTrack()

	    this.audioPaused = false
		this.seeking()

		if ( encodeURI( this.audio().src ) === encodeURI( track.file ) ) {
			this.audio().play()
			.then( () => {
				this.thenPlay( time )
			})
			return
		}

		this.persistentTrack = track
		this.status = 0

		if ( this.isWebAudio() ) {
			if ( this.fadeTimeout ) {
	            clearTimeout( this.fadeTimeout )
	            this.gain.gain.cancelScheduledValues(this.audioCtx.currentTime)
	        }
			if ( this.analyserFadeTimeout ) {
	            clearTimeout( this.analyserFadeTimeout )
	            this.analyserGain.gain.cancelScheduledValues(this.audioCtx.currentTime)
	        }
		}

		// this.seeking()
		// fetch( track.file )
		// .then( (response) => {
			this.audio().src = track.file
			this.audio().play()
			.then( () => {
				this.thenPlay( time )
			})
			.catch( (error) => {
				this.audioType = 'MediaElement'
				this.audio().src = track.file
				this.audio().play()
				.then( () => {
					this.thenPlay( time )
				})
				.catch( () => {
					if ( this.failedAttempts < WVPL_MAX_FAILED_ATTEMPTS ) {
						this.failedAttempts++
						this.tryReloadingTrack()
					}
				})
			})
		// })
		// .catch( () => {
		// 	this.audioType = 'MediaElement'
		// 	this.audio().src = track.file
		// 	this.audio().play()
		// 	.then( () => {
		// 		this.seeked()
		// 		this.node && this.node.classList.add('playing')
		// 		this.status = 1
		// 		this.getCurrentInstance().playing()
		// 		this.trigger( 'play' )
		// 	})
		// 	.catch( () => {
		// 		if ( this.failedAttempts < WVPL_MAX_FAILED_ATTEMPTS ) {
		// 			this.failedAttempts++
		// 			this.tryReloadingTrack()
		// 		}
		// 	})
		// })
    }

	thenPlay( time ) {
		this.playing()
		this.failedAttempts = 0
		if ( time >= 0 ) {
			this.setCurrentTime( time )
		}
		this.toggleStickyPlayer( true )
		if ( this.isWebAudio() ) {
			this.trackLastStart = this.getCurrentTime()
			this.fadeIn( .1 )
			this.analyserFadeIn( .3 )
			this.connectScriptNode()
		}
	}

    pause() {
		return new Promise( (resolve, reject) => {
			this.audioPaused = true
			this.lastTime = this.audio().currentTime
	        this.node && this.node.classList.remove('playing')
			if ( this.status > 0 ) {
				this.status = 2
				if ( this.isWebAudio() ) {
					this.fadeOut( .1 )
					this.analyserFadeOut( .3, () => {
						this.disconnectScriptNode()
			            this.webAudio.pause()
						this.cancelAnimationFrame.call( window, this.afRequest )
						this.setCurrentTime( this.lastTime )
						if ( ! this.hasEnded ) {
							this.trigger( 'pause' )
						}
						resolve()
			        })
				} else {
					this.mediaElement.pause()
					resolve()
				}
			} else {
				resolve()
			}
		})
    }

    stop() {
        this.pause()
		.then( () => {
			this.status = 0
			this.setCurrentTime( 0 )
		})
    }

    toggle() {
        const instance = this.getCurrentInstance()

        if ( this.isPaused() ) {
            instance.play()
        } else {
            instance.pause()
        }
    }

    resume() {
        if (this.audioCtx)
            this.audioCtx.resume()
    }

    tryReloadingTrack() {
        const instance = this.getInstanceById(),
              track = instance.tracks[instance.currentTrack]

        if ( track && track.type !== 'soundcloud' )
            return

        track.file = ''
        instance.preloadTrack( true )
    }

    getCurrentTime() {
		if ( this.audioPaused )
			return this.lastTime

        return this.audio().currentTime
    }

    setCurrentTime(time, forcePlay = false) {
		this.trackLastStart = time
        if (time >=0 && time <= this.getDuration() ) {
			this.audio().currentTime = time
		}

        if ( this.isPaused() && forcePlay )
            this.play()
    }

    getDuration() {
        return this.audio().duration
    }

    getProgress() {
        return this.getCurrentTime() / this.getDuration()
    }

    getVolume() {
        return this.volume
    }

    setVolume( volume ) {
        const outputs = []

        if ( this.isInstanceInDOM() )
            outputs.push( this.getCurrentInstance().node )

        if ( this.hasStickyPlayer() )
            outputs.push( this.node )

        for( const output of outputs ) {
            const sliderValue = output.querySelector('.wvpl-volume-slider .value'),
                  sliderHandle = output.querySelector('.wvpl-volume-slider .handle')

            sliderValue && ( sliderValue.style.width = `${(volume * 100)}%` )
            sliderHandle && ( sliderHandle.style.left = `${(volume * 100)}%` )
        }

        this.volume = volume
		if ( this.isWebAudio() ) {
			this.gain.gain.setValueAtTime(volume, this.audioCtx.currentTime)
		}
        this.muted = !(volume > 0)
    }

    mute() {
		if ( this.isWebAudio() ) {
        	this.gain.gain.setValueAtTime(0, this.audioCtx.currentTime)
		}
        this.muted = true
    }

    unmute() {
		if ( this.isWebAudio() ) {
        	this.gain.gain.setValueAtTime(this.volume, this.audioCtx.currentTime)
		}
        this.muted = false
    }

    toggleMute() {
        this.muted ? this.unmute() : this.mute()
    }

    isMuted() {
        return this.muted
    }

	fadeOut( time, fn ) {
		if ( this.isMediaElement() ) {
			fn && fn()
			return
		}
        this.gain.gain.setValueAtTime(this.volume, this.audioCtx.currentTime )
        this.gain.gain.linearRampToValueAtTime(0, this.audioCtx.currentTime + time )
        if ( fn ) {
            this.fadeTimeout = setTimeout( fn, 1000 * time )
        }
    }

    fadeIn( time, fn ) {
		if ( this.isMediaElement() ) {
			fn && fn()
			return
		}
		this.gain.gain.setValueAtTime(0, this.audioCtx.currentTime )
        this.gain.gain.linearRampToValueAtTime(this.volume, this.audioCtx.currentTime + time )
        if ( fn ) {
            this.fadeTimeout = setTimeout( fn, 1000 * time )
        }
    }

	analyserFadeOut( time, fn ) {
		if ( this.isMediaElement() ) {
			fn && fn()
			return
		}
        this.analyserGain.gain.linearRampToValueAtTime(0, this.audioCtx.currentTime )
        if ( fn ) {
            this.analyserFadeTimeout = setTimeout( fn, 1000 * time )
        }
    }

    analyserFadeIn( time, fn ) {
		if ( this.isMediaElement() ) {
			fn && fn()
			return
		}
        this.analyserGain.gain.linearRampToValueAtTime(this.volume, this.audioCtx.currentTime )
        if ( fn ) {
            this.analyserFadeTimeout = setTimeout( fn, 1000 * time )
        }
    }

    isLooped() {
        return this.audio().loop
    }

    loop( looped ) {
        this.audio().loop = looped
    }

    getSampleRate() {
        return this.audioCtx.sampleRate
    }

    setSmoothingTimeConstant( stc ) {
        if ( this.isMediaElement() )
            return
        if ( !this.analyser )
            this.createAnalyser()
        this.analyser.smoothingTimeConstant = stc
    }

    redrawAllInstances() {
        for ( const instance of this.getInstancesInDOM() ) {
            instance.refresh()
        }
        this.setSkipState()
    }

	playing() {
		const instance = this.getCurrentInstance()
		if ( instance ) {
			instance.playing()
			instance.node.classList.remove('seeking')
		}
		if ( this.node ) {
			this.node.classList.remove('seeking')
			this.node.classList.add('playing')
		}
		this.trigger( 'seeking' )
		this.status = 1
	}

	seeking() {
		const instance = this.getCurrentInstance()
		instance && instance.node.classList.add('seeking')
		this.node && this.node.classList.add('seeking')
		this.trigger( 'seeking' )
	}

	seeked() {
		const instance = this.getCurrentInstance()
		instance && instance.node.classList.remove('seeking')
		this.node && this.node.classList.remove('seeking')
		this.trigger( 'seeked' )
	}

    addEvents() {
        this.onSeeking()
        this.onSeeked()
        this.onEnded()
        this.onTimeUpdateFallback()
    }

    onSeeking() {
        this.webAudio.addEventListener('seeking', e => {
			this.seeking()
        })
        this.mediaElement.addEventListener('seeking', e => {
			this.seeking()
        })
    }

    onSeeked() {
        this.webAudio.addEventListener('seeked', e => {
			this.seeked()
        })
        this.mediaElement.addEventListener('seeked', e => {
			this.seeked()
        })
    }

    onEnded() {
        this.webAudio.addEventListener('ended', e => {
			this.hasEnded = true
            this.trigger( 'ended' )
        })
        this.mediaElement.addEventListener('ended', e => {
			this.hasEnded = true
            this.trigger( 'ended' )
        })
    }

    onTimeUpdateFallback() {
        this.mediaElement.addEventListener( 'timeupdate', (event) => {
            const instance = this.getCurrentInstance()
            instance && instance.timeUpdate()
        })
    }

	gtmPushTimeData( action ) {
		window.dataLayer = window.dataLayer || []

		const track = this.getCurrentInstance().getTrack(),
			  time  = this.round( this.getCurrentTime(), 2 )

		if ( ! track )
			return

		const data = {
			'event': 'track',
			'action': action,
			'type': 'time',
			'trackId': track.id || 0,
			'trackTitle': track.title || '',
			'time': time || 0,
		}
		window.dataLayer.push(data);
	}

	gtmPushSegmentData( action ) {
		window.dataLayer = window.dataLayer || []

		const track = this.getCurrentTrack(),
			  time  = this.round( this.getCurrentTime(), 2 )

		if ( ! track )
			return

		const data = {
			'event': 'track',
			'action': action,
			'type': 'segment',
			'trackId': track.id || 0,
			'trackTitle': track.title || '',
			'time': time || 0,
			'from': this.round( this.trackLastStart, 2 ),
			'duration': this.round( time - this.trackLastStart ),
		}
		window.dataLayer.push(data);
	}

	round( num, decimals ) {
		decimals = decimals || 0
		const divider = Math.pow( 10, decimals )
		const epsilon = Number.EPSILON || Math.pow( 2, -52 )
		return Math.round( num * divider + epsilon ) / divider
	}

	trigger( type, detail ) {
		const instance = this.getCurrentInstance()
		if ( instance ) {
			this.getCurrentInstance().trigger( type, detail )
		}
	}

	secondsToTime(pos) {
        if (pos == null) return '0:00'
        pos = Math.round(pos)

        var seconds = pos % 60,
            minutes = Math.floor(pos / 60) % 60,
            hours = Math.floor(pos / 3600)

        return (hours > 0 ? hours + ":" : "") + (hours > 0 && minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds
    }

	timeToSeconds( time ) {
		const matches = time.match(/((1*[0-2]|0*[0-9]):)?([0-5]*[0-9]):([0-5][0-9])/)
		if ( matches ) {
			let seconds = Number( matches[4] )
			if ( matches[3] ) {
				seconds += 60 * Number( matches[3] )
			}
			if ( matches[2] ) {
				seconds += 60 * 60 * Number( matches[2] )
			}
			return seconds
		}
		return false
	}

    shortenNumber( num ) {
        num = Number(num)
        const units = [ '', 'k', 'M', 'G', 'T', 'P', 'E' ]
        let index = 0
        while ( num >= 1000 ) {
            num = num / 1000
            index++
        }
        return num.toFixed(0) + units[index]
    }

	isDebugMode() {
		return this.vars.is_script_debug
	}

    log( ...args ) {
        if ( this.isDebugMode() )
            console.debug( ...args )
    }
}

const WVPL_STATUS_STOP = 0,
      WVPL_STATUS_PLAY = 1,
      WVPL_STATUS_PAUSE = 2,
      WVPL_ANIMATION_TIME = 300

class WVPLInstance {

    constructor( node, tracks, nonce, engine ) {
        this.id = node.dataset.instance_id
        this.node = node
        this.engine = engine
        this.tracks = tracks
		this.currentTrack = 0
		this.nonce = nonce
        this.waveformOptions = null
        this.runtime = 0
        this.info = this.getData('info')
        this.lastStart = 0
        this.scrolling = false
        this.timerOverlay
        this.startOffset
        this.startVol
        this.mousePosition = -1
        this.status = WVPL_STATUS_STOP
		this.createObservers()
        this.instanceInit()
    }

    getOption( name ) {
        const value = this.engine.getOption( name ) || ''
        return value
    }

    getData( name ) {
        let data = this.node.dataset[name]
        if ( data === undefined || data.toString().length === 0 )
            data = this.getOption(name)
        return data
    }

    getStickyPlayerData( name ) {
        if ( ! this.engine.node )
            return
        let value = undefined
        value = getComputedStyle(this.engine.node).getPropertyValue(`--${name}`).trim()
        return value
    }

    updateLength() {
        if ( !this.getFirst('.wvpl-duration') )
            return

        this.getFirst('.wvpl-duration').textContent = this.getTrackData('length_formatted')
        this.getFirst('.wvpl-position').textContent = this.engine.secondsToTime()
		if ( this.getTrackData('length_formatted') ) {
			this.getFirst('.wvpl-duration').style.width = ( `${this.getTrackData('length_formatted').length+1}ch` )
			this.getFirst('.wvpl-position').style.width = ( `${this.getTrackData('length_formatted').length+1}ch` )
		}
    }

    getRealWaveformSize( player ) {
        player = player || this.node
        const waveform = player.querySelector('.wvpl-waveform')
        if ( !waveform ) {
            return false;
        }

        var computedStyle = getComputedStyle(waveform)

        let height = waveform.clientHeight // height with padding
        let width = waveform.clientWidth // width with padding

        if ( (width * height) > 0 )
            return {width: width, height: height}

        let node = waveform,
            parent = node
        while ( parent = parent.parentNode ) {
            if ( parent.offsetWidth * parent.offsetHeight > 0 ) break
            node = parent
        }
        if ( parent ) {
            let cloneNode = node.cloneNode(true)
            cloneNode.style.display = 'block'
            parent.append(cloneNode)

            let cloneWave = cloneNode.querySelector('.wvpl-waveform')
            if ( cloneWave ) {
                width = cloneWave.offsetWidth
                height = cloneWave.offsetHeight
            }
            cloneNode.remove()
        }
        return {width: width, height: height}
    }

    getWaveformOptions( player ) {
        player = player || this.node
        const waveform = player.querySelector('.wvpl-waveform')
        if ( !waveform ) {
            return false;
        }
        // const getData = player === this.node ? this.getData.bind(this) : this.getStickyPlayerData
        const isSticky = (player === this.engine.node )
        const getData = isSticky ? this.getOption.bind(this) : this.getData.bind(this)

        return {
            waveColor:          parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--wave`).trim() + ')' : getData('wave_color'),
            waveColor2:         parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--wave-shade`).trim() + ')' : getData('wave_color_2'),
            progressColor:      parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--progress`).trim() + ')' : getData('progress_color'),
            progressColor2:     parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--progress-shade`).trim() + ')' : getData('progress_color_2'),
            cursorColor:        parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--cursor`).trim() + ')' : getData('cursor_color'),
            cursorColor2:       parseInt(getData('override_wave_colors')) ? 'rgb(' + getComputedStyle(player).getPropertyValue(`--cursor-shade`).trim() + ')' : getData('cursor_color_2'),
            cursorWidth:        parseInt(getData('cursor_width')),
            hoverOpacity:       parseInt(getData('hover_opacity')) / 100,
            barWidth:           parseInt(getData('wave_mode')),
            gapWidth:           parseInt(getData('gap_width')),
            compression:        parseInt(getData('wave_compression')),
            asymmetry:          parseInt(getData('wave_asymmetry')),
            normalization:      parseInt(getData('wave_normalization')),
            waveAnimation:      parseFloat(this.getData('wave_animation')),
            ampFreqRatio:       parseFloat(this.getData('amp_freq_ratio')),
            height:             waveform.offsetHeight,
            bandwidth:          20000,
			bandwidthStart:     100,
        }
    }

    updateSize( force ) {
        const outputs = []

        if ( force || this.engine.isInstanceInDOM(this.id) )
            outputs.push( { player: this.node, instance: this } )

        if ( force || this.engine.hasStickyPlayer() )
            outputs.push( { player: this.engine.node, instance: this.engine.getCurrentInstance() } )

        for( const output of outputs ) {
            const player = output.player

            if ( !player || !player.querySelector('.wvpl-waveform') )
                continue

            player.waveformOptions = this.getWaveformOptions(player)
            this.engine.setSmoothingTimeConstant( parseFloat(this.getOption('wave_animation') || 1) )
            let canvas = player.querySelector('.wvpl-waveform canvas'),
                cCtx = canvas.getContext("2d"),
                size = this.getRealWaveformSize(player)

            try {
                cCtx.canvas.width = Math.round( size.width * window.devicePixelRatio )
                cCtx.canvas.height = Math.round( size.height * window.devicePixelRatio )
                canvas.style.width = (`${Math.round(size.width)}px`)
                canvas.style.height = (`${Math.round(size.height)}px`)
            } catch(e) {
                this.log( 'updateSize', e )
            }
            this.prepareCanvas(player)
			if ( this.getTrackData( 'peaks') ) {
				this.calculateWaveParams(player)
			}
        }
    }

    prepareCanvas( player ) {
        player = player || this.node

        const canvas = player.querySelector('.wvpl-waveform canvas'),
              cCtx = canvas.getContext("2d")
        canvas.grdW = this.createGradient( cCtx, cCtx.canvas.height, player.waveformOptions.waveColor, player.waveformOptions.waveColor2, player.waveformOptions.asymmetry )
        canvas.grdP = this.createGradient( cCtx, cCtx.canvas.height, player.waveformOptions.progressColor, player.waveformOptions.progressColor2, player.waveformOptions.asymmetry )
        canvas.grdC = cCtx.createLinearGradient( 0, 0, 0, cCtx.canvas.height )
        try {
            canvas.grdC.addColorStop( 0, player.waveformOptions.cursorColor )
            canvas.grdC.addColorStop( 1, player.waveformOptions.cursorColor2 )
        } catch(e) {
            this.log( 'prepareCanvas', e )
        }
        // cCtx.canvas.width = canvas.width / window.devicePixelRatio
    }

    createGradient( ctx, height, color1, color2, asymmetry ) {
        let grd = ctx.createLinearGradient(0, 0, 0, height)
        try{
            grd.addColorStop(0, color1)
            grd.addColorStop( asymmetry / ( 1 + asymmetry ) - 0.000000001, color2)
            grd.addColorStop( asymmetry / ( 1 + asymmetry ), color1)
            grd.addColorStop( 1, color2 )
        } catch(e) {
            this.log( 'createGradient', e )
        }
        return grd
    }

    clearWave( player ) {
        player = player || this.node
        let canvas = player.querySelector('.wvpl-waveform canvas'),
            ctx = canvas.getContext("2d")
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height)
    }

    waveformInit() {
        let waveform = this.getFirst('.wvpl-waveform'),
            canvas = document.createElement('canvas')
        if ( waveform ) {
            waveform.innerHTML = ''
            waveform.appendChild(canvas)
        }
    }

	processBuffer( buffer, trackId ) {
		if ( ! buffer || buffer.constructor !== ArrayBuffer ) {
			return false
		}
		this.engine.decodeAudioData( buffer, b => {
			const peaks = this.engine.extractPeaks( b )
			if ( !this.getTrackData('length') ) {
				this.setTrackData( 'length', b.duration )
				this.setTrackData( 'length_formatted', this.engine.secondsToTime(b.duration) )
			}
			this.setTrackData( 'peaks', peaks )
			this.updateInfo()
			this.trigger( 'peaksloaded', { peaks: peaks, id: trackId } )
		})
	}

	progressCallback( at, length ) {
		const p = Math.floor(100*at/length)
		this.updateOverlay( p, 'audio analysis in progress&hellip;' )
	}

    waveReset(){
        this.clearWave()
        this.engine.node && this.clearWave(this.engine.node)
    }

    calculateWaveParams(player) {
        player = player || this.node
        const wp = {},
              dpr = window.devicePixelRatio

        wp.canvas = player.querySelector('.wvpl-waveform canvas')
        wp.cCtx = wp.canvas.getContext("2d")
        wp.width = wp.canvas.width
        wp.height = wp.canvas.height
        wp.barWidth = player.waveformOptions.barWidth == 0 ? 1 * dpr : player.waveformOptions.barWidth * dpr
        wp.gapWidth = player.waveformOptions.gapWidth == 0 ? 0 : player.waveformOptions.gapWidth * dpr
        wp.cursorWidth = player.waveformOptions.cursorWidth * dpr
        wp.compRatio = 1 / player.waveformOptions.compression
        wp.a = player.waveformOptions.asymmetry
        wp.stepSize = wp.barWidth + wp.gapWidth

		const peaks = this.getTrackData( 'peaks' )
		wp.scale = wp.width / peaks.length
		wp.max = 1
        if ( peaks && player.waveformOptions.normalization ) {
            wp.max = Math.max(...peaks)
        }
        player.waveParams = wp
    }

    drawWave() {
        const outputs = []

        if ( this.engine.isInstanceInDOM(this.id) )
            outputs.push( { player: this.node, instance: this } )

        if ( this.engine.hasStickyPlayer() )
            outputs.push( { player: this.engine.node, instance: this.engine.getCurrentInstance() } )

        for( const output of outputs ) {

            const player = output.player,
                  instance = output.instance

            if ( ! player || ! instance || ! player.querySelector('.wvpl-waveform') )
                continue

            const peaks = instance.getTrackData( 'peaks' ),
                  currentTime = this.status !== WVPL_STATUS_STOP ? this.engine.getCurrentTime() : 0,
                  currentProgress = this.status !== WVPL_STATUS_STOP ? this.engine.getProgress() : 0

            let fData = this.status !== WVPL_STATUS_STOP ? this.engine.frequencyData : null

            if ( !peaks )
                return

            const position = player.querySelector('.wvpl-position')
            position && ( position.textContent = this.engine.secondsToTime( currentTime ) )

            const wp = player.waveParams,
                  wo = player.waveformOptions,
                  mp = player === this.node ? this.mousePosition : -1,
                  { scale, max } = wp,
                  progressWidth = currentProgress * wp.width

            let afRatio = wo.ampFreqRatio
            if ( wo.waveAnimation == 1 )
                afRatio = Infinity


			const rho = wo.bandwidthStart * wp.width / wo.bandwidth,
				  gamma = ( wp.width - rho ) / wp.width

            wp.cCtx.clearRect( 0, 0, wp.width, wp.height )

            const dpr = devicePixelRatio,
                  fF = 1 / ( afRatio + 1 ),
                  aF = 1 - fF
			let index = 0
            for ( var i = 0; i < wp.width - wp.stepSize; i += wp.stepSize ) {
				const fIndex = fData ? Math.round( Math.max( index, Math.pow( fData.length, i / wp.width ) ) ) : 0,
                      fAdd = fData ? max * fData[fIndex]/255 : 0,
                      peak = Math.pow( Math.abs(peaks[Math.floor(i / scale)]), wp.compRatio ),
                      h = Math.max( dpr, Math.abs( Math.ceil( wp.height * (aF*peak + fF*fAdd) / max ) ) )

                wp.cCtx.fillStyle = wp.canvas.grdW
                var peakY = Math.ceil( wp.a * ( wp.height - h ) / (1+wp.a) )
                wp.cCtx.globalAlpha = 1
                wp.cCtx.fillRect( i, peakY, wp.barWidth, h )
                if ( i < Math.max(mp, progressWidth) && this.status !== WVPL_STATUS_STOP ) {
                    wp.cCtx.fillStyle = wp.canvas.grdP
                    wp.cCtx.globalAlpha = 1
                    if ( mp >= 0 && i > Math.min(mp, progressWidth) && player === this.node )
                        wp.cCtx.globalAlpha = wo.hoverOpacity
                    wp.cCtx.fillRect( i, peakY, wp.barWidth, h )
                }
				index++
            }
            if ( this.status !== WVPL_STATUS_STOP ) {
                wp.cCtx.fillStyle = wp.canvas.grdC
                wp.cCtx.fillRect( progressWidth, 0, wp.cursorWidth, wp.height )
            }
        }
    }

    waveRedraw(){
        this.updateSize( true )
        this.drawWave(true)
    }

    timeUpdate() {
        this.drawWave()
        this.trigger( 'timeupdate' )
    }

    createObservers() {
        const _this = this
        const config = { attributes: true, childList: false, subtree: false }
        const callback = function(mutationsList, observer) {
            for(let mutation of mutationsList) {
                if ( mutation.type === 'attributes' ) {
                    _this.waveRedraw()
                    break
                }
            }
        };
        this.mutationObserver = new MutationObserver(callback)
        this.mutationObserver.observe(this.node, config)

        if ( window.ResizeObserver ) {
            this.resizeObserver = new ResizeObserver( entries => {
                const thisEntry = entries.find( entry => entry.target.dataset.instance_id === this.id )
                if ( thisEntry && this.currentWidth !== thisEntry.target.offsetWidth ) {
					this.currentWidth = thisEntry.target.offsetWidth
                    this.refresh()
                }
                this.engine.redrawAllInstances()
            })
            this.resizeObserver.observe(this.node)
        }

		if ( window.IntersectionObserver ) {
			this.intersectionObserver = new IntersectionObserver(function(entries) {
				if(entries[0].isIntersecting === true && ! entries[0].target.classList.contains('wvpl-rendered')) {
					_this.playerInit()
				}
			}, { threshold: [0] });
			this.intersectionObserver.observe(this.node);
		}

    }

	instanceInit() {
		const playlistWrapper = this.getFirst('.wvpl-playlist-wrapper'),
              playlist = this.getFirst('.wvpl-playlist'),
              playBtn = this.getFirst('.wvpl-play'),
              position = this.getFirst('.wvpl-position'),
              duration = this.getFirst('.wvpl-duration')

        if ( playlistWrapper )
            playlistWrapper.innerHTML = ''

        let asymmetry = parseInt(this.getData('wave_asymmetry'))
        asymmetry = asymmetry * 100 / ( 1 + asymmetry )

        if ( position ) {
            position.style.top = asymmetry+'%'
            duration.style.top = asymmetry+'%'
        }

        let players = document.querySelectorAll('.waveplayer'),
            index = 0,
            node = this.parentElement

        for (index=0; index<players.length; index++) {
            if ( players[index] == this.node )
                break
        }

        this.waveformInit()

        this.autoplay = !!Number(this.getData('autoplay'))
        this.repeat = !!Number(this.getData('repeat'))
        this.shuffle = !!Number(this.getData('shuffle'))

		this.activated()
		if ( ! window.IntersectionObserver ) {
			this.playerInit()
		}
	}

    playerInit( forcePlay ) {
		if ( this.node.classList.contains('wvpl-rendered') )
			return

        if (this.getTrackCount() > 0) {
			const track = this.getTrack(),
				  trackId = track.id,
				  filesize = track.filesize,
				  tempFile = track.temp_file
			this.node.classList.add( 'wvpl-rendered' )
            this.loading()
            this.currentTrack = 0
            if ( tempFile ) {
                this.analyzing()
                this.engine.getAudioData( tempFile, trackId, this.progressCallback.bind(this) )
				.then( buffer => {
					this.processBuffer( buffer, trackId )
				})
            } else {
                this.setInfoState()
                this.displayPlaylist()
                this.preloadTrack( forcePlay )
            }
            this.initEvents()
        } else {
            if ( playBtn )
                playBtn.classList.add( 'wvpl-disabled' )
            this.node.classList.add('wvpl-hidden')
        }
    }

    getCurrentTime() {
        return this.engine.getCurrentTime()
    }

    setCurrentTime(pos) {
        if ( pos < 0 || pos > this.engine.getDuration() ) return false
        this.engine.setCurrentTime(pos)
    }

    maybeSwitch() {
		return new Promise( (resolve, reject) => {
			if ( this.id !== this.engine.getCurrentId() ) {
				this.engine.node && this.engine.node.classList.add('loading')
				this.trigger( 'skip' )
				this.engine.pause()
				.then( () => {
					this.engine.setCurrentInstance( this, true )
			        const instance = this.engine.getCurrentInstance()
			        this.preloadTrack()
					resolve()
				})
			} else {
				reject()
			}
		})
    }

    play() {
        this.maybeSwitch()
		.then( () => {
	        this.engine.node && this.engine.node.classList.remove('loading')
			this.lastStart = (new Date()).getTime()
	        this.engine.play()
		})
		.catch( () => {
			this.lastStart = (new Date()).getTime()
	        this.engine.play()
		})
    }

    pause() {
        this.engine.pause()
        this.paused()
        this.waveRedraw()
    }

    stop( eop = false ) {
        if (this.status == WVPL_STATUS_STOP) return false
        this.engine.stop()
        this.paused()
		if ( ! eop )
        	this.currentTrack = 0
        this.getFirst('.wvpl-position') && ( this.getFirst('.wvpl-position').textContent = this.engine.secondsToTime(0) )
        this.status = WVPL_STATUS_STOP
        this.waveRedraw()
    }

    skip( forward = true ) {
        this.clicked = true
        const eop = this.endOfPlaylist( forward )
        if ( eop ) {
            this.stop( eop )
        } else {
            this.paused()
        }
        this.loading( eop )
        setTimeout( () => {
            this.engine.skip( forward )
        }, WVPL_ANIMATION_TIME)
    }

    skipTo(index) {
        if (index == null || index < 0 || index >= this.getTrackCount()) return false
        if ( index == this.currentTrack ) {
            if ( this.status !== WVPL_STATUS_PLAY )
                this.play()
            return true
        }
		const currentInstance = this.engine.getCurrentInstance()
		if ( ! currentInstance || currentInstance.node.id !== this.node.id ) {
			this.pause()
			this.engine.setCurrentInstance( this, true )
		}
        this.currentTrack = index-1
        this.skip()
    }

    endOfPlaylist( forward = true ) {
        const eop = ( forward && this.currentTrack === this.tracks.length - 1 )
               || ( !forward && this.currentTrack === 0 )
               || this.tracks.length === 1
        return eop && !this.repeat
    }

    scrollTo(index, next) {
        let playlist = this.getFirst('.wvpl-playlist'),
            rows = this.getChildren('.wvpl-playlist-wrapper>ul>li'),
            el = rows[index]
        if ( !el ) return false

        if ( next ) {
            if ( el.offsetTop + el.height > playlist.scrollTop + playlist.height )
                playlist.animate({scrollTop: el.offsetTop + el.outerHeight - playlist.outerHeight})
        } else {
            if ( el.offsetTop < playlist.scrollTop )
                playlist.animate({scrollTop: el.offsetTop})
        }
    }

    analyzing() {
        this.node.classList.remove( 'loading' )
        this.node.classList.add( 'analyzing' )
        this.trigger( 'analyzing' )
    }

    analyzed() {
        this.node.classList.remove( 'analyzing' )

		this.updateOverlay( 0, '' )
        this.trigger( 'analyzed', { track: this.getTrack(), peaks: this.getTrackData( 'peaks' ) } )
    }

    loading( eop ) {
        if ( !eop ) {
            this.node.classList.add( 'loading' )
            this.trigger( 'loading' )
        }
        this.engine.node && this.engine.node.classList.add('loading')
    }

    loaded() {
        this.node.classList.remove( 'loading' )
        this.engine.node && this.engine.node.classList.remove('loading')
		this.waveRedraw()
        this.trigger( 'loaded' )
    }

    playing() {
        this.status = WVPL_STATUS_PLAY
		this.removeClassFrom('.wvpl-playlist li', 'playing' )
        let playlistRows = this.getChildren('.wvpl-playlist-wrapper>ul>li')
        if ( playlistRows.length ) {
            playlistRows[this.currentTrack].classList.add('playing')
            // playlistRows[this.currentTrack].scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
        this.node.classList.add( 'playing' )
    }

    paused() {
        this.status = WVPL_STATUS_PAUSE
        this.runtime += (new Date()).getTime() - this.lastStart
        this.node.classList.remove( 'playing', 'loading', 'seeking' )
        this.engine.node && this.engine.node.classList.remove( 'playing', 'loading', 'seeking' )
        this.removeClassFrom( '.wvpl-playlist li', 'playing' )
    }

    ready() {
        this.loaded()
        this.trigger( 'ready', { instance: this, track: this.getTrack() } )
    }

    activated( addClass = '' ) {
        this.node.classList.add( 'active' )
        if ( addClass )
            this.node.classList.add( addClass )
        this.trigger( 'activated', { id: this.id } )
    }

    resize() {
        const width = this.node.offsetWidth,
              widthClasses = [ {width: 400, class: 'sqxxs'}, {width: 600, class: 'sqxs'}, {width: 800, class: 'sqsm'}, {width: 1000, class: 'sqmd'}, {width: 1200, class: 'sqlg'}, {width: Infinity, class: 'sqxl'} ]

        let widthClass = '';

        for( const wC of widthClasses ) {
            widthClass = wC.class
            if ( width < wC.width )
                break;
        }
        this.node.classList.remove( ...widthClasses.map( wc => `wvpl-${wc.class}`) );
        this.node.classList.add(`wvpl-${widthClass}`)
    }

    refresh() {
        this.resize()
        this.waveRedraw()
    }

    preloadTrack( forcePlay = false ) {
        if (this.currentTrack < 0) this.currentTrack = 0

        this.engine.loop( this.getTrackCount() == 1 && this.repeat )

        if ( this.getTrackData( 'type' ) === 'soundcloud' && !this.getTrackData( 'file' ) ) {
            const postData = {
                nonce: this.engine.vars.ajax_nonce,
                id: this.getTrackData( 'id' ),
				stream_url: this.getTrackData( 'stream_url' )
            }
            this.engine.ajaxCall( 'get_soundcloud_stream_url', postData )
			.then( result => {
				if ( result.success) {
                    this.setTrackData( 'file', result.data.file )
                    this.preloadFile( forcePlay )
                } else {
                    this.removeTrack(this.currentTrack)
                    this.preloadTrack( forcePlay )
                }
			})
        } else {
			const peakFile = this.getTrackData('peak_file')
			if ( ! this.getTrackData( 'peaks' ) && peakFile ) {
				fetch( peakFile )
					.then( response => response.text() )
					.then( text => {
						let peaks = []
						if ( 'external' === this.getTrackData('type') ) {
							peaks = JSON.parse(text).peaks
						} else {
							peaks = text
						}
						if ( peaks ) {
							peaks = this.engine.readPeaks( peaks )
							this.setTrackData( 'peaks', peaks )
							this.preloadFile( forcePlay )
						}
					})
			} else {
				this.preloadFile( forcePlay )
			}
        }
    }

	updateOverlay( percentage, message ) {
		const overlay = this.overlay || this.getFirst('.wvpl-overlay')

		if ( overlay ) {
			overlay.querySelector('.percentage').innerHTML = percentage ? `${percentage}%` : '&nbsp;'
			overlay.querySelector('.wvpl-loading>div').style.width = `${percentage}%`
			overlay.querySelector('.message').innerHTML = this.engine.__( message, 'waveplayer' )
		}
		this.overlay = overlay
	}

    preloadFile( forcePlay ) {
        this.updateInfo()
        if ( this.getTrackData( 'peaks' ) ) {
            this.loaded()
            if ( forcePlay || this.status === WVPL_STATUS_PLAY ) {
                this.play()
            }
        } else {
			this.pause()
			this.analyzing()
			const track = this.getTrack(),
				  trackId = track.id,
			      file = track.file,
				  filesize = track.filesize,
				  tempFile = track.temp_file
			if ( this.getTrackData( 'type' ) !== 'external'  ) {
				this.engine.getAudioData( file, trackId, this.progressCallback.bind(this) )
				.then( buffer => {
					this.processBuffer( buffer, trackId )
				})
			} else {
				this.updateOverlay( 0, 'creating a local copy of the file&hellip;' )
				const postData = {
	                nonce: this.engine.vars.ajax_nonce,
	                url: file
	            }
	            this.engine.ajaxCall( 'create_local_copy', postData )
				.then( result => {
					if ( result.success ) {
						this.tracks[ this.currentTrack ] = result.data.track
			            this.engine.getAudioData( result.data.track.temp_file, trackId, this.progressCallback.bind(this) )
						.then( buffer => {
							this.processBuffer( buffer, trackId )
						})
	                } else {
						this.updateOverlay( 0, 'An error occurred while copying the file&hellip;' )
					}
				})
			}
        }
    }

    reload() {
        this.reset()
    }

    reset() {
        this.currentTrack = 0
		this.paused()
        this.setSkipState()
        this.preloadTrack()
    }

    toggle() {
        switch (this.status) {
            case WVPL_STATUS_PLAY:
                this.pause()
                break
            case WVPL_STATUS_STOP:
            case WVPL_STATUS_PAUSE:
                this.play()
                break
        }
    }

    setInfoState() {
        const infoBtn = this.getFirst('.wvpl-info'),
              infoBar = this.getFirst('.wvpl-infobar'),
              playlist = this.getFirst('.wvpl-playlist')

        const states = [ 'none', 'info' ]
        if ( this.getTrackCount() > 1 ) states.push('playlist')
        const nextInfo = states[(states.indexOf(this.info)+1) % states.length]
        infoBtn && infoBtn.classList.remove( 'wvpl-info-none', 'wvpl-info-info', 'wvpl-info-playlist' )
        infoBtn && infoBtn.classList.add( `wvpl-info-${nextInfo}` )
        infoBar && infoBar.classList.add( 'wvpl-hidden' )
        playlist && playlist.classList.add( 'wvpl-hidden' )

        switch( this.info ) {
            case 'none':
                break
            case 'info':
                infoBar && infoBar.classList.remove( 'wvpl-hidden' )
                break
            case 'playlist':
                infoBar && infoBar.classList.remove( 'wvpl-hidden' )
                playlist && (this.getTrackCount() > 1) && playlist.classList.remove( 'wvpl-hidden' )
                break
        }
    }

    toggleInfoState() {
        const states = [ 'none', 'info' ]
        if ( this.getTrackCount() > 1 ) states.push('playlist')
        if (this.info == 'playlist' && this.getTrackCount() == 1 ) this.info = 'info'

        this.info = states[(states.indexOf(this.info)+1) % states.length]

        this.setInfoState()
    }

    setSkipState() {
        let prevBtn = this.getFirst('.wvpl-prev'),
            nextBtn = this.getFirst('.wvpl-next')

        prevBtn && prevBtn.classList.remove( 'wvpl-disabled' )
        nextBtn && nextBtn.classList.remove( 'wvpl-disabled' )
        switch ( true ) {
            case this.getTrackCount() === 1:
                prevBtn && prevBtn.classList.add( 'wvpl-disabled' )
                nextBtn && nextBtn.classList.add( 'wvpl-disabled' )
                break
            case this.currentTrack === 0:
                prevBtn && prevBtn.classList.add( 'wvpl-disabled' )
                break
            case this.currentTrack === this.getTrackCount() - 1:
                nextBtn && nextBtn.classList.add( 'wvpl-disabled' )
                break
        }
    }

    updateInfo() {
        const track = JSON.parse( JSON.stringify( this.getTrack() ) )
        if ( track.stats ) {
            track.stats.downloads = this.engine.shortenNumber( track.stats.downloads )
            track.stats.play_count = this.engine.shortenNumber( track.stats.play_count )
            track.stats.likes = this.engine.shortenNumber( track.stats.likes )
        }

        this.updateLength()

        let message = this.getOption('template'),
            thumbnail = track.thumbnail ? 'url('+track.thumbnail+')' : ''

        message += track.type === 'soundcloud' ? ' %soundcloud%' : ''

        let poster = this.getFirst('.wvpl-poster')
        const posterURL = track.poster || this.getOption('default_thumbnail')

        if ( poster ) {
            // let img = document.createElement('img')
            //
            // img.src = posterURL
            // img.srcset = track.poster_srcset || ''
            // img.sizes = poster.height+'px'
            // poster.innerHTML = ''
            // poster.appendChild(img)
        }
        this.node.style.setProperty('--poster-image', `url(${posterURL})`)
        this.node.style.setProperty('font-size', `${this.getOption('base_font_size')}px`)

        if ( message == null ) {
            message = track.title
        } else {
            message = this.engine.applyTemplate(message, track)
        }

        const infoBlock = this.getFirst('.wvpl-playing-info .wvpl-infoblock')
        if ( infoBlock ) {
            infoBlock.innerHTML = message
            if ( ! message )
                infoBlock.classList.add('wvpl-hidden')
        }
    }

    displayPlaylist() {
        let list = document.createElement('ul')
        for ( const t of this.tracks ) {
            let item = document.createElement('li')

            const track = JSON.parse( JSON.stringify(t) )
            if ( track.stats ) {
                track.stats.downloads = this.engine.shortenNumber( track.stats.downloads )
                track.stats.play_count = this.engine.shortenNumber( track.stats.play_count )
                track.stats.likes = this.engine.shortenNumber( track.stats.likes )
            }
            item.innerHTML = this.engine.applyTemplate( this.getOption('playlist_template'), track )
            list.append(item)
        }
        if ( this.getFirst('.wvpl-playlist-wrapper') )
            this.getFirst('.wvpl-playlist-wrapper').append(list)
    }

    updateStatistics() {
        const nLocal = this.currentTrack,
              postData = {
                  nonce: this.engine.vars.ajax_nonce,
                  id: this.getTrackData( 'id', nLocal ),
                  length: this.getTrackData( 'length', nLocal ),
                  runtime: this.runtime
              }
        this.runtime += (new Date()).getTime() - this.lastStart
        this.lastStart = (new Date()).getTime()
        this.runtime = 0
        if (this.lastStart == 0) return false
        this.engine.ajaxCall( 'update_statistics', postData )
		.then( result => {
			if ( result.success ) {
                this.setTrackData( 'stats', result.data.stats, nLocal )
            } else {
				this.log( result.data.message )
			}
		})
    }

    updateLikes(node) {
        if ( this.engine.vars.currentUser.ID == 0 ) return false
        const nodes = document.querySelectorAll('.wvpl-likes[data-id="'+node.dataset.id+'"]')
        for( const n of nodes ) {
            n.classList.add('wvpl-spin')
        }
        const postData = {
            nonce: this.engine.vars.ajax_nonce,
            id: node.dataset.id,
        }
        this.engine.ajaxCall( 'update_likes', postData )
		.then( result => {
			if ( result.success ) {
                this.setTrackData( 'liked', result.data.liked, node.dataset.index )
                this.setTrackData( 'stats', result.data.stats, node.dataset.index )
                for( const n of nodes ) {
                    n.dataset.event = result.data.liked ? 'unlike':'like'
                    n.classList.toggle('liked', result.data.liked)
                    n.classList.remove('wvpl-spin')
                    const valueSpan = n.querySelector('.wvpl-value')
                    if ( valueSpan )
                        valueSpan.textContent = this.engine.shortenNumber( this.getTrackData( 'stats', node.dataset.index ).likes )
                }
			} else {
				this.log( result.data.message )
			}
		})
    }

    addToCart(node, event) {
        const productId = node.dataset.product_id
        const instance = node.closest('.waveplayer')
        const track = this.tracks.find( t => t.product_id == productId )
        let cartBtns = document.querySelectorAll('.wvpl-cart[data-product_id="'+productId+'"]')
        if ( ! cartBtns )
            return

        if ( track && track.product_variations ) {
            this.engine.updateVariationForm( track )
        } else {
            const nLocal = this.currentTrack,
                  postData = {
                      nonce: this.engine.vars.ajax_nonce,
                      product_id: productId
                  }

            for( const cartBtn of cartBtns ) {
                cartBtn.classList.add('wvpl-spin')
            }

            this.engine.ajaxCall( 'add_to_cart', postData )
			.then( result => {
				if ( result.data.fragments ) {
                    track.in_cart = 1
                    for( const cartBtn of cartBtns ) {
                        cartBtn.title = this.engine.__( 'Already in cart: go to cart', 'waveplayer' )
                        cartBtn.classList.remove('wvpl-spin','wvpl-add_to_cart')
                        cartBtn.classList.add('wvpl-in_cart')
                        cartBtn.dataset.event = 'goToCart'
                        cartBtn.dataset.callback = 'goToCart'
                    }
                    for ( const key in result.fragments ) {
                        let fragment = document.querySelector(key)
                        if ( fragment )
                            fragment.outerHTML = result.data.fragments[key]
                    }
                    jQuery( document.body ).trigger( 'wc_fragment_refresh' );
    				jQuery( document.body ).trigger( 'added_to_cart', [ result.data.fragments, result.data.cart_hash ] );
                    this.engine.vars.ajax_nonce = result.data.ajax_nonce
                } else {
                    for( const cartBtn of cartBtns ) {
                        cartBtn.classList.remove('wvpl-spin')
                    }
                    this.log( 'addToCart', result )
                }
			})
        }
    }

    addVariationToCart(variationID, productID) {
        const variationPopup = document.querySelector('#wvpl-variation-popup')
        const cartBtns = document.querySelectorAll('.wvpl-cart[data-product_id="'+productID+'"]')
        const postData = {
            nonce: this.engine.vars.ajax_nonce,
            product_id: variationID
        }
        const track = this.tracks.find( t => t.product_id == productID )
        for( const cartBtn of cartBtns ) {
            cartBtn.classList.add('wvpl-spin')
        }
        this.engine.ajaxCall( 'add_to_cart', postData )
		.then( result => {
			if ( result.data.fragments ) {
                track && (track.in_cart = 1)
                for( const cartBtn of cartBtns ) {
                    cartBtn.title = this.engine.__( 'Already in cart: go to cart', 'waveplayer' )
                    cartBtn.classList.remove('wvpl-spin','wvpl-add_to_cart')
                    cartBtn.classList.add('wvpl-in_cart')
                    cartBtn.dataset.event = 'goToCart'
                    cartBtn.dataset.callback = 'goToCart'
                }
                for ( const key in result.data.fragments ) {
                    let fragment = document.querySelector(key)
                    if ( fragment )
                        fragment.outerHTML = result.data.fragments[key]
                }
                jQuery( document.body ).trigger( 'wc_fragment_refresh' );
                jQuery( document.body ).trigger( 'added_to_cart', [ result.data.fragments, result.data.cart_hash ] );
                this.engine.vars.ajax_nonce = result.data.ajax_nonce
            } else {
                for( const cartBtn of cartBtns ) {
                    cartBtn.classList.remove('wvpl-spin')
                }
                this.log( 'addVariationToCart', result )
            }
            document.body.classList.remove('wvpl-variation-popup')
		})
    }

    goToCart() {
        window.location = this.getOption('cartURL')
    }

    updateDownloads(node, event) {
        const nodes = document.querySelectorAll('.wvpl-downloads[data-id="'+node.dataset.id+'"]')
        for( const n of nodes ) {
            n.classList.add('wvpl-spin')
        }
		const a = node.querySelector('a.wvpl-link'),
			  href = a.href,
			  track = this.engine.findTrack( node.dataset.id ),
			  file = track ? `${track.artist} - ${track.title}.${track.fileformat}` : href
		fetch( href )
			.then(response => response.blob())
			.then(blob => URL.createObjectURL(blob))
			.then(url => {
				const a = document.createElement('a')
				a.href = url
				a.download = file
				a.click()
			});

        const postData = {
            nonce: this.engine.vars.ajax_nonce,
            id: node.dataset.id
        }
        this.engine.ajaxCall( 'update_downloads', postData )
		.then( result => {
            if ( result.success ) {
                this.setTrackData( 'stats', result.data.stats, node.dataset.index )
                node.querySelector('.wvpl-value') && ( node.querySelector('.wvpl-value').textContent = this.engine.shortenNumber( result.data.stats.downloads ) )
                for( const n of nodes ) {
                    const valueSpan = n.querySelector('.wvpl-value')
                    if ( valueSpan )
                        valueSpan.textContent = this.engine.shortenNumber( this.getTrackData( 'stats', node.dataset.index ).downloads )
                }
            } else {
				this.log( result.data.message )
			}
			for( const n of nodes ) {
				n.classList.remove('wvpl-spin')
			}
		})
    }

    socialShare(el, social) {
        var sharer,
            url = encodeURIComponent(el.dataset.url),
            title = encodeURIComponent(el.dataset.title),
            site = encodeURIComponent(this.getOption('site'))

        switch(social){
            case 'fb':
                sharer = 'https://www.facebook.com/sharer/sharer.php?display=popup&u=' + url
                break
            case 'tw':
                sharer = 'https://twitter.com/intent/tweet?url=' + url
                break
            case 'ln':
                sharer = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title + '&source=' + site
                break
        }
        window.open( sharer, '' )
    }

    getChildren( selectors ) {
        return this.node.querySelectorAll( selectors )
    }

    getFirst( selector ) {
        return this.node.querySelector( selector )
    }

    getCurrentTrackIndex() {
        return this.currentTrack
    }

    getCurrentTrack() {
        if ( ! this.tracks )
            return false

        return this.tracks[this.currentTrack]
    }

    getTrack( index ) {
        if ( index == undefined )
            index = this.currentTrack
        if ( this.tracks && this.tracks[index] )
            return this.tracks[index]

		return false
    }

    setTrack( track, index ) {
        if ( index == undefined ) index = this.currentTrack
        if ( this.tracks )
            this.tracks[index] = track
    }

    removeTrack( index ) {
        if ( index === undefined ) index = this.currentTrack
        this.tracks.splice(index,1)
        const playlistRow = this.getChildren('.wvpl-playlist-wrapper>ul>li')[index]
        playlistRow && playlistRow.remove()
    }

    getTrackData( key, index ) {
        if ( index == undefined ) index = this.currentTrack
        if ( this.tracks && this.tracks[index] && this.tracks[index][key] )
            return this.tracks[index][key]
    }

    setTrackData( key, value, index ) {
        if ( index == undefined ) index = this.currentTrack
        if ( this.tracks && this.tracks[index] )
            this.tracks[index][key] = value
    }

    getTrackCount() {
        if ( this.tracks )
            return this.tracks.length
    }

    addClassTo( selectors, ...classes ) {
        let elements = this.getChildren( selectors )
        for ( let e of elements ) {
            for ( let c of classes ) {
                e.classList.add(c)
            }
        }
    }

    removeClassFrom( selectors, ...classes ) {
        let elements = this.getChildren( selectors )
        for ( let e of elements ) {
            for ( let c of classes ) {
                e.classList.remove(c)
            }
        }
    }

    addEventListener( type, fn ) {
        this.node.addEventListener( type, fn )
    }

    addEventListenerTo( selectors, type, fn ) {
        for ( let e of this.getChildren( selectors ) ) {
            e.addEventListener( type, fn )
        }
    }

    trigger( type, data ) {
		data = data || { track: this.getTrack(), time: this.getCurrentTime() }
        let e = new CustomEvent( type, {detail: data, bubbles: true } )
        this.node.dispatchEvent( e )

		const types = [ 'play', 'pause' ],
			  durationTypes = [ 'jump', 'skip', 'ended' ]

		if ( types.includes(type) )
			this.engine.gtmPushTimeData( type )

		if ( durationTypes.includes(type) )
			this.engine.gtmPushSegmentData( type )
    }

    initEvents() {

        var _this = this

        this.addEventListenerTo( '.wvpl-playing-info', 'mouseenter', event => {
            // if ( _this.status != WVPL_STATUS_PLAY ) return false
            // var el = _this.getFirst('.wvpl-infoblock'),
            //     scrollable = el.scrollWidth >= _this.getFirst('.wvpl-infoBar').offsetWidth
            // if (scrollable && !_this.scrolling) {
            //     _this.scrolling = true
            //     var elClone = el.cloneNode(true)
            //     elClone.style.marginLeft = '1em'
            //     this.appendChild(elClone)
            //     var dV = elClone.offsetWidth,
            //         dT = 50 * dV
            //     // el.animate({left: -dV}, dT, 'linear', function() {
            //     //         $(this).css({left: 0})
            //     //         elClone.remove()
            //     //         _this.trigger('titleScrollEnd', {track: _this.getTrack() })
            //     //         _this.scrolling = false
            //     // })
            //     _this.trigger('titleScrollStart', [ _this.getTrack() ] )
            //     // elClone.animate({left: -dV}, dT, 'linear')
            // }
        })

        this.addEventListener( 'ended', event => {
            this.skip()
        })

        this.addEventListener( 'peaksloaded', event => {

            const peaks = event.detail.peaks.join(',').replace(/0\./gi,'.')

			this.updateOverlay( 0, 'saving the peak file&hellip;' )

            const postData = {
                nonce: _this.engine.vars.ajax_nonce,
                peaks: peaks,
				temp_file: _this.getTrackData( 'temp_file' ),
                id: _this.getTrackData( 'id' ),
                type: _this.getTrackData( 'type' ) || '',
            }
            _this.engine.ajaxCall( 'write_peaks', postData )
			.then( result => {
				_this.analyzed()
                if ( result.success ) {
                    _this.preloadTrack(_this.clicked)
                    if ( _this.getTrackData( 'temp_file' ) ) {
                        _this.setTrackData( 'id', result.data.id )
                        _this.setTrackData( 'temp_file', null )
                    }
                } else {
					this.log( result.data.message )
				}
			})
        })

        this.addEventListenerTo( 'canvas', 'mouseout', event => {
            if ( _this.status !== WVPL_STATUS_PLAY )
                return
            _this.mousePosition = -1
        })

        this.addEventListenerTo( 'canvas', 'mousemove', event => {
            if ( _this.status !== WVPL_STATUS_PLAY )
                return

            _this.mousePosition = window.devicePixelRatio * event.offsetX
        })

        this.addEventListenerTo( '.wvpl-volume', 'mousedown', event => {
            event.preventDefault()
            _this.startOffset = event.clientX
            _this.node.querySelector('.wvpl-volume-overlay').innerHTML = (Math.round(_this.engine.getVolume() * 100))

            // The overlay displaying the level appears after the user holds the mouse for more than 150ms
            let volumeBtn = event.target
            _this.timerVolumeOverlay = setTimeout(function() {
                _this.volumeDragging = true
                // Disables the default behavior of the click and drag gesture
                _this.addClassTo('.wvpl-volume-overlay', 'dragging' )
                _this.addClassTo('.wvpl-controls', 'wvpl-inactive' )

                _this.mouseMoveListener = function(e) {
                    e.preventDefault()
                    volumeBtn.classList.add( 'dragging' )
                    var newVol = Math.round( 100 * ( _this.engine.getVolume() + ( e.clientX - _this.startOffset ) / ( _this.getFirst('.wvpl-interface').offsetWidth * window.devicePixelRatio / 2 ) ) ) / 100
                    if ( newVol >= 0 && newVol <= 1 ) {
                        _this.engine.setVolume( newVol )
                        _this.getFirst( '.wvpl-volume-overlay' ).innerHTML = Math.round(newVol*100)
                        volumeBtn.classList.toggle( 'wvpl-volume_off', newVol == 0 )
                    }
                }

                _this.mouseUpListener = function(e) {
                    event.preventDefault()
                    document.removeEventListener('mousemove', _this.mouseMoveListener)
                    document.removeEventListener('mouseup', _this.mouseUpListener)
                    _this.node.querySelector('.dragging').classList.remove('dragging')
                    _this.node.querySelector('.wvpl-controls').classList.remove('wvpl-inactive')
                    _this.volumeDragging = false
                }

                document.addEventListener( 'mousemove', _this.mouseMoveListener )
                document.addEventListener( 'mouseup', _this.mouseUpListener )
            }, 150)
        })

        this.addEventListenerTo( '.wvpl-volume', 'mouseup', event => {
            clearTimeout(_this.timerVolumeOverlay)
            if ( !_this.volumeDragging ) {
                this.engine.toggleMute()
                event.currentTarget.classList.toggle('wvpl-volume_off', this.engine.isMuted())
            }
        })

    }

    log( ...args ) {
		if ( this.engine.isDebugMode() )
        	console.debug( ...args )
    }
}

document.addEventListener( 'waveplayer.engine.ready', (event) => {
    window.WavePlayer = event.detail.engine
})

window.addEventListener('load', (event) => {
	WavePlayer.redrawAllInstances()
})

document.addEventListener('readystatechange', function(event){

	const readyState = window.wvplVars && window.wvplVars.is_gutenberg ? 'interactive' : 'complete'
	// const readyState = 'interactive'
    if ( document.readyState !== readyState )
        return false;

	microStart = window.performance.now()

    const $ = jQuery

    let win = window
    while( !win.wp ) {
        win = win.parent
    }
    if ( win.wvplVars === undefined ) {
        return false
    }

    const engine = new WVPLEngine(win)

    $.fn.waveplayer = function(command, ...args) {
        return this.each(function(i,e) {
            command = command || 'init'
            var element = $(e),
                instance = null,
                id = element.attr('data-instance_id')

            if ( instance = WavePlayer.getInstanceById( id ) ) {
                if ( 'object' !== typeof(args) ) args = [args]
                instance[command].apply(instance, args)
                return
            }
        })
    }

    document.addEventListener( 'click', event => {
        WavePlayer.resume()
        let target = event.target

        const productVariation = event.target.closest('li.wvpl-product-variation')
        if ( productVariation ) {
            const instanceID = productVariation.closest('#wvpl-variation-popup').dataset.instance
            const thisInstance = WavePlayer.getInstanceById( instanceID )
            thisInstance.addVariationToCart( productVariation.dataset.variation, productVariation.dataset.product )
            return
        }

        const player = target.closest('.waveplayer') || WavePlayer.node
        if ( ! player )
            return


        const _this = WavePlayer.getInstanceById( player.dataset.instance_id )

		if ( target.matches('.wvpl-share-popup li') ) {
            const shareTarget = target.closest('.wvpl-share'),
                  triggeredEvent = 'share',
                  social = target.dataset.social
            _this.trigger( triggeredEvent )
            _this['socialShare'].apply( _this, [ shareTarget, social ] )
        }

        if ( target.matches('.wvpl-button') ) {
            if ( ! target.matches('.wvpl-downloads') && target.querySelector('a.wvpl-link')  ) {
				target.click()
			}

            const triggeredEvent = target.dataset.event
            if ( triggeredEvent )
                _this.trigger( triggeredEvent )

            const callback = target.dataset.callback
            if ( ! callback ) return

            _this[callback].apply( _this, [ target ] )
            return
        }

        if ( target.matches('.wvpl-link') && target.attributes.download ) {
            return
        }

        if ( target.matches('.wvpl-info') ) {
            event.preventDefault()
            _this.toggleInfoState()
            return
        }

        if ( target.matches('.wvpl-play') ) {
            event.preventDefault()
            _this.toggle()
            return
        }

        if ( target.matches('.wvpl-prev:not(.wvpl-disabled), .wvpl-next:not(.wvpl-disabled)') ) {
			event.preventDefault()
            const forward = target.classList.contains('wvpl-next')
            _this.skip( forward )
            return
        }

        if ( target.matches('canvas') ) {
            event.preventDefault()
            if ( _this.status == WVPL_STATUS_PLAY) {
                _this.runtime += (new Date()).getTime() - _this.lastStart
                _this.lastStart = (new Date()).getTime()
				_this.trigger( 'jump' )
                WavePlayer.setCurrentTime( WavePlayer.getDuration() * event.offsetX / target.offsetWidth )
            } else {
                _this.play()
            }
            return
        }

        if ( target.matches('.wvpl-playlist li') || target.matches('.wvpl-playlist li>*:not(.wvpl-icon)') ) {
            if ( target.tagName !== 'LI' )
                target = target.closest('li')
            event.preventDefault()

			if ( WavePlayer.isPaused() ) {
				WavePlayer.resume()
			}
            let i = 0
            let node = target
            for (i=0; (node=node.previousSibling); i++) {

            }
            _this.skipTo(i)
			return
        }

        if ( target.matches('button.wvpl-sticky-player-toggle') ) {
            WavePlayer.toggleStickyPlayer()
            return
        }

        if ( target.matches('#wvpl-sticky-player canvas') ) {
            event.preventDefault()
            WavePlayer.resume()

            _this.maybeSwitch()
			.then( () => {
				_this.play()
			})
			.catch( () => {
				if ( _this.status == WVPL_STATUS_PLAY) {
	                const canvas = event.currentTarget
	                _this.runtime += (new Date()).getTime() - _this.lastStart
	                _this.lastStart = (new Date()).getTime()
	                WavePlayer.setCurrentTime( WavePlayer.getDuration() * event.offsetX / canvas.offsetWidth )
	            } else {
	                _this.play()
	            }
			})
            return
        }

        if ( target.matches( '#wvpl-sticky-player .wvpl-play' ) ) {
            _this.toggle()
            return
        }

        if ( target.matches( '.remove_from_cart_button' ) ) {
            const productID = target.dataset.product_id

            const cartBtns = document.querySelectorAll('.wvpl-cart[data-product_id="'+productID+'"]')
            for( const cartBtn of cartBtns ) {
                cartBtn.classList.add('wvpl-spin')
            }
            return
        }

        if ( target.matches( '#wvpl-variation-popup .woocommerce-variation-add-to-cart button' ) ) {
            event.preventDefault();
            const addToCart = target.closest('.woocommerce-variation-add-to-cart'),
                  productId = addToCart.querySelector('input[name="product_id"]').value,
                  variationId = addToCart.querySelector('input.variation_id').value
            if ( variationId > 0 ) {
                _this.addVariationToCart( variationId, productId )
            }
            return
        }

		if ( target.matches( '#wvpl-variation-popup' ) ) {
            document.body.classList.remove('wvpl-variation-popup')
            return
        }
	})

	document.addEventListener( 'click', event => {
		const target = event.target

		if ( target.matches( '[data-marker]' ) ) {
			event.preventDefault()
			const time = WavePlayer.timeToSeconds( event.target.dataset.marker )
			if ( time ) {
				WavePlayer.play( time )
			}
			return
        }
    })

    window.addEventListener('resize', (event) => {
        if (window.frameElement)
            return

        setTimeout(function() {
            WavePlayer.redrawAllInstances()
        }, 50)
    })

    window.addEventListener('beforeunload', (event) => {
        let instance = WavePlayer.getCurrentInstance()
        if ( instance )
            instance.updateStatistics()
    })

    let spVolumeDragging = false
    document.addEventListener( 'mousedown', (event) => {
        if ( event.target.matches('.wvpl-volume-slider .touchable') ) {
            spVolumeDragging = true
            WavePlayer.setVolume( event.offsetX / event.target.offsetWidth )
        }
    })

    document.addEventListener( 'mousemove', (event) => {
        if ( event.target.matches('.wvpl-volume-slider .touchable') ) {
            if ( spVolumeDragging && event.target.className === 'touchable' ) {
                  WavePlayer.setVolume(event.offsetX / event.target.offsetWidth)
            }
        }
    })

    document.addEventListener( 'mouseup', (event) => {
        spVolumeDragging = false
    })

	let lastTime = ''
	document.addEventListener( 'timeupdate', (event) => {
		if ( event.target.matches('.waveplayer') ) {
			const markers = document.querySelectorAll( '[data-marker]' ),
			 	  time = WavePlayer.secondsToTime( event.detail.time )
			if ( markers.length && time !== lastTime ) {
				let marker = markers[0]
				for( let i = 1; i < markers.length; i++ ) {
					if ( WavePlayer.timeToSeconds( markers[i].dataset.marker ) > WavePlayer.timeToSeconds( time ) ) {
						break
					}
					marker = markers[i]
				}
				for ( let m of markers ) {
					m.classList.remove('current-time-marker')
				}
				marker.classList.add('current-time-marker')
				if ( WavePlayer.getOption( 'scroll_to_marker' ) ) {
					const behavior = marker.dataset.behavior ? marker.dataset.behavior : 'smooth',
						  block = marker.dataset.block ? marker.dataset.block : 'center'
					marker.scrollIntoView({
						behavior,
						block
					})
				}
				lastTime = time
			}
		}
	})

    $(document.body).on( 'added_to_cart', (event, fragments, cartHash, $button) => {
        if (!$button) return
        const productId = $button.data('product_id')

        WavePlayer.updateTrackCartStatus( productId, 'add' )

        $(`.wvpl-cart[data-product_id=${productId}]`)
            .attr('title', WavePlayer.__( 'Already in cart: go to cart', 'waveplayer' ) )
            .attr('data-event', 'goToCart')
            .attr('data-callback', 'goToCart')
            .addClass('wvpl-in_cart')
            .removeClass('wvpl-add_to_cart')
            .removeClass('wvpl-spin')
    } )

    $(document.body).on( 'removed_from_cart', (event, fragments, cartHash, $button) => {
        if (!$button) return
        const productId = $button.data('product_id')

        WavePlayer.updateTrackCartStatus( productId, 'remove' )

        $(`.wvpl-cart[data-product_id=${productId}]`)
            .attr('title', WavePlayer.__( 'Add to cart', 'waveplayer' ) )
            .attr('data-event', 'addToCart')
            .attr('data-callback', 'addToCart')
            .addClass('wvpl-add_to_cart')
            .removeClass('wvpl-in_cart')
            .removeClass('wvpl-spin')
    } )

})
