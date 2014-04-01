<?php
/**
 * flagfinder
 * https://github.com/noahm/flagfinder
 * fuzzy matching country names for display of flags
 * public domain flag images by mjames (http://www.famfamfam.com)
 * @author Noah Manneschmidt
 */
class FlagFinder {
	/**
	 * Defines how close a user input much match a country name
	 */
	const MAX_MATCH_DISTANCE = 2;

	/**
	 * Relative path to the image folder from this file
	 */
	const IMAGE_FOLDER = 'img/flags/';

	/**
	 * File ext of the images
	 */
	const IMAGE_EXT = 'gif';

	/**
	 * Web path to the image folder
	 */
	const WEB_PATH = '/img/flags/';

	/**
	 * Does a fuzzy lookup of country names to country codes and
	 * returns a country code for use with the getFlagPath method
	 *
	 * @param	string	country name from user
	 * @return	string	2 letter country code
	 */
	public static function getCode($country) {
		// maybe it is already a country code
		if (strlen($country) == 2 && in_array(strtolower($country), self::$codes)) {
			$match = strtolower($country);
		} else {

			// preprocess for search (reduces to lowercase roman alphabet)
			$searchString = preg_replace('/[^a-z]+/i', '', mb_strtolower($country));
			$closest = self::MAX_MATCH_DISTANCE + 1;
			$match = '';

			foreach (self::$codes as $name => $code) {
				// compute edit distance
				$distance = levenshtein($searchString, $name);
				// exact match found
				if ($distance == 0) {
					$match = $code;
					break;
				}
				// closer match than previous found
				if ($distance < $closest) {
					$closest = $distance;
					$match = $code;
				}
			}
		}

		if ($match) {
			$filename = $match.'.'.self::IMAGE_EXT;
			if (!is_file(__DIR__.'/'.self::IMAGE_FOLDER . $filename)) {
				$match = '';
			}
		}

		return $match;
	}

	/**
	 * Returns a path to a country flag given a country code
	 *
	 * @param	string	two letter country code
	 * @return	string	web path to an image file
	 */
	public static function getFlagPath($code) {
		return self::WEB_PATH . $code.'.'.self::IMAGE_EXT;
	}

	// from https://github.com/umpirsky/country-list/blob/master/country/cldr/en_US/country.php
	// processesd to lower case, minus punctuation, with some additions to optimize for our use case
	public static $codes = [
		'afghanistan' => 'af',
		'albania' => 'al',
		'algeria' => 'dz',
		'americansamoa' => 'as',
		'andorra' => 'ad',
		'angola' => 'ao',
		'anguilla' => 'ai',
		'antarctica' => 'aq',
		'antiguaandbarbuda' => 'ag',
		'antigua' => 'ag', // added
		'barbuda' => 'ag', // added
		'argentina' => 'ar',
		'armenia' => 'am',
		'aruba' => 'aw',
		'australia' => 'au',
		'austria' => 'at',
		'azerbaijan' => 'az',
		'bahamas' => 'bs',
		'bahrain' => 'bh',
		'bangladesh' => 'bd',
		'barbados' => 'bb',
		'belarus' => 'by',
		'belgium' => 'be',
		'belize' => 'bz',
		'benin' => 'bj',
		'bermuda' => 'bm',
		'bhutan' => 'bt',
		'bolivia' => 'bo',
		'bosniaandherzegovina' => 'ba',
		'bosnia' => 'ba', // added
		'herzegovina' => 'ba', // added
		'botswana' => 'bw',
		'bouvetisland' => 'bv',
		'brazil' => 'br',
		'britishantarcticterritory' => 'bq',
		'britishindianoceanterritory' => 'io',
		'britishvirginislands' => 'vg',
		'brunei' => 'bn',
		'bulgaria' => 'bg',
		'burkinafaso' => 'bf',
		'burundi' => 'bi',
		'cambodia' => 'kh',
		'cameroon' => 'cm',
		'canada' => 'ca',
		'cantonandenderburyislands' => 'ct',
		'capeverde' => 'cv',
		'caymanislands' => 'ky',
		'centralafricanrepublic' => 'cf',
		'chad' => 'td',
		'chile' => 'cl',
		'china' => 'cn',
		'christmasisland' => 'cx',
		'cocoskeelingislands' => 'cc',
		'colombia' => 'co',
		'comoros' => 'km',
		'congobrazzaville' => 'cg',
		'congokinshasa' => 'cd',
		'cookislands' => 'ck',
		'costarica' => 'cr',
		'croatia' => 'hr',
		'cuba' => 'cu',
		'cyprus' => 'cy',
		'czechrepublic' => 'cz',
		'ctedivoire' => 'ci',
		'denmark' => 'dk',
		'djibouti' => 'dj',
		'dominica' => 'dm',
		'dominicanrepublic' => 'do',
		'dronningmaudland' => 'nq',
		'eastgermany' => 'dd',
		'ecuador' => 'ec',
		'egypt' => 'eg',
		'elsalvador' => 'sv',
		'equatorialguinea' => 'gq',
		'eritrea' => 'er',
		'estonia' => 'ee',
		'ethiopia' => 'et',
		'falklandislands' => 'fk',
		'faroeislands' => 'fo',
		'fiji' => 'fj',
		'finland' => 'fi',
		'france' => 'fr',
		'frenchguiana' => 'gf',
		'frenchpolynesia' => 'pf',
		'frenchsouthernterritories' => 'tf',
		'frenchsouthernandantarcticterritories' => 'fq',
		'gabon' => 'ga',
		'gambia' => 'gm',
		'georgia' => 'ge',
		'germany' => 'de',
		'deutschland' => 'de', // added
		'ghana' => 'gh',
		'gibraltar' => 'gi',
		'greece' => 'gr',
		'greenland' => 'gl',
		'grenada' => 'gd',
		'guadeloupe' => 'gp',
		'guam' => 'gu',
		'guatemala' => 'gt',
		'guernsey' => 'gg',
		'guinea' => 'gn',
		'guineabissau' => 'gw',
		'guyana' => 'gy',
		'haiti' => 'ht',
		'heardislandandmcdonaldislands' => 'hm',
		'honduras' => 'hn',
		'hongkongsarchina' => 'hk',
		'hungary' => 'hu',
		'iceland' => 'is',
		'india' => 'in',
		'indonesia' => 'id',
		'iran' => 'ir',
		'iraq' => 'iq',
		'ireland' => 'ie',
		'isleofman' => 'im',
		'israel' => 'il',
		'italy' => 'it',
		'jamaica' => 'jm',
		'japan' => 'jp',
		'jersey' => 'je',
		'johnstonisland' => 'jt',
		'jordan' => 'jo',
		'kazakhstan' => 'kz',
		'kenya' => 'ke',
		'kiribati' => 'ki',
		'kuwait' => 'kw',
		'kyrgyzstan' => 'kg',
		'laos' => 'la',
		'latvia' => 'lv',
		'lebanon' => 'lb',
		'lesotho' => 'ls',
		'liberia' => 'lr',
		'libya' => 'ly',
		'liechtenstein' => 'li',
		'lithuania' => 'lt',
		'luxembourg' => 'lu',
		'macausarchina' => 'mo',
		'macedonia' => 'mk',
		'madagascar' => 'mg',
		'malawi' => 'mw',
		'malaysia' => 'my',
		'maldives' => 'mv',
		'mali' => 'ml',
		'malta' => 'mt',
		'marshallislands' => 'mh',
		'martinique' => 'mq',
		'mauritania' => 'mr',
		'mauritius' => 'mu',
		'mayotte' => 'yt',
		'metropolitanfrance' => 'fx',
		'mexico' => 'mx',
		'micronesia' => 'fm',
		'midwayislands' => 'mi',
		'moldova' => 'md',
		'monaco' => 'mc',
		'mongolia' => 'mn',
		'montenegro' => 'me',
		'montserrat' => 'ms',
		'morocco' => 'ma',
		'mozambique' => 'mz',
		'myanmarburma' => 'mm',
		'namibia' => 'na',
		'nauru' => 'nr',
		'nepal' => 'np',
		'netherlands' => 'nl',
		'netherlandsantilles' => 'an',
		'neutralzone' => 'nt',
		'newcaledonia' => 'nc',
		'newzealand' => 'nz',
		'nicaragua' => 'ni',
		'niger' => 'ne',
		'nigeria' => 'ng',
		'niue' => 'nu',
		'norfolkisland' => 'nf',
		'northkorea' => 'kp',
		'northvietnam' => 'vd',
		'northernmarianaislands' => 'mp',
		'norway' => 'no',
		'oman' => 'om',
		'pacificislandstrustterritory' => 'pc',
		'pakistan' => 'pk',
		'palau' => 'pw',
		'palestinianterritories' => 'ps',
		'palestine' => 'ps', // added
		'panama' => 'pa',
		'panamacanalzone' => 'pz',
		'papuanewguinea' => 'pg',
		'paraguay' => 'py',
		'peoplesdemocraticrepublicofyemen' => 'yd',
		'peru' => 'pe',
		'philippines' => 'ph',
		'pitcairnislands' => 'pn',
		'poland' => 'pl',
		'portugal' => 'pt',
		'puertorico' => 'pr',
		'qatar' => 'qa',
		'romania' => 'ro',
		'russia' => 'ru',
		'rwanda' => 'rw',
		'runion' => 're',
		'saintbarthlemy' => 'bl',
		'sainthelena' => 'sh',
		'saintkittsandnevis' => 'kn',
		'saintlucia' => 'lc',
		'saintmartin' => 'mf',
		'saintpierreandmiquelon' => 'pm',
		'saintvincentandthegrenadines' => 'vc',
		'saintvincent' => 'vc',
		'thegrenadines' => 'vc',
		'samoa' => 'ws',
		'sanmarino' => 'sm',
		'saudiarabia' => 'sa',
		'senegal' => 'sn',
		'serbia' => 'rs',
		'serbiaandmontenegro' => 'cs',
		'serbia' => 'cs', // added
		'montenegro' => 'cs', // added
		'seychelles' => 'sc',
		'sierraleone' => 'sl',
		'singapore' => 'sg',
		'slovakia' => 'sk',
		'slovenia' => 'si',
		'solomonislands' => 'sb',
		'somalia' => 'so',
		'southafrica' => 'za',
		'southgeorgiaandthesouthsandwichislands' => 'gs',
		'southkorea' => 'kr',
		'spain' => 'es',
		'srilanka' => 'lk',
		'sudan' => 'sd',
		'suriname' => 'sr',
		'svalbardandjanmayen' => 'sj',
		'janmayen' => 'sj', // added
		'svalbard' => 'sj', // added
		'swaziland' => 'sz',
		'sweden' => 'se',
		'switzerland' => 'ch',
		'syria' => 'sy',
		'sotomandprncipe' => 'st',
		'taiwan' => 'tw',
		'tajikistan' => 'tj',
		'tanzania' => 'tz',
		'thailand' => 'th',
		'timorleste' => 'tl',
		'togo' => 'tg',
		'tokelau' => 'tk',
		'tonga' => 'to',
		'trinidadandtobago' => 'tt',
		'trinidad' => 'tt', // added
		'tobago' => 'tt', // added
		'tunisia' => 'tn',
		'turkey' => 'tr',
		'turkmenistan' => 'tm',
		'turksandcaicosislands' => 'tc',
		'tuvalu' => 'tv',
		'usminoroutlyingislands' => 'um',
		'usmiscellaneouspacificislands' => 'pu',
		'usvirginislands' => 'vi',
		'uganda' => 'ug',
		'ukraine' => 'ua',
		'unionofsovietsocialistrepublics' => 'su',
		'ussr' => 'su',
		'unitedarabemirates' => 'ae',
		'unitedkingdom' => 'gb',
		'uk' => 'gb', // added
		'greatbriton' => 'gb', // added
		'unitedstates' => 'us',
		'unitedstatesofamerica' => 'us', // added
		'usa' => 'us', // added
		'unknownorinvalidregion' => 'zz',
		'uruguay' => 'uy',
		'uzbekistan' => 'uz',
		'vanuatu' => 'vu',
		'vaticancity' => 'va',
		'venezuela' => 've',
		'vietnam' => 'vn',
		'wakeisland' => 'wk',
		'wallisandfutuna' => 'wf',
		'westernsahara' => 'eh',
		'yemen' => 'ye',
		'zambia' => 'zm',
		'zimbabwe' => 'zw',
		'landislands' => 'ax',
		// below added because they were in the flag pack
		'england' => 'england',
		'wales' => 'wales',
		'scotland' => 'scotland',
		'europeanunion' => 'eu',
		'europe' => 'eu',
		'catalonia' => 'catalonia',
		'famfamfam' => 'fam', // easter egg from the maker of the icons (famfamfam.com)
	];
}

// Paste in (updated) country codes as $origcodes, uncomment and run directly to re-do the pre-processing
/*
foreach (FlagFinder::$origcodes as $code => $country) {
	FlagFinder::$codes[strtolower($code)] = preg_replace('/[^a-z]+/i', '', mb_strtolower($country));
}
var_export(array_flip(FlagFinder::$codes));
*/
