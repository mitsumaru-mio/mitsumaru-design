/**
 * mitsumaru design theme — front-end interactions.
 * No build step / no dependencies: plain DOM APIs only.
 */
( function () {
	'use strict';

	/* ---------------------------------------------------------------
	 * Off-canvas menu (hamburger toggle)
	 * ------------------------------------------------------------- */
	var toggle   = document.getElementById( 'js-menu-toggle' );
	var panel    = document.getElementById( 'js-offcanvas' );
	var backdrop = document.getElementById( 'js-offcanvas-backdrop' );
	var closeBtn = document.getElementById( 'js-offcanvas-close' );

	function openMenu() {
		panel.classList.add( 'is-open' );
		backdrop.classList.add( 'is-open' );
		panel.setAttribute( 'aria-hidden', 'false' );
		toggle.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
	}

	function closeMenu() {
		panel.classList.remove( 'is-open' );
		backdrop.classList.remove( 'is-open' );
		panel.setAttribute( 'aria-hidden', 'true' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
	}

	if ( toggle && panel ) {
		toggle.addEventListener( 'click', function () {
			panel.classList.contains( 'is-open' ) ? closeMenu() : openMenu();
		} );
		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeMenu );
		}
		if ( backdrop ) {
			backdrop.addEventListener( 'click', closeMenu );
		}
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				closeMenu();
			}
		} );
	}

	/* ---------------------------------------------------------------
	 * Front-page News teaser: cycle through the latest posts
	 * without a page reload.
	 * ------------------------------------------------------------- */
	var slidesWrap = document.getElementById( 'js-news-slides' );
	if ( slidesWrap ) {
		var slides  = Array.prototype.slice.call( slidesWrap.querySelectorAll( '.news-teaser__slide' ) );
		var prevBtn = document.getElementById( 'js-news-prev' );
		var nextBtn = document.getElementById( 'js-news-next' );
		var current = 0;

		function showSlide( index ) {
			slides[ current ].classList.remove( 'is-active' );
			current = ( index + slides.length ) % slides.length;
			slides[ current ].classList.add( 'is-active' );
		}

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				showSlide( current - 1 );
			} );
		}
		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				showSlide( current + 1 );
			} );
		}
	}
} )();
