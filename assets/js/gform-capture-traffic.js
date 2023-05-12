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

	const utmSourceHiddenField = document.querySelectorAll('.utm_source input');
	const utmMediumHiddenField = document.querySelectorAll('.utm_medium input');
	const utmTermHiddenField = document.querySelectorAll('.utm_term input');

	console.log(utmSourceHiddenField);

	// Check the Query Params for UTM Parameter and add it on global const object.
	let getTrafficSource = getQueryParamsTrafficSourceData();

	if (0 === Object.keys(getTrafficSource).length) {
		getTrafficSource = getTrafficSourceData();
	}

	// Set the Value in Session/Cookie.

	// Set the Hidden Fields value.
	if (0 < utmSourceHiddenField.length) {
		setHiddenFieldsValue(utmSourceHiddenField, getTrafficSource['utm_source']);
	}

	if (0 < utmMediumHiddenField.length) {
		setHiddenFieldsValue(utmMediumHiddenField, getTrafficSource['utm_medium']);
	}

	if (0 < utmTermHiddenField) {
		setHiddenFieldsValue(utmTermHiddenField, getTrafficSource['utm_term']);
	}
}

/**
 * Set Hidden Fields Value.
 *
 * @param {HTMLNode} hiddenFields HTML Nodes for Hidden Fields.
 * @param {string} trafficValue   Value to be set in Hidden fields.
 * @returns void
 */
function setHiddenFieldsValue(hiddenFields, trafficValue) {

	if (!trafficValue) {
		return;
	}
	hiddenFields.forEach(hiddenField => {
		hiddenField.value = trafficValue;
	});
}

/**
 * Function to check through Query Param and search for UTM parameter and set traffic source.
 *
 * @returns object
 */
function getQueryParamsTrafficSourceData() {

	const returnObject = {};
	const urlParams = new URLSearchParams(window.location.search);

	for (const [key, value] of urlParams.entries()) {
		switch (key) {
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

	if ('' === referrer) {
		returnObject['utm_source'] = 'web_direct';
		returnObject['utm_medium'] = '';
		returnObject['utm_term'] = '';
	} else {
		returnObject = getSourceAndMediumForOrganicTraffic(referrer);
	}

	return returnObject;
}

// We can add more search engine here and directly we can add search engine.
const referrerEngineObject = {
	'https://www.google.com/': 'google.com',
	'https://www.bing.com/': 'bing.com',
	'https://search.yahoo.com/': 'yahoo.com',
	'https://yandex.com/': 'yandex.com',
};

/**
 * Get Source and Medium for Organic Search.
 *
 * @param {string} referrer Current referrer.
 *
 * @returns object.
 */
function getSourceAndMediumForOrganicTraffic(referrer) {

	const returnObject = {
		'utm_source': 'web_organic',
		'utm_medium': referrerEngineObject.hasOwnProperty(referrer) ? referrerEngineObject[referrer]: 'same',
		'utm_term': '', // Need to research for term keyword search.
	};

	return returnObject;
}

// On DomContentLoaded.
document.addEventListener('DOMContentLoaded', setHiddenFieldTrafficSources);