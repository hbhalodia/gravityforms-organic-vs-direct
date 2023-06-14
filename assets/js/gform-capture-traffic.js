/**
 * Js File to add the hidden field value based on traffic source.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * Set traffic sources on hidden fileds.
 *
 * @returns void
 */
function setHiddenFieldTrafficSources() {

	const utmCampaignHiddenField = document.querySelectorAll( '.utm_campaign input' );
	const utmSourceHiddenField = document.querySelectorAll( '.utm_source input' );
	const utmMediumHiddenField = document.querySelectorAll( '.utm_medium input' );
	const utmTermHiddenField = document.querySelectorAll( '.utm_term input' );

	// Check the Query Params for UTM Parameter and add it on global const object.
	let getTrafficSource = getQueryParamsTrafficSourceData();

	if ( 0 === Object.keys( getTrafficSource ).length ) {

		getTrafficSource = getCookie( 'GFOrganicDirectTrafficSouce' );

		if ( null === getTrafficSource || 'undefined' === typeof getTrafficSource ) {

			getTrafficSource = getTrafficSourceData();

			// Store value in Cookies.
			createCookie( 'GFOrganicDirectTrafficSouce', JSON.stringify( getTrafficSource ), 30 );
		} else {
			getTrafficSource = JSON.parse( getTrafficSource );
		}
	} else {
		// Store value in Cookies.
		createCookie( 'GFOrganicDirectTrafficSouce', JSON.stringify( getTrafficSource ), 30 );
	}

	// Set the Hidden Fields value based on cookie or first time visit within cookie expiration.
	if ( 0 < utmCampaignHiddenField.length ) {
		setHiddenFieldsValue( utmCampaignHiddenField, getTrafficSource['utm_campaign'] );
	}

	if ( 0 < utmSourceHiddenField.length ) {
		setHiddenFieldsValue( utmSourceHiddenField, getTrafficSource['utm_source'] );
	}

	if ( 0 < utmMediumHiddenField.length ) {
		setHiddenFieldsValue( utmMediumHiddenField, getTrafficSource['utm_medium'] );
	}

	if ( 0 < utmTermHiddenField ) {
		setHiddenFieldsValue( utmTermHiddenField, getTrafficSource['utm_term'] );
	}
}

/**
 * Set Hidden Fields Value.
 *
 * @param {HTMLNode} hiddenFields HTML Nodes for Hidden Fields.
 * @param {string} trafficValue   Value to be set in Hidden fields.
 * @returns void
 */
function setHiddenFieldsValue( hiddenFields, trafficValue ) {

	if ( ! trafficValue ) {
		return;
	}
	hiddenFields.forEach( hiddenField => {
		hiddenField.value = trafficValue;
	} );
}

/**
 * Function to check through Query Param and search for UTM parameter and set traffic source.
 *
 * @returns object
 */
function getQueryParamsTrafficSourceData() {

	const returnObject = {};
	const urlParams = new URLSearchParams( window.location.search ); // phpcs:ignore WordPressVIPMinimum.JS.Window.location

	for ( const [ key, value ] of urlParams.entries() ) {
		switch ( key ) {
			case 'utm_campaign':
				returnObject['utm_campaign'] = value;
				break;
			case 'utm_source':
				returnObject['utm_source'] = value;
				break;
			case 'utm_medium':
				returnObject['utm_medium'] = value;
				break;
			case 'utm_term':
				returnObject['utm_term'] = value;
		}
	}

	return returnObject;
}

/**
 * Function to get the traffic source from document.referrer.
 *
 * @return object
 */
function getTrafficSourceData() {

	const referrer = document.referrer;

	let returnObject = {};

	if ( '' === referrer ) {
		returnObject['utm_campaign'] = '';
		returnObject['utm_source'] = 'none';
		returnObject['utm_medium'] = 'direct';
		returnObject['utm_term'] = '';
	} else {
		returnObject = getSourceAndMediumForOrganicTraffic( referrer );
	}

	return returnObject;
}

// We can add more search engine here and directly we can add search engine.
const referrerEngineObject = {
	'https://www.google.com/': 'google',
	'https://www.bing.com/': 'bing',
	'https://search.yahoo.com/': 'yahoo',
	'https://yandex.com/': 'yandex',
	'https://duckduckgo.com/': 'duckduckgo',
};

/**
 * Get Source and Medium for Organic Search.
 *
 * @param {string} referrer Current referrer.
 *
 * @returns object.
 */
function getSourceAndMediumForOrganicTraffic( referrer ) {

	let websiteRef = false;

	if ( referrer.includes( window.location.hostname ) ) { // phpcs:ignore WordPressVIPMinimum.JS.Window.location
		websiteRef = true;
	}

	const returnObject = {
		'utm_campaign': '',
		'utm_source': websiteRef ? 'website' : ( referrerEngineObject.hasOwnProperty( referrer ) ? referrerEngineObject[ referrer ] : 'other' ),
		'utm_medium': websiteRef ? 'website' : 'organic',
		'utm_term': '', // Need to research for term keyword search.
	};

	return returnObject;
}

/**
 * Function to create the cookie and set the traffic source.
 *
 * @param {string} name    Cookie Name.
 * @param {string} value   Cookie Value.
 * @param {float}  minutes Cookie Expiration time.
 *
 * @returns void
 */
function createCookie( name, value, minutes ) {

	let expires = '';
	if ( minutes ) {
		let date = new Date();
		date.setTime( date.getTime() + ( minutes * 60 * 1000 ) );
		expires = '; expires=' + date.toGMTString();
	}
	document.cookie = name + '=' + value + expires + '; path=/';
}

/**
 * Function to fetch the cookie stored.
 *
 * @param {string} name Cookie Name to fetch.
 *
 * @returns {string|null}
 */
function getCookie( name ) {

	var nameEQ = name + '=';
	var ca = document.cookie.split( ';' );
	for ( let i = 0; i < ca.length; i++ ) {
		let c = ca[ i ];
		while ( ' ' === c.charAt(0) ) {
			c = c.substring( 1, c.length );
		}
		if ( 0 === c.indexOf( nameEQ ) ) {
			return c.substring( nameEQ.length, c.length );
		}
	}
	return null;
}

// On DomContentLoaded.
document.addEventListener( 'DOMContentLoaded', setHiddenFieldTrafficSources );
