# mediawiki-extensions-LanguageNamespaces
MediaWiki extension that allows defining namespace names depending on the user language

# Requirements
MediaWiki 1.28 or later.

# Installation
```
cd extensions
git clone https://github.com/Nikerabbit/mediawiki-extensions-LanguageNamespaces.git LanguageNamespaces
```

Edit includes/Title/MediaWikiTitleCodec.php. In the beginning of getNamespaceName, add some code so that it looks like this:
```
	public function getNamespaceName( $namespace, $text ) {
		$language = RequestContext::getMain()->getLanguage()->getCode();
		$namespaces = $GLOBALS['wgLanguageNamespaces'];

		if ( isset( $namespaces[ $namespace ][ $language ] ) ) {
			return $namespaces[ $namespace ][ $language ];
		}

		if ( $this->language->needsGenderDistinction() &&
			MWNamespace::hasGenderDistinction( $namespace )
		) {
```

# Configuration
Edit LocalSettings.php as follows:
```
wfLoadExtension( 'LanguageNamespaces' );
```

To define language dependent namespace aliases, you can use the `$wgLanguageNamespaces` setting:
```
$wgLanguageNamespaces[ NS_HELP ] = [
	'fi' => 'Ohje',
	'sv' => 'Hjälp',
	'en' => 'Help',
];
```

For custom namespaces, there is no constant unless you create it yourself, for example like this:
```
define( 'NS_TIPS', 1000 );
define( 'NS_TIPS_TALK', 1001 );

$wgExtraNamespaces[NS_TIPS] = 'Tips';
$wgExtraNamespaces[NS_TIPS_TALK] = 'Tips_talk';
```
