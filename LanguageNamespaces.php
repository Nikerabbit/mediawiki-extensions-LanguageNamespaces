<?php

use MediaWiki\MediaWikiServices;

class LanguageNamespaces {
	public static function onMediaWikiServices( MediaWikiServices $services ) {
		$services->redefineService(
			'_MediaWikiTitleCodec',
			function( MediaWikiServices $services ) {
				global $wgContLang, $wgLanguageNamespaces;

				return new LanguageNamespacesTitleCodec(
					$wgLanguageNamespaces,
					$wgContLang,
					$services->getGenderCache(),
					$services->getMainConfig()->get( 'LocalInterwikis' )
				);
			}
		);
	}

	public static function onLocalisationCacheRecache(
		LocalisationCache $lc,
		$cacheCode,
		array &$allData,
		&$purgeBlobs
	) {
		global $wgLanguageNamespaces;

		$allData['deps']['wgLanguageNamespaces'] = new MainConfigDependency( 'LanguageNamespaces' );

		foreach ( $wgLanguageNamespaces as $namespace => $translations ) {
			foreach ( $translations as $code => $translation ) {
				if ( $code === $cacheCode ) {
					$allData['namespaceNames'][$namespace] = $translation;
				} else {
					$allData['namespaceAliases'][$translation] = $namespace;
				}
			}
		}
	}
}
