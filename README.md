# ACF Term and Taxonomy Chooser

Addon plugin for Advanced Custom Fields to select a term or an entire taxonomy from a list of multiple allowed taxonomies.

![WordPress tested on version 5.2.3](https://img.shields.io/badge/WordPress-5.2.3-0073aa.svg?style=flat-square)
![ClassicPress tested on version 1.1.2](https://img.shields.io/badge/ClassicPress-1.1.2-03768e.svg?style=flat-square)
![PHP tested on version 7.3](https://img.shields.io/badge/PHP-tested%207.3-8892bf.svg?style=flat-square)
![ACF 5 Required](https://img.shields.io/badge/ACF%205-Required-00d3ae.svg?style=flat-square)

## Description

Advanced Custom Fields comes with a basic taxonomy field, but this limits you to only showing the terms from one taxonomy at a time. What if you want to show the terms from multiple taxonomies, or select the taxonomy itself?

ACF Term and Taxonomy Chooser adds a custom field type to ACF that lets you set whether you want to show a "Term" or "Taxonomy", a multiselect option of which Taxonomies to choose from, and whether you want to return the ID or the Slug (Terms only, Taxonomies just return slug)

When using the field in the editor, it will be a drop menu that lets you select a single term or a single taxonomy.

Compatible with Advanced Custom Fields v5/Pro

## FAQ

1. **Why would I want to use a taxonomy instead of a term?**
Lots of reasons! Though there's no such thing as a "taxonomy archive", you might want to display all terms in a selected taxonomy as a list of links, for example.

2. **Why can't I select multiple terms?**
That's not how this is built. There is a [multi-select taxonomy term ACF plugin](https://github.com/reyhoun/acf-multi-taxonomy-chooser) out there already that you can use to select multiple terms from multiple taxonomies, or use ACF's built in Taxonomy field to select multiple terms from a single taxonomy.

## Installation

1. Copy the `acf-taxonomy-chooser` folder into your `wp-content/plugins` folder
2. Activate the ACF Term and Taxonomy Chooser plugin on the Plugins admin page
3. When creating a new field in ACF, select Term and Taxonomy Chooser

## Compatibility

* The short array syntax ( `[]` rather than `array()` ) requires PHP 5.4+
* Advanced Custom Fields version 5 is required.
