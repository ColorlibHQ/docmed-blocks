/**
 * The colorlib.com product page's screenshots, from a Playground with the demo
 * content imported (the blueprint runs .dev/demo/import.php).
 *
 * Viewport captures at 1440x1000, scale 1, resized with Lanczos to exactly
 * 1140x792, progressive JPEG q82, into .dev/publish/images/. The palettes image
 * is a grid exactly 1140 wide, two rows of four with 12px gutters, each tile
 * the same section under one palette applied client-side. The cards: the home
 * hero at 1200x800 and 1200x900. Never full-page shots.
 *
 *   node .dev/publish/shoot.mjs            # WP_URL defaults to the 9491 Playground
 *
 * @package Docmed
 */

import { chromium } from 'playwright';
import sharp from 'sharp';
import { mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { paletteCss } from '../photo-ground.mjs';

const site = ( process.env.WP_URL || 'http://127.0.0.1:9491' ).replace( /\/$/, '' );
const out = join( dirname( fileURLToPath( import.meta.url ) ), 'images' );
mkdirSync( out, { recursive: true } );

const W = 1440;
const H = 1000;

const browser = await chromium.launch();
const context = await browser.newContext( {
	viewport: { width: W, height: H },
	deviceScaleFactor: 1,
	reducedMotion: 'reduce',
} );
const page = await context.newPage();

async function open( path, { dark = false, palette = '' } = {} ) {
	await page.goto( site + path, { waitUntil: 'load', timeout: 90000 } );
	// Playground logs every visitor in; the admin bar is not part of the theme.
	await page.addStyleTag( { content: '#wpadminbar{display:none!important} html{margin-top:0!important} :root{--wp-admin--admin-bar--height:0px!important}' } );
	if ( palette ) {
		await page.addStyleTag( { content: await paletteCss( palette ) } );
	}
	await page.evaluate( ( on ) => {
		document.documentElement.classList.toggle( 'docmed-dark', on );
		document.documentElement.style.colorScheme = on ? 'dark' : 'light';
	}, dark );
	await page.evaluate( async () => {
		document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
			img.loading = 'eager';
		} );
		await Promise.allSettled( [ ...document.images ].map( ( img ) => img.decode().catch( () => {} ) ) );
	} );
	await page.waitForTimeout( 1200 );
}

// Scroll so the element's top sits just under the sticky header.
async function scrollTo( selector, offset = 0 ) {
	await page.evaluate( ( [ sel, off ] ) => {
		const el = document.querySelector( sel );
		const header = document.querySelector( '.docmed-header__main' );
		const h = header ? header.getBoundingClientRect().height : 0;
		window.scrollTo( 0, el.getBoundingClientRect().top + window.scrollY - h + off );
	}, [ selector, offset ] );
	await page.waitForTimeout( 900 );
}

// Nudge the scroll (up to 240px either way) until no line of text is cut by
// the top edge (under the sticky header) or the bottom edge of the frame.
async function settle() {
	const y = await page.evaluate( () => {
		const header = document.querySelector( '.docmed-header__main' );
		const top = header ? header.getBoundingClientRect().bottom : 0;
		const bottom = window.innerHeight;
		const leaves = [];
		const walker = document.createTreeWalker( document.body, NodeFilter.SHOW_TEXT );
		while ( walker.nextNode() ) {
			const n = walker.currentNode;
			if ( ! n.textContent.trim() || n.parentElement.closest( 'header, dialog, .screen-reader-text' ) ) {
				continue;
			}
			const r = document.createRange();
			r.selectNodeContents( n );
			for ( const box of r.getClientRects() ) {
				if ( box.width && box.height ) {
					leaves.push( [ box.top + window.scrollY, box.bottom + window.scrollY ] );
				}
			}
		}
		const base = window.scrollY;
		for ( const d of [ 0, 10, -10, 20, -20, 30, -30, 40, -40, 60, -60, 80, -80, 100, -100, 130, -130, 160, -160, 200, -200, 240, -240 ] ) {
			const s = base + d;
			const cut = leaves.some( ( [ a, b ] ) => ( a < s + top && b > s + top ) || ( a < s + bottom && b > s + bottom ) );
			if ( ! cut ) {
				return s;
			}
		}
		return base;
	} );
	await page.evaluate( ( to ) => window.scrollTo( 0, to ), y );
	await page.waitForTimeout( 500 );
}

async function save( name, buffer, width = 1140, height = 792 ) {
	await sharp( buffer )
		.resize( width, height, { fit: 'cover', position: 'top', kernel: 'lanczos3' } )
		.jpeg( { quality: 82, progressive: true, mozjpeg: true } )
		.toFile( join( out, name ) );
	console.log( name );
}

// Home: the hero, as a visitor lands.
await open( '/' );
await save( 'docmed-block-theme-home.jpg', await page.screenshot() );

// The cards: the home hero only, stretched to fill the frame under the header
// (the photograph is height-fitted, so the doctor stays on the right and the
// words keep clear of his face).
async function heroCard( name, vw, vh, w, h ) {
	await page.setViewportSize( { width: vw, height: vh } );
	await open( '/' );
	await page.evaluate( () => {
		const hero = document.querySelector( '.docmed-hero' );
		const top = hero.getBoundingClientRect().top;
		hero.style.setProperty( 'min-height', Math.ceil( window.innerHeight - top ) + 'px', 'important' );
		document.querySelector( '.docmed-hero__words' ).style.maxWidth = '34rem';
	} );
	await page.waitForTimeout( 600 );
	await save( name, await page.screenshot(), w, h );
}
await heroCard( 'docmed-free-medical-wordpress-theme.jpg', 1500, 1000, 1200, 800 );
await heroCard( 'docmed-free-medical-wordpress-theme-card.jpg', 1440, 1080, 1200, 900 );
await page.setViewportSize( { width: W, height: H } );

// Departments.
await open( '/' );
await scrollTo( '#departments', 60 );
await settle();
await save( 'docmed-block-theme-departments.jpg', await page.screenshot() );

// The appointment form, opened from the header.
await open( '/about/' );
await page.evaluate( () => document.querySelector( '.docmed-header__cta a' ).click() );
await page.waitForTimeout( 600 );
await save( 'docmed-block-theme-appointment-form.jpg', await page.screenshot() );

// Doctors: the team page.
await open( '/doctors/' );
await scrollTo( '#team', 20 );
await settle();
await save( 'docmed-block-theme-doctors.jpg', await page.screenshot() );

// Reviews and tabs.
await open( '/' );
await scrollTo( '.docmed-reviews', 0 );
await settle();
await save( 'docmed-block-theme-reviews-tabs.jpg', await page.screenshot() );

// Dark mode: the welcome block and the departments.
await open( '/', { dark: true } );
await scrollTo( '.docmed-welcome', 60 );
await settle();
await save( 'docmed-block-theme-dark-mode.jpg', await page.screenshot() );

// Blog.
await open( '/blog/' );
await scrollTo( 'main', 0 );
await settle();
await save( 'docmed-block-theme-blog.jpg', await page.screenshot() );

// Palettes: the service band and the welcome block under all eight.
const palettes = [
	[ 'colors-1-sky', 'Sky' ], [ 'colors-2-teal', 'Teal' ], [ 'colors-3-navy', 'Navy' ], [ 'colors-4-sage', 'Sage' ],
	[ 'colors-5-plum', 'Plum' ], [ 'colors-6-coral', 'Coral' ], [ 'colors-7-midnight', 'Midnight' ], [ 'colors-8-graphite', 'Graphite' ],
];
const gutter = 12;
const tileW = ( 1140 - 3 * gutter ) / 4; // 276
const tileH = Math.round( tileW * H / W ); // 192
const tiles = [];
for ( const [ slug, name ] of palettes ) {
	await open( '/', { palette: slug } );
	await scrollTo( '.docmed-band', -90 );
	const shot = await sharp( await page.screenshot() ).resize( tileW, tileH, { fit: 'cover', position: 'top', kernel: 'lanczos3' } ).toBuffer();
	const label = Buffer.from(
		`<svg width="${ tileW }" height="${ tileH }"><rect x="8" y="${ tileH - 32 }" rx="4" width="${ 16 + name.length * 8.4 }" height="24" fill="rgba(0,0,0,.75)"/>` +
		`<text x="16" y="${ tileH - 15 }" font-family="Helvetica, Arial, sans-serif" font-size="13" font-weight="600" fill="#fff">${ name }</text></svg>`
	);
	tiles.push( await sharp( shot ).composite( [ { input: label } ] ).toBuffer() );
}
const grid = await sharp( {
	create: { width: 1140, height: tileH * 2 + gutter, channels: 3, background: '#ffffff' },
} ).composite( tiles.map( ( input, i ) => ( {
	input,
	left: ( i % 4 ) * ( tileW + gutter ),
	top: Math.floor( i / 4 ) * ( tileH + gutter ),
} ) ) ).jpeg( { quality: 82, progressive: true, mozjpeg: true } ).toFile( join( out, 'docmed-block-theme-colour-palettes.jpg' ) );
console.log( 'docmed-block-theme-colour-palettes.jpg', grid.width, grid.height );

await browser.close();
