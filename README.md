# Useragent Details

- Version: 1.1.1
- Author: Phill Gray
- Build Date: 2011-08-30
- Requirements: Symphony 2.2

## Installation

- Upload the 'useragent_details' folder to your Symphony 'extensions' folder.
- Enable it by selecting "Useragent Details", choose Enable from the with-selected menu, then click Apply.

## Usage

Bundles a datasource that outputs the users browser, version, platform, platform version, if it's a mobile device, a robot or using chromeframe and IP address. Easy!

There is a setting on the preferences page to include geolocationing based on the IP address using Geoplugin. This is disabled by default as some people don't want the page load delay associated with geolocationing.

## Uses

In no way is this extension a replacement for ie conditionals.

**Do not use this extension to soley provide content/styles etc to a couple of browsers only. There are dozens of browsers out there in use, so you will only harm your website by isolating it. You should create your site as normal and use this extension to add content specific to certain technologies, like tablets, mobiles or html5 compatible/non-compatible browsers.**

A use case might be: You need to style your site for a tablet, but your main design has massive hero images that will slow it down. Using media queries will only set that area to `display: none` meaning the data still loads. So using this extension to not show the content if it's a tablet OS will eliminate that problem.

Another case might be that you have created a html5/css3 demo which only works in the latest webkit/moz browsers, using this extension will allow a message to be shown on incompatible browsers.