# Fruits WP

Example WP project that is referenced for the Medium article: [Building maintainable Wordpress backends for Single Page Apps](https://medium.com/@gasim.appristas/building-maintainable-wordpress-backends-for-single-page-apps-125a9a3e7637).

## Installation

1. Install Wordpress
2. Delete wp-content
3. Clone this directory into wp-content using

	git clone https://github.com/appristas/example-wp-project.git wp-content/

4. Run `composer install`
5. Enable plugins in the following order: qTranslate-X, Carbon Fields: qTranslate-X, Carbon Fields. This is necessary because Carbon Fields plugin gives fatal PHP errors when Carbon Fields: qTranslate-X plugin is not loaded.
6. In order for multilanguage to work properly using `Accept-Language` header, I recommend the following settings for qTranslate-X (Settings > Language > General): 

	- URL Modification Mode: Use Query Mode (?lang=en). Most SEO unfriendly, not recommended.
	- Hide Content which is not available for the selected language: Unchecked
	- Show displayed language prefix when content is not available for the selected language: Unchecked
	- Show content in an alternative language when translation is not available for the selected language: Unchecked
	- Show language names in "Camel Case": Unchecked
	- Detect the language of the browser and redirect accordingly: Unchecked

## Usage


Admin Interface: Check out Fruits in wp-admin Sidebar

API endpoints:

- /v1/fruits -> All fruits
- /v1/fruits/category/:category-name -> All fruits by category
- /v1/fruits/:slug -> Single fruit by slug
