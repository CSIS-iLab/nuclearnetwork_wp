[![Build Status](https://travis-ci.org/CSIS-iLab/nuclearnetwork_wp.svg?branch=master)](https://travis-ci.org/CSIS-iLab/nuclearnetwork_wp)

# nuclearnetwork_wp

WordPress theme for [Next Generation Nuclear Network](https://nuclearnetwork.csis.org). Developed from the [\_s starter theme](http://underscores.me).

## Contributing

1. New features & updates should be created on individual branches. Branch from `main`
2. When ready, submit pull request back into `main`. Rebase the feature branch first.
3. TravisCI will automatically deploy changes on `main` to the staging site
4. After reviewing your work on the staging site, use WPEngine to move from staging to live

## Development

### Composer

This project uses [Composer](https://getcomposer.org/) to manage WordPress plugin dependencies.
To update dependencies, run `composer update`.

**Note:** This project depends on AccessPress Anonymous Post Pro and Search Filter Pro, which are premium plugins and cannot be installed via composer at this time.

#### Required Plugins

- AccessPress Anonymous Post Pro
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
- Search Filter Pro
- TinyMCE Advanced
- Widget Context
- Yoast SEO

**AccessPress Anonymous Post Pro**
This plugin's `inc/save-post.php` file has been modified to create a guest account with the CoAuthors Plus plugin on post submit. Custom lines of code are denoted with `// JS - ` as a preceeding comment. Updates to this plugin must readd these custom changes in order to maintain expected functionality.

The `inc/front-form.php` file has also been added to add proper labels and HTML syntax to the form.

### If setting up the project for the first time:

1. Follow the instructions in the "Install Local" and "Connect Local to WP Engine" sections in this [blog post](https://wpengine.com/support/local/).
2. Follow the instructions in the "pull to Local from WP Engine" section to pull the "Nuclear Network Staging" Environment to your local machine
3. Navigate to the directory where Local created the site: eg `cd /Users/[YOUR NAME]/Local Sites/nuclearnetwork/app/public`
4. Initiate git & add remote origin. This will connect your local directory to the Git Repo and create a local `main` branch synced with the remote `main` branch.

```shell
$ git init
$ git remote add origin git@github.com:CSIS-iLab/nuclearnetwork_wp.git
$ git fetch origin
$ git checkout origin/main -ft
```

### If project is already set up:

To begin development, navigate to the theme directory and start npm.

```shell
$ cd wp-content/themes/nuclearnetwork_wp
$ npm install
$ npm start
```

### CI/CD

GitHub Actions will automatically build & deploy the theme to either the development, staging, or production environment on WPE depending on the settings specified in the deployment workflow.

- The `WPE_ENVIRONMENT_NAME: ${{ secrets.WPENGINE_DEV_ENV_NAME }}` setting will be deployed to the [WP Engine Development Environment](https://csisngnndev.wpengine.com/). The Development environment should be used to demo new features to programs.

- The `WPE_ENVIRONMENT_NAME: ${{ secrets.WPENGINE_PROD_ENV_NAME }}` setting will be deployed to the [WP Engine Production Environment](http://nuclearnetwork.wpengine.com/).
