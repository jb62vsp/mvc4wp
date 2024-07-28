What is MVC4WP
===============

Model-View-Controller framework for WordPress theme

# Get Started

## Prerequisites

### Requirements

* GNU Make: 4.3
* PHP: 8.1
* Composer 2.7
* WordPress: 6.3
* Node.js: 22

### Project configuration

1. Copy to theme directoy.
    * Copy to `.../wordpress/wp-content/themes/`
2. Change directory name.
    ```
    $ cd wordpress/wp-content/themes/
    $ mv mvc4wp PROJECT_NAME
    ```
3. Setting project
    ```
    $ cd PROJECT_NAME
    $ make
    ```
4. WordPress setting
    * Login as administrator.
        - `https://HOSTNAME/wp-admin/`
    * Change theme.
        1. Open Appearance.
        2. Activate theme the MVC4WP.
    * Change Permalinks setting.
        1. `Settings` -> `Permalinks`
        2. `Permalink structure` select `Numeric`, and `Save Changes`.
5. Edit style.css(RECOMMENDED)
    * Edit Theme Name, Author, Description, and all that.

# Eevelopment Application

## Model

### Custom-Post

### Custom-Field

## View

## Controller

## URI-Routing

# Development Core (for INNER)

## Implementation

## Test

### Unit Test

## Git

### Branch

see below:

https://docs.github.com/ja/get-started/using-github/github-flow

### Commit comment

#### Prefix

See below:

https://github.com/angular/angular.js/blob/master/DEVELOPERS.md#type
