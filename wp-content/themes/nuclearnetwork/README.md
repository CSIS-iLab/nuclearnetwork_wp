[![Build Status](https://travis-ci.org/CSIS-iLab/nuclearnetwork_wp.svg?branch=master)](https://travis-ci.org/CSIS-iLab/nuclearnetwork_wp)

# nuclearnetwork_wp
WordPress theme for [Next Generation Nuclear Network](https://nuclearnetwork.csis.org). Developed from the [_s starter theme](http://underscores.me).

## Contributing
1. New features & updates should be created on individual branches. Branch from `master`
2. When ready, submit pull request back into `master`. Rebase the feature branch first.
3. TravisCI will automatically deploy changes on `master` to the staging site
4. After reviewing your work on the staging site, use WPEngine to move from staging to live

## Development
### Composer
This project uses [Composer](https://getcomposer.org/) to manage WordPress plugin dependencies.
To update dependencies, run `composer update`.

#### Required Plugins
- AddToAny Share
- Algolia
- Akismet
- Archive Control
- Coauthors Plus
- Disable Comments
- Disable Emojis
- Easy Footnotes
- Google Authenticator
- HTML in Widget Titles
- Jetpack
- Menu Item Custom Fields
- Search by Aloglia
- TinyMCE Advanced
- Widget Context
- Yoast SEO

## Compass
This project uses [Compass](http://compass-style.org/) to compile the SASS files. To run the compiler:
1. Navigate to `wp-content/themes/nuclearnetwork` folder
2. Run `compass watch`
