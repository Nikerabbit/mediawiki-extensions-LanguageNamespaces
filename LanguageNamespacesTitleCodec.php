<?php

class LanguageNamespacesTitleCodec extends MediaWikiTitleCodec {
	public function __construct(
		array $namespaces,
		Language $language,
		GenderCache $genderCache,
		$localInterwikis = []
	) {
		parent::__construct( $language, $genderCache, $localInterwikis );
		$this->namespaces = $namespaces;
	}

	public function getNamespaceName( $namespace, $text ) {
		$language = RequestContext::getMain()->getLanguage()->getCode();

		if ( isset( $this->namespaces[ $namespace ][ $language ] ) ) {
			return $this->namespaces[ $namespace ][ $language ];
		}

		return parent::getNamespaceName( $namespace, $text );
	}
}
