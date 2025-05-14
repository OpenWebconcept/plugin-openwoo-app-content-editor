# OpenWoo.App Content Editor Plugin

A content editor in WordPress for the OpenWoo.App.

## Requirements

### OpenWoo.App Content Editor Plugin

In order to make the OpenWoo.App Content Editor Plugin work, you will need to have a WordPress installation with at least the following installed (and activated):

* [WordPress](https://wordpress.org/)
* [CMB2](https://wordpress.org/plugins/cmb2/)
* [CMB2 Flexible Content](https://github.com/acato-plugins/cmb2-flexible-content)

On this WordPress installation you will have to enable pretty permalinks (Settings > Permalinks > Select any of the options that is not plain).

## Installation

### Manual installation

1. Upload the `openwoo-app-content-editor` folder to the `/wp-content/plugins/` directory.
2. Activate the OpenWoo.App Content Editor Plugin through the 'Plugins' menu in WordPress.

### Composer installation

1. `composer source git@github.com:OpenWebconcept/plugin-openwoo-app-content-editor.git`
2. `composer require acato/openwoo-app-content-editor`
3. Activate the OpenWoo.App Content Editor Plugin through the 'Plugins' menu in WordPress.

## Development

### Coding Standards

Please remember, we use the WordPress PHP Coding Standards for this plugin! (https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/) To check if your changes are compatible with these standards:

*  `cd /wp-content/plugins/openwoo-app-content-editor`
*  `composer install` (this step is only needed once after installing the plugin)
*  `./vendor/bin/phpcs --standard=phpcs.xml.dist .`
*  See the output if you have made any errors.
    *  Errors marked with `[x]` can be fixed automatically by phpcbf, to do so run: `./vendor/bin/phpcbf --standard=phpcs.xml.dist .`

N.B. the `composer install` command will also install a git hook, preventing you from committing code that isn't compatible with the coding standards.

### PHPStan

Please remember, we use PHPStan to check for errors in the code. To check if your changes are compatible with PHPStan:

*  `cd /wp-content/plugins/openwoo-app-content-editor`
* `composer install` (this step is only needed once after installing the plugin)
* `./vendor/bin/phpstan analyse`
* See the output if you have made any errors.

### Translations
```
wp i18n make-pot . languages/openwoo-app-content-editor.pot --exclude="node_modules/,vendor/,stubs/,wp-content/" --domain="openwoo-app-content-editor"
```

```
cd languages && wp i18n make-json openwoo-app-content-editor-nl_NL.po --no-purge
```

### Custom Post Types
This plugin adds four custom post types to WordPress:
- OpenWoo - Pages
  - N.B. A page with the slug 'home' will get specific fields for editing parts of the homepage.
- OpenWoo - FAQ
- OpenWoo - Lists
- OpenWoo - Categories

### Custom Menu's
This plugin adds two custom menu's to the WordPress admin, that are used in the OpenWoo.App footer:
- OpenWoo - This website
- OpenWoo - Quick links

### REST API Endpoints
This plugin adds the following REST API GET-endpoints:
- to retrieve all pages: `/wp-json/owc/owace/v1/api/public/pages`
- to retrieve a specific page by slug: `/wp-json/owc/owace/v1/api/public/pages/{slug}`
- to retrieve all faqs: `/wp-json/owc/owace/v1/api/public/faqs`
- to retrieve a specific faq by id: `/wp-json/owc/owace/v1/api/public/faqs/{id}`
- to retrieve all menus: `/wp-json/owc/owace/v1/api/public/menu`
- to retrieve a specific menu by slug: `/wp-json/owc/owace/v1/api/public/menu/{slug}`
- to retrieve all categories: `/wp-json/owc/owace/v1/api/public/categories`

### Integration with plugins
This plugin is compatible with the following open source projects:
* [CMB2](https://wordpress.org/plugins/cmb2/)
* [CMB2 Flexible Content](https://github.com/acato-plugins/cmb2-flexible-content)

### OpenGemeenten icons
This plugin uses SVG icons that are supplied by the OpenGemeenten Iconenset. More information about the icons can be found [here](https://www.opengemeenten.nl/producten/iconenset).

