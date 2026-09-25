/**
 * Docmed: scroll reveals, the reviews slider, the doctors carousel, the tabs,
 * the appointment dialog and the header's shadow once the page has scrolled.
 *
 * All of them are enhancements. Without this file every section is visible,
 * the review slides and the doctors scroll sideways on their own, the three
 * tab panels stand one under another, and "Make an Appointment" is a link to
 * the Appointment page, so nothing on the page depends on it running.
 *
 * Reveals are skipped for a visitor who asks the system for reduced motion,
 * and a site owner can switch them off with the
 * `docmed_enable_scroll_animations` filter, which sets
 * `window.docmedMotion.enabled` to false.
 */
( function () {
	'use strict';

	var settings = window.docmedMotion || {};
	var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var motion = settings.enabled !== false && ! reduced && 'IntersectionObserver' in window;

	/*
	 * Only what is below the first screen is ever hidden. Anything a visitor can
	 * already see stays where it is: hiding the opening screen is what makes
	 * PageSpeed report no first contentful paint, and it flashes on load besides.
	 */
	function belowTheFold( el ) {
		return el.getBoundingClientRect().top > window.innerHeight * 0.92;
	}

	function reveals() {
		if ( ! motion ) {
			return;
		}

		var candidates = Array.prototype.slice.call( document.querySelectorAll( [
			'main .docmed-section-head',
			'main .wp-block-columns > .wp-block-column',
			'main .wp-block-post-template > .wp-block-post'
		].join( ',' ) ) );

		// Animate the innermost element, so a row of cards arrives one card at a
		// time rather than as one block. Nothing inside the slider: its slides
		// sit side by side off screen and would never be seen to arrive.
		var targets = candidates.filter( function ( el ) {
			return ! el.closest( '.docmed-slider, .docmed-carousel, .docmed-tabs__panel' ) && ! candidates.some( function ( other ) {
				return other !== el && el.contains( other );
			} );
		} ).filter( belowTheFold );

		if ( ! targets.length ) {
			return;
		}

		var rows = new Map();
		targets.forEach( function ( el ) {
			var row = rows.get( el.parentElement ) || [];
			row.push( el );
			rows.set( el.parentElement, row );
		} );
		rows.forEach( function ( row ) {
			row.forEach( function ( el, i ) {
				el.style.setProperty( '--docmed-reveal-delay', Math.min( i, 5 ) * 110 + 'ms' );
				el.classList.add( 'docmed-reveal' );
			} );
		} );

		document.documentElement.classList.add( 'docmed-motion' );

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-revealed' );
					observer.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px' } );

		targets.forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	/*
	 * The reviews slider. The slides are a horizontal scroll-snap strip already
	 * (style.css), so a finger or a trackpad moves them with or without this.
	 * The script adds dots, one per slide, as real
	 * buttons, and keeps the current one marked as the strip scrolls.
	 */
	function sliders() {
		Array.prototype.forEach.call( document.querySelectorAll( '.docmed-slider' ), function ( slider ) {
			var slides = Array.prototype.filter.call( slider.children, function ( el ) {
				return el.classList.contains( 'docmed-slide' );
			} );
			if ( slides.length < 2 ) {
				return;
			}

			slider.setAttribute( 'role', 'region' );
			slider.setAttribute( 'aria-label', settings.sliderLabel || 'Reviews' );

			var dots = document.createElement( 'div' );
			dots.className = 'docmed-slider__dots';

			var buttons = slides.map( function ( slide, i ) {
				var dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'docmed-slider__dot';
				dot.setAttribute( 'aria-label', ( settings.slideLabel || 'Show review %d' ).replace( '%d', i + 1 ) );
				dot.addEventListener( 'click', function () {
					slider.scrollTo( { left: slide.offsetLeft - slider.offsetLeft, behavior: reduced ? 'auto' : 'smooth' } );
				} );
				dots.appendChild( dot );
				return dot;
			} );

			slider.insertAdjacentElement( 'afterend', dots );

			function mark() {
				var index = Math.round( slider.scrollLeft / Math.max( 1, slider.clientWidth ) );
				index = Math.max( 0, Math.min( slides.length - 1, index ) );
				buttons.forEach( function ( dot, i ) {
					dot.setAttribute( 'aria-current', i === index ? 'true' : 'false' );
				} );
				// Slides out of view are hidden from assistive technology too.
				slides.forEach( function ( slide, i ) {
					if ( i === index ) {
						slide.removeAttribute( 'aria-hidden' );
					} else {
						slide.setAttribute( 'aria-hidden', 'true' );
					}
				} );
			}

			var pending = null;
			slider.addEventListener( 'scroll', function () {
				window.cancelAnimationFrame( pending );
				pending = window.requestAnimationFrame( mark );
			}, { passive: true } );
			mark();
		} );
	}

	/*
	 * The doctors carousel: a scroll-snap row in style.css, so it moves by
	 * touch on its own. The script adds the template's two arrows, which move
	 * it by one card and grey out at either end.
	 */
	function carousels() {
		Array.prototype.forEach.call( document.querySelectorAll( '.docmed-carousel' ), function ( track ) {
			var cards = track.children;
			if ( cards.length < 2 ) {
				return;
			}

			function arrow( dir ) {
				var b = document.createElement( 'button' );
				b.type = 'button';
				b.className = 'docmed-carousel__arrow docmed-carousel__arrow--' + dir;
				b.setAttribute( 'aria-label', 'prev' === dir ? ( settings.prevLabel || 'Previous' ) : ( settings.nextLabel || 'Next' ) );
				b.addEventListener( 'click', function () {
					var step = cards[ 0 ].getBoundingClientRect().width + parseFloat( getComputedStyle( track ).columnGap || 0 );
					track.scrollBy( { left: 'prev' === dir ? -step : step, behavior: reduced ? 'auto' : 'smooth' } );
				} );
				return b;
			}

			var wrap = document.createElement( 'div' );
			wrap.className = 'docmed-carousel__arrows';
			var prev = arrow( 'prev' );
			var next = arrow( 'next' );
			wrap.appendChild( prev );
			wrap.appendChild( next );
			track.parentElement.classList.add( 'has-docmed-carousel' );
			track.insertAdjacentElement( 'afterend', wrap );

			function update() {
				var max = track.scrollWidth - track.clientWidth - 2;
				prev.disabled = track.scrollLeft <= 2;
				next.disabled = track.scrollLeft >= max;
				wrap.hidden = max <= 0;
			}
			var pending = null;
			track.addEventListener( 'scroll', function () {
				window.cancelAnimationFrame( pending );
				pending = window.requestAnimationFrame( update );
			}, { passive: true } );
			window.addEventListener( 'resize', update );
			update();
		} );
	}

	/*
	 * Tabs. The pattern stores three labels and three panels; this makes the
	 * labels real tabs (WAI-ARIA tabs pattern: arrow keys, Home, End) and shows
	 * one panel at a time. Without it all three panels are simply shown.
	 */
	function tabs() {
		Array.prototype.forEach.call( document.querySelectorAll( '.docmed-tabs' ), function ( box, n ) {
			var labels = Array.prototype.slice.call( box.querySelectorAll( '.docmed-tab' ) );
			var panels = Array.prototype.slice.call( box.querySelectorAll( '.docmed-tabs__panel' ) );
			var count = Math.min( labels.length, panels.length );
			if ( count < 2 ) {
				return;
			}
			var list = labels[ 0 ].parentElement;
			list.setAttribute( 'role', 'tablist' );

			var tabsEls = labels.slice( 0, count ).map( function ( label, i ) {
				var tab = document.createElement( 'button' );
				tab.type = 'button';
				tab.className = label.className;
				tab.innerHTML = label.innerHTML;
				tab.id = 'docmed-tab-' + n + '-' + i;
				tab.setAttribute( 'role', 'tab' );
				tab.setAttribute( 'aria-controls', 'docmed-panel-' + n + '-' + i );
				label.replaceWith( tab );
				var panel = panels[ i ];
				panel.id = 'docmed-panel-' + n + '-' + i;
				panel.setAttribute( 'role', 'tabpanel' );
				panel.setAttribute( 'aria-labelledby', tab.id );
				panel.tabIndex = 0;
				return tab;
			} );

			function select( index, focus ) {
				tabsEls.forEach( function ( tab, i ) {
					var on = i === index;
					tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
					tab.tabIndex = on ? 0 : -1;
					panels[ i ].hidden = ! on;
				} );
				if ( focus ) {
					tabsEls[ index ].focus();
				}
			}

			tabsEls.forEach( function ( tab, i ) {
				tab.addEventListener( 'click', function () {
					select( i, false );
				} );
				tab.addEventListener( 'keydown', function ( event ) {
					var to = null;
					if ( 'ArrowRight' === event.key ) {
						to = ( i + 1 ) % count;
					} else if ( 'ArrowLeft' === event.key ) {
						to = ( i - 1 + count ) % count;
					} else if ( 'Home' === event.key ) {
						to = 0;
					} else if ( 'End' === event.key ) {
						to = count - 1;
					}
					if ( null !== to ) {
						event.preventDefault();
						select( to, true );
					}
				} );
			} );
			box.classList.add( 'is-tabbed' );
			select( 0, false );
		} );
	}

	/*
	 * "Make an Appointment" opens the form in a dialog (inc/appointment.php
	 * prints it). After a submission the page comes back with the result in
	 * the address; if the form it belongs to lives in the dialog, the dialog
	 * opens again so the visitor sees it.
	 */
	function appointment() {
		var dialog = document.getElementById( 'docmed-appointment-dialog' );
		if ( ! dialog || 'function' !== typeof dialog.showModal ) {
			return;
		}

		function open( event ) {
			if ( event ) {
				event.preventDefault();
			}
			dialog.showModal();
			var first = dialog.querySelector( 'select, input:not([type="hidden"]):not([tabindex="-1"])' );
			if ( first ) {
				first.focus();
			}
		}

		document.addEventListener( 'click', function ( event ) {
			var link = event.target.closest && event.target.closest( '.docmed-open-appointment a, a.docmed-open-appointment' );
			if ( link ) {
				open( event );
			}
		} );

		dialog.addEventListener( 'click', function ( event ) {
			if ( event.target === dialog || event.target.closest( '[data-docmed-close]' ) ) {
				dialog.close();
			}
		} );

		var query = new URLSearchParams( window.location.search );
		if ( 'appointment' === query.get( 'docmed-form-type' ) && ! document.querySelector( 'main .docmed-form--appointment' ) ) {
			open();
		}
	}

	/* The sticky header gains its shadow once the page has moved. */
	function header() {
		var bar = document.querySelector( '.docmed-header' );
		if ( ! bar ) {
			return;
		}
		var pending = null;
		function update() {
			bar.classList.toggle( 'is-scrolled', window.scrollY > 8 );
		}
		window.addEventListener( 'scroll', function () {
			window.cancelAnimationFrame( pending );
			pending = window.requestAnimationFrame( update );
		}, { passive: true } );
		update();
	}

	function init() {
		header();
		reveals();
		sliders();
		carousels();
		tabs();
		appointment();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
