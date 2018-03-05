<<<<<<< HEAD
# [HTML5 Blank](http://html5blank.com)

Powerful shell for rapidly deploying your WordPress projects.

* Project: [github.com/toddmotto/html5blank](https://github.com/toddmotto/html5blank)
* Website: [html5blank.com](http://html5blank.com)
* Twitter: [@html5blank](http://twitter.com/html5blank)
* Author : [Todd Motto](http://toddmotto.com) // [@toddmotto](http://twitter.com/toddmotto)

## Contributors (in order of pull request)
[David Munn](https://github.com/Munnday), [Patrick Zeinert](https://github.com/CoeusCC), [J-Rabe](https://github.com/J-Rabe), [Steve Steiner](https://github.com/ssteinerx), [Kyle Hudson](https://github.com/diskhub), [chrisdl](https://github.com/chrisdl), [Marcel Miranda](https://github.com/reaktivo), [Fx Bénard](https://github.com/fxbenard), Ioan Virag, [Mohamed Elkebir](https://github.com/elkebirmed), [lregla](https://github.com/lregla), Carlos Pinar, [Joshua Lyman](https://github.com/jlyman), [Kevin Plattret](https://github.com/kevinplattret), [Wesllei Henrique](https://github.com/wesllei), [Stacey Cordoni](https://github.com/staceycordoni).

## Getting Started with HTML5 Blank

Download the latest version from [html5blank.com](http://html5blank.com)

## Get involved! Make HTML5 Blank better

There are a few ways to get involved, submit a Pull Request, or submit a comment on the website - [html5blank.com](http://html5blank.com)

## Features

### HTML5
* Basic Semantic HTML5 Markup
* W3C Valid Code Foundations
* Responsive Ready, ViewPort meta data
* HTML Class support for IE7, IE8, IE9 Conditionals (HTML5 Boilerplate)
* Clean, neatly organised code, with PHP annotations

### jQuery + JavaScript
* Replaced built-in WordPress enqueue with Google CDN
* Protocol relative jQuery if Google CDN offline (HTML5 Boilerplate)
* Conditionizr for cross-platform/device detects and enhancements
* Modernizr feature detection, HTML5 element support for legacy, progressive enhancement (HTML5 Boilerplate)
* DOM Ready JavaScript file setup (scripts.js) for instant JavaScript development
* JavaScript files enqueued using WordPress functions into wp_head

### CSS3
* HTML5 Boilerplate reset
* Media Queries framework for instant development using @media
* @font-face empty framework with Fonts folder setup ready for new custom fonts
* CSS3 custom selection styles
* Inline print styles (HTML5 Boilerplate)
* Body element config, including Optimize Legibility for kerning and font-smoothing
* Replaced focus styles to avoid blue blur in field elements, replaced with border
* Stylesheet enqueued using WordPress functions into wp_head

### Preloaded Functions (functions.php)
* Enqueue Scripts functions setup
* Enqueue Styles functions setup
* Dynamic WordPress Menu Navigation Support, preloaded with 3 Dynamic menus
* Cleaned up dynamic nav output (Remove outer 'div')
* Remove all injected classes from nav items, ID's, Page ID's
* Custom Post Type x1 preloaded for demonstration, supporting: Category, Tags, Post Thumbnails, Excerpts
* Dynamic Sidebar with x2 Widget Areas, and sidebar.php setup
* WordPress Thumbnail Support, no Plugin image cropping, custom Arrays and Thumbnail settings
* Custom Excerpt callbacks, with changeable callback numbers
* Replaced 'Read More' button for custom Excerpt callbacks
* Demo Shortcodes included, with Nested Shortcode capability
* Add Slug to body class (Starkers Theme credit)
* wp_head functions stripped right down, remove excess injected junk
* All functions annotated, categorised into sections, filters, actions, shortcodes etc.
* Space for development, neatly organised code with Modules/External files

### Theme Files and Functionality
* Built in Pagination, no plugins (strips out prev + next post and gives page numbers)
* Optimised Google Analytics in footer (HTML5 Boilerplate)
* Widget Area Sidebar support, functions in place to get developing
* Custom Search Form included (searchform.php) - fully editable
* Tags support for showing Post Tags
* Category support for showing the Category of post
* Author support showing the author
* Demo Custom Page Template for expansion
=======
[![Build Status](https://travis-ci.org/Automattic/_s.svg?branch=master)](https://travis-ci.org/Automattic/_s)

_s
===

Hi. I'm a starter theme called `_s`, or `underscores`, if you like. I'm a theme meant for hacking so don't use me as a Parent Theme. Instead try turning me into the next, most awesome, WordPress theme out there. That's what I'm here for.

My ultra-minimal CSS might make me look like theme tartare but that means less stuff to get in your way when you're designing your awesome theme. Here are some of the other more interesting things you'll find here:

* A just right amount of lean, well-commented, modern, HTML5 templates.
* A helpful 404 template.
* A custom header implementation in `inc/custom-header.php` just add the code snippet found in the comments of `inc/custom-header.php` to your `header.php` template.
* Custom template tags in `inc/template-tags.php` that keep your templates clean and neat and prevent code duplication.
* Some small tweaks in `inc/template-functions.php` that can improve your theming experience.
* A script at `js/navigation.js` that makes your menu a toggled dropdown on small screens (like your phone), ready for CSS artistry. It's enqueued in `functions.php`.
* 2 sample CSS layouts in `layouts/` for a sidebar on either side of your content.
* Smartly organized starter CSS in `style.css` that will help you to quickly get your design off the ground.
* Licensed under GPLv2 or later. :) Use it to make something cool.

Getting Started
---------------

If you want to keep it simple, head over to https://underscores.me and generate your `_s` based theme from there. You just input the name of the theme you want to create, click the "Generate" button, and you get your ready-to-awesomize starter theme.

If you want to set things up manually, download `_s` from GitHub. The first thing you want to do is copy the `_s` directory and change the name to something else (like, say, `megatherium-is-awesome`), and then you'll need to do a five-step find and replace on the name in all the templates.

1. Search for `'_s'` (inside single quotations) to capture the text domain.
2. Search for `_s_` to capture all the function names.
3. Search for `Text Domain: _s` in `style.css`.
4. Search for <code>&nbsp;_s</code> (with a space before it) to capture DocBlocks.
5. Search for `_s-` to capture prefixed handles.

OR

1. Search for: `'_s'` and replace with: `'megatherium-is-awesome'`
2. Search for: `_s_` and replace with: `megatherium_is_awesome_`
3. Search for: `Text Domain: _s` and replace with: `Text Domain: megatherium-is-awesome` in `style.css`.
4. Search for: <code>&nbsp;_s</code> and replace with: <code>&nbsp;Megatherium_is_Awesome</code>
5. Search for: `_s-` and replace with: `megatherium-is-awesome-`

Then, update the stylesheet header in `style.css`, the links in `footer.php` with your own information and rename `_s.pot` from `languages` folder to use the theme's slug. Next, update or delete this readme.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!
>>>>>>> master
